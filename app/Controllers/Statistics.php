<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\ExpenseModel;
use App\Models\CenterModel;

class Statistics extends BaseController
{
    private $expenseModel;
    private $centerModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->expenseModel = model(ExpenseModel::class);
        $this->centerModel = model(CenterModel::class);
    }

    public function index()
    {
        return view('template/header', ['page_title' => 'Statistics']). view('statistics').  view('template/footer', ['app_init' => 'initStatistics']);
    }

    public function getExpense()
    {
        $year = $this->request->getPost('year');
        //$center_id = session()->get('center_id');
        $expenseData = $this->expenseModel->stsExpense($year);
        return $this->response->setJSON($expenseData);
    }

    public function getProfit()
    {
        $year = $this->request->getPost('year');
        $center_id = session()->get('center_id');
        $profitData = $this->centerModel->getMonthlyProfit($center_id, $year);
        return $this->response->setJSON($profitData);
    }
}
