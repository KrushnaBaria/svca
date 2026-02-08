<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\ExpenseModel;
use App\Models\StudentModel;
use App\Models\CenterModel;

class Dashboard extends BaseController
{
    private $expenseModel;
    private $studentModel;
    private $centerModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->expenseModel = model(ExpenseModel::class);
        $this->studentModel = model(StudentModel::class);
        $this->centerModel = model(CenterModel::class);
    }

    public function index()
    {   
        $data['centers'] = $this->centerModel->findAll();
        if(Auth()->user()->inGroup('superadmin')){
            return view('template/header', ['page_title' => 'Dashboard']). view('dashboard', $data).  view('template/footer', ['app_init' => 'initDashboard']);
        }else{
            return view('template/header', ['page_title' => 'Dashboard']). view('dashboard_ad', $data).  view('template/footer', ['app_init' => 'initAdDashboard']);
        }
        
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
        $filter = [
            'f_date' => $this->request->getPost('f_date'),
            'center_id' => $this->request->getPost('center_id'),
        ];

        $data = $this->expenseModel->getPERinfo($filter);
        if($data){
            return json_encode(['success' => 1, 'data' => $data]);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to get main report chart data']);
        }
    }

    public function get_Student_Count()
    {
        $filter = [
            'f_date' => $this->request->getPost('f_date'),
            'center_id' => $this->request->getPost('center_id'),
        ];

        $data = $this->studentModel->getStudentCount($filter);
        if($data){
            return json_encode(['success' => 1, 'data' => $data]);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to get main report chart data']);
        }
    }
}
