<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

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
}
