<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\PaymentModel;
use App\Models\StudentModel;
use App\Models\PaymentLog;
use App\Models\CenterModel;
use App\Models\UserModel;
use App\Models\UserInfoModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Payment extends BaseController
{
    protected $model;
    protected $studentModel;
    protected $paymentLogModel;
    protected $centerModel;
    protected $userModel;
    protected $userInfoModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->studentModel = model(StudentModel::class);
        $this->model = model(PaymentModel::class);
        $this->paymentLogModel = model(PaymentLog::class);
        $this->centerModel = model(CenterModel::class);
        $this->userModel = model(UserModel::class);
        $this->userInfoModel = model(UserInfoModel::class);
    }

    public function index($id)
    {
        $data['student'] = $this->studentModel->getStudentInfo($id);
        if(!$data['student']){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }
        return view('template/header', ['page_title' => 'Payment']) . view('student/fees', $data) . view('template/footer', ['app_init' => 'initAddPayment']);
    }

    public function list()
    {
        $data['centers'] = $this->centerModel->findAll();
        $data['users'] = $this->userModel->getUsers();

        return view('template/header', ['page_title' => 'Payment List']) . view('payment/list', $data) . view('template/footer', ['app_init' => 'initPayment']);
    }

    public function getList()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'length' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? '',
            'center_ftr' => $this->request->getPost('center_ftr') ?? '',
            'user_ftr' => $this->request->getPost('user_ftr') ?? '',
            'date_ftr' => $this->request->getPost('date_ftr') ?? '',
        ];

        $paymentList = $this->model->getPaymentList($data);
        if($paymentList){
            return json_encode($paymentList);
        } else {
            return json_encode();
        }
    }

    public function pendingList()
    {

        if(Auth()->user()->inGroup('superadmin')){
            $data['centers'] = $this->centerModel->findAll();
        }else{
            $u_details = $this->userInfoModel->curUserDetail();
            $data['centers'] = $this->centerModel->where('id', $u_details['center'])->findAll();
        }

        return view('template/header', ['page_title' => 'Pending Fees List']) . view('payment/pending-list', $data) . view('template/footer', ['app_init' => 'initPendingPayList']);
    }

    public function getPendingList()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'length' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? '',
            'center_ftr' => $this->request->getPost('center_ftr') ?? '',
            'course_ftr' => $this->request->getPost('course_ftr') ?? '',
            'date_ftr' => $this->request->getPost('date_ftr') ?? '',
            'duration_ftr' => $this->request->getPost('duration_ftr') ?? '',
            'order' => $this->request->getPost('order'),
        ];

        $paymentList = $this->model->getPendingPayList($data);
        if($paymentList){
            return json_encode($paymentList);
        } else {
            return json_encode();
        }
    }

    public function add()
    {   
        $transaction_Id = $this->request->getPost('transaction_id');
        $Data = $this->request->getPost();
        if($transaction_Id){
            $payDetails = $this->model->where('id', $transaction_Id)->first();
            if($payDetails){
                if($payDetails['amount'] != $Data['amount']){
                    // Log the payment update
                    $payLog = $this->paymentLogModel->save([
                            'stu_id' => $payDetails['stu_id'],
                            'transaction_id' => $transaction_Id,
                            'remark' => 'Payment amount changed from ₹' . $payDetails['amount'] . ' to ₹' . $Data['amount'],
                            'updated_by' => auth()->user()->email,
                            'updated_date' => date('Y-m-d H:i:s'),
                        ]);
                    if(!$payLog){
                        return json_encode(['success' => 0, 'message' => 'Failed to log payment update.']);
                    }
                }
                $res = $this->model->update($transaction_Id, [
                    'amount' => $Data['amount'],
                    'pay_mod' => $Data['pay_mod'],
                    'discount' => $Data['discount'],
                    'remark' => $Data['remark'] ?? '',
                    'updated_by' => auth()->user()->email,
                    'updated_date' => date('Y-m-d H:i:s'),
                ]);
                if($res){
                    return json_encode(['success' => 1, 'message' => 'Payment updated successfully.']);
                } else {
                    return json_encode(['success' => 0, 'message' => 'Failed to update payment.']);
                }
            }else{
                return json_encode(['success' => 0, 'message' => 'Payment record not found.']);
            }
        }else{
            $res = $this->model->save([
                'stu_id' => $Data['student_id'],
                'amount' => $Data['amount'],
                'pay_mod' => $Data['pay_mod'],
                'discount' => $Data['discount'],
                'remark' => $Data['remark'] ?? '',
                'add_date' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->email,
                'updated_date' => date('Y-m-d H:i:s'),
            ]);
            if($res){
                return json_encode(['success' => 1, 'message' => 'Payment added successfully.']);
            } else {
                return json_encode(['success' => 0, 'message' => 'Failed to add payment.']);
            }
        }
    }

    public function getPayHistory()
    {
        $data = [
            'student_id' => $this->request->getPost('student_id'),
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? ''
        ];

        $payHistory = $this->model->getPayHistory($data);
        if($payHistory){
            return json_encode($payHistory);
        } else {
            return json_encode();
        }
    }

    public function invoice($id)
    {
        $student = $this->studentModel->getStudentInfo($id);
        if (!$student) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }

        // Get full payment history for this student
        $payments = $this->model
            ->where('stu_id', $id)
            ->orderBy('id', 'ASC')
            ->findAll();

        $totalFees = (float) ($student['fees'] ?? 0);
        $paidAmount = 0;
        foreach ($payments as $p) {
            $paidAmount += (float) $p['amount'];
        }
        $pendingAmount = $totalFees - $paidAmount;

        $data = [
            'student'       => $student,
            'payments'      => $payments,
            'totalFees'     => $totalFees,
            'paidAmount'    => $paidAmount,
            'pendingAmount' => $pendingAmount,
            'invoiceNo'     => 'INV-' . str_pad($student['id'], 6, '0', STR_PAD_LEFT),
            'generatedAt'   => date('d/m/Y H:i'),
        ];

        // Render invoice HTML from view
        $html = view('student/invoice', $data);

        // Generate PDF using Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'svca_receipt_' . $student['id'] . '_' . date('YmdHis') . '.pdf';

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($dompdf->output());
    }

    public function importCsv()
    {
        $file = $this->request->getFile('payment_csv_file');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => 0, 'message' => 'Please upload a CSV file.']);
        }

        if (strtolower($file->getClientExtension()) !== 'csv') {
            return $this->response->setJSON(['success' => 0, 'message' => 'Only CSV files are allowed.']);
        }

        $handle = fopen($file->getTempName(), 'r');
        if (!$handle) {
            return $this->response->setJSON(['success' => 0, 'message' => 'Unable to read uploaded file.']);
        }

        $inserted = 0;
        $skipped  = 0;
        $errors   = [];
        $rowNum   = 0;

        $db = $this->model->db;
        $db->transBegin();

        // Expected columns:
        // 0 => No
        // 1 => Student ID
        // 2 => Amount
        // 3 => Date (Y-m-d or d-m-Y)
        if (($header = fgetcsv($handle)) === false) {
            fclose($handle);
            return $this->response->setJSON(['success' => 0, 'message' => 'CSV file is empty.']);
        }

        $parseDate = function(string $raw){
            $raw = trim($raw);
            if ($raw === '') return null;

            $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $raw)
                ?: \DateTime::createFromFormat('d-m-Y H:i:s', $raw)
                ?: \DateTime::createFromFormat('d/m/Y H:i:s', $raw)
                ?: \DateTime::createFromFormat('Y-m-d', $raw)
                ?: \DateTime::createFromFormat('d-m-Y', $raw)
                ?: \DateTime::createFromFormat('d/m/Y', $raw);

            if (!$dt) return null;

            // If date had no explicit time, default to 00:00:00
            return $dt->format('Y-m-d') . ' 00:00:00';
        };

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;

            if (count($row) < 4) {
                $errors[] = "Row {$rowNum}: Not enough columns.";
                continue;
            }

            $stuIdRaw  = trim($row[1] ?? '');
            $amountRaw = trim($row[2] ?? '');
            $dateRaw   = trim($row[3] ?? '');

            $stuId = ctype_digit($stuIdRaw) ? (int) $stuIdRaw : 0;
            $amount = is_numeric($amountRaw) ? (float) $amountRaw : null;
            $addDate = $parseDate($dateRaw);

            if ($stuId <= 0 || $amount === null || $amount <= 0 || !$addDate) {
                $errors[] = "Row {$rowNum}: Invalid Student ID / Amount / Date.";
                continue;
            }

            $student = $this->studentModel
                ->where('id', $stuId)
                ->where('del_sts', 0)
                ->first();

            if (!$student) {
                $errors[] = "Row {$rowNum}: Student not found (ID {$stuId}).";
                continue;
            }

            $res = $this->model->save([
                'stu_id'       => $stuId,
                'amount'       => $amount,
                'remark'       => '',
                'add_date'     => $addDate,
                'updated_by'   => 'import@svca.com',
                'updated_date' => date('Y-m-d H:i:s'),
            ]);

            if ($res) {
                $inserted++;
            } else {
                $errors[] = "Row {$rowNum}: Failed to insert payment.";
            }
        }

        fclose($handle);

        if (!empty($errors)) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => 0,
                'message' => 'Import failed. No payments were imported due to errors.',
                'errors'  => $errors,
            ]);
        }

        $db->transCommit();

        return $this->response->setJSON([
            'success'  => 1,
            'inserted' => $inserted,
            'skipped'  => $skipped,
            'errors'   => $errors,
        ]);
    }
}
