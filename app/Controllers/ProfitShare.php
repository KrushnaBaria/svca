<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\ExpenseModel;

class ProfitShare extends BaseController
{
    private $expenseModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->expenseModel = model(ExpenseModel::class);
    }

    public function index()
    {
        return view('template/header', ['page_title' => 'Profit Share Dashboard']). view('profit_share_dashboard').  view('template/footer', ['app_init' => 'initProfitShare']);
    }

    public function getTotalProfit()
    {
        $date = $this->request->getPost('f_date');
        $data = $this->expenseModel->getTotalProfit($date);
        if($data){
            return json_encode(['success' => 1, 'data' => $data]);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to fetch data.']);
        }
    }
}
