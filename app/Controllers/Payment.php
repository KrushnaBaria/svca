<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\PaymentModel;
use App\Models\StudentModel;

class Payment extends BaseController
{
    protected $model;
    protected $studentModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->studentModel = model(StudentModel::class);
        $this->model = model(PaymentModel::class);
    }

    public function index($id)
    {
        $data['student'] = $this->studentModel->where('id', $id)->first();
        return view('template/header', ['page_title' => 'Payment']) . view('student/fees', $data) . view('template/footer', ['app_init' => 'initAddPayment']);
    }

    public function add()
    {
        $postData = $this->request->getPost();
        $res = $this->model->save([
            'stu_id' => $postData['student_id'],
            'amount' => $postData['amount'],
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
