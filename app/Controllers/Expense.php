<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\ExpenseModel;
use App\Models\CenterModel;
use App\Models\UserModel;

class Expense extends BaseController
{
    protected $model;
    protected $centertModel;
    protected $userModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(ExpenseModel::class);
        $this->centerModel = model(CenterModel::class);
        $this->userModel = model(UserModel::class);
    }

    public function index()
    {
        $data['centers'] = $this->centerModel->findAll();
        $data['users'] = $this->userModel->getUsers();
        return view('template/header', ['page_title' => 'Expense']) . view('expense/expense', $data) . view('template/footer', ['app_init' => 'initExpense']);
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
            'search' => $this->request->getPost('search')['value'] ?? '',
            'center_ftr' => $this->request->getPost('center_ftr'),
            'user_ftr' => $this->request->getPost('user_ftr'),
            'date_ftr' => $this->request->getPost('date_ftr'),
        ];

        $expenses = $this->model->getList($data);
        if($expenses){
            return json_encode($expenses);
        } else {
            return json_encode();
        }
    }
}
