<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\MyTaskModel;
use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\DistrictModel;
use App\Models\UserModel;
use App\Models\CenterModel;

class Task extends BaseController
{
    protected $model;
    protected $centerModel;
    protected $courseModel;
    protected $districtModel;
    protected $userModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->model = model(MyTaskModel::class);
        $this->centerModel = model(CenterModel::class);
        $this->courseModel = model(CourseModel::class);
        $this->districtModel = model(DistrictModel::class);
        $this->userModel = model(UserModel::class);
    }

    public function index()
    {
        if(Auth()->user()->inGroup('superadmin')){
            $data['centers'] = $this->centerModel->findAll();
            $data['users'] = $this->userModel->getUsers();
            $data['courses'] = $this->courseModel->findAll();
        }

        return view('template/header', ['page_title' => 'All Users Task List'])
            . view('task/list', $data)
            . view('template/footer', ['app_init' => 'initTaskList']);
    }

    public function list()
    {
        $data = [
            'start'  => $this->request->getPost('start'),
            'end'    => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? '',
        ];

        $res = $this->model->getList($data);

        if ($res) {
            return json_encode($res);
        }

        return json_encode(['success' => 0, 'data' => []]);
    }

    public function all_list()
    {
        $data = [
            'start'  => $this->request->getPost('start'),
            'end'    => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? '',
            'center_ftr' => $this->request->getPost('center_ftr') ?? '',
            'date_ftr' => $this->request->getPost('date_ftr') ?? '',
            'user_ftr' => $this->request->getPost('user_ftr') ?? '',
        ];

        $res = $this->model->getAllTaskList($data);

        if ($res) {
            return json_encode($res);
        }

        return json_encode(['success' => 0, 'data' => []]);
    }
}

