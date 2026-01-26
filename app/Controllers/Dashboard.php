<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\ExpenseModel;
use App\Models\StudentModel;

class Dashboard extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->expenseModel = model(ExpenseModel::class);
        $this->studentModel = model(StudentModel::class);
    }

    public function index()
    {
        return view('template/header', ['page_title' => 'Dashboard']). view('dashboard').  view('template/footer', ['app_init' => 'initDashboard']);
    }

    public function getMainReportChartData()
    {
        $data = $this->expenseModel->getMainReportChartData();
        if($data){
            return json_encode(['success' => 1, 'data' => $data]);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to get main report chart data']);
        }
    }

    public function get_PRE()
    {
        $data = $this->expenseModel->getPERinfo();
        if($data){
            return json_encode(['success' => 1, 'data' => $data]);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to get main report chart data']);
        }
    }

    public function get_Student_Count()
    {
        $data = $this->studentModel->getStudentCount();
        if($data){
            return json_encode(['success' => 1, 'data' => $data]);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to get main report chart data']);
        }
    }
}
