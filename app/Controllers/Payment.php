<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\PaymentModel;
use App\Models\StudentModel;
use App\Models\PaymentLog;

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
}
