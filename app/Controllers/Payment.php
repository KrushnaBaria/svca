<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\PaymentModel;
use App\Models\StudentModel;
use App\Models\PaymentLog;
use Dompdf\Dompdf;
use Dompdf\Options;

class Payment extends BaseController
{
    protected $model;
    protected $studentModel;
    protected $paymentLogModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->studentModel = model(StudentModel::class);
        $this->model = model(PaymentModel::class);
        $this->paymentLogModel = model(PaymentLog::class);
    }

    public function index($id)
    {
        $data['student'] = $this->studentModel->getStudentInfo($id);
        if(!$data['student']){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }
        return view('template/header', ['page_title' => 'Payment']) . view('student/fees', $data) . view('template/footer', ['app_init' => 'initAddPayment']);
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

        // Generate PDF using Dompdf (make sure dompdf/dompdf is installed via composer)
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
}
