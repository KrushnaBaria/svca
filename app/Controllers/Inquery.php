<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\Center;
use App\Models\Course;
use App\Models\StudentModel;

class Inquery extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->centerModel = model(Center::class);
        $this->courseModel = model(Course::class);
        $this->studentModel = model(StudentModel::class);
    }

    public function index()
    {
        $data['centers'] = $this->centerModel->findAll();
        $data['courses'] = $this->courseModel->findAll();
        return view('template/header', ['page_title' => 'Inquery']) . view('inquery/inquery', $data) . view('template/footer', ['app_init' => 'initInquery']);
    }

    public function add()
    {   
        $id = $this->request->getPost('id');
        $data = [
            's_name' => $this->request->getPost('s_name'),
            'p_number' => $this->request->getPost('p_number'),
            'lst_qulifi' => $this->request->getPost('qulification'),
            'course' => $this->request->getPost('course'),
            'center' => $this->request->getPost('center'),
            //'ref_by' => $this->request->getPost('ref_by'),
            //'remark' => $this->request->getPost('remark'),
            'inq_date' => date('Y-m-d H:i:s'),
        ];

        if($id){
            if($this->studentModel->update_Inquiry($id, $data)) {
                return json_encode(['success' => 1]);
            }else{
                return json_encode(['success' => 0, 'message' => 'Failed to update inquiry.']);
            }
        }else{
            if ($this->studentModel->add_Inquiry($data)) {
                return json_encode(['success' => 1]);
            } else {
                return json_encode(['success' => 0, 'message' => 'Failed to save inquiry.']);
            }
        }        
    }

    public function list()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? ''
        ];

        $Inquerys = $this->studentModel->getInquerys($data);
        if ($Inquerys) {
            return json_encode($Inquerys);
        } else {
            return json_encode(['success' => 0, 'message' => 'No students found']);
        }
    }
}
