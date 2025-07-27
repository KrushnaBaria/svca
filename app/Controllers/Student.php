<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\Center;
use App\Models\Course;
use App\Models\StudentModel;
use App\Models\DistrictModel;

class Student extends BaseController
{
    protected $model;
    protected $centerModel;
    protected $courseModel;
    protected $districtModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(\App\Models\StudentModel::class);
        $this->centerModel = model(\App\Models\Center::class);
        $this->courseModel = model(\App\Models\Course::class);
        $this->districtModel = model(DistrictModel::class);
    }

    public function index()
    {
        $data['centers'] = $this->centerModel->findAll();
        $data['courses'] = $this->courseModel->findAll();
        $data['districts'] = $this->districtModel->findAll();
        return view('template/header', ['page_title' => 'Student']) . view('student/add', $data) . view('template/footer', ['app_init' => 'initAddStudent']);
    }

    public function add()
    {
        $data = [
            's_name' => $this->request->getPost('s_name'),
            'f_name' => $this->request->getPost('f_name'),
            'm_name' => $this->request->getPost('m_name'),
            'dob' => $this->request->getPost('dob'),
            'p_number' => $this->request->getPost('p_number'),
            'ap_number' => $this->request->getPost('ap_number'),
            'gender' => $this->request->getPost('gender'),
            'marital_sts' => $this->request->getPost('marital_sts'),
            'cast' => $this->request->getPost('cast'),
            'lst_qulifi' => $this->request->getPost('lst_qulifi'),
            'per' => $this->request->getPost('per'),
            'course' => $this->request->getPost('course'),
            'b_time' => $this->request->getPost('b_time'),
            'adhar' => $this->request->getPost('adhar'),
            'center' => $this->request->getPost('center'),
            'dist' => $this->request->getPost('dist'),
            'address' => $this->request->getPost('address'),
            'ref_by' => $this->request->getPost('ref_by'),
            'adm_date' => $this->request->getPost('adm_date'),
        ];

        $res = $this->model->addStudent($data);
        if ($res) {
            return json_encode(['success' => 1]);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to add student']);
        }
    }

    public function list()
    {
        //$data['students'] = $this->model->getStudents();
        return view('template/header', ['page_title' => 'Student List']) . view('student/list') . view('template/footer', ['app_init' => 'initStudentList']);
    }

    public function getStudents()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? ''
        ];

        $students = $this->model->getStudents($data);
        if ($students) {
            return json_encode($students);
        } else {
            return json_encode(['success' => 0, 'message' => 'No students found']);
        }
    }
}
