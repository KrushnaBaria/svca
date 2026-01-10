<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\ExpenseModel;
use App\Models\Center;

class Expense extends BaseController
{
    protected $model;
    protected $centertModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(ExpenseModel::class);
        $this->centerModel = model(Center::class);
    }

    public function index()
    {
        $data['centers'] = $this->centerModel->findAll();
        return view('template/header', ['page_title' => 'Expense']). view('expense/expense', $data). view('template/footer', ['app_init' => 'initExpense']);
    }

    public function add()
    {
        $data = [
            'description' => $this->request->getPost('exp'),
            'center_id' => $this->request->getPost('center'),
            'amount' => $this->request->getPost('amount'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if($this->model->add($data)){
            return json_encode(['success' => '1', 'message' => 'Expense added successfully']);
        } else {
            return json_encode(['success' => '0', 'message' => 'Failed to add expense']);
        }
    }

    public function list()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? ''
        ];

        $expenses = $this->model->getList($data);
        if($expenses){
            return json_encode($expenses);
        } else {
            return json_encode();
        }
    }
}
