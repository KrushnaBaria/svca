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

    public function getPayHistory()
    {
        
    }
}
