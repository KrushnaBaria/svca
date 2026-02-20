<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\CenterModel;
use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\DistrictModel;
use App\Models\UserModel;
use App\Models\UserInfoModel;

class Student extends BaseController
{
    protected $model;
    protected $centerModel;
    protected $courseModel;
    protected $districtModel;
    protected $userModel;
    protected $userInfoModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(\App\Models\StudentModel::class);
        $this->centerModel = model(\App\Models\CenterModel::class);
        $this->courseModel = model(\App\Models\CourseModel::class);
        $this->districtModel = model(DistrictModel::class);
        $this->userModel = model(UserModel::class);
        $this->userInfoModel = model(UserInfoModel::class);
    }

    public function index()
    {   
        if(Auth()->user()->inGroup('superadmin')){
            $data['centers'] = $this->centerModel->findAll();
            $data['courses'] = $this->courseModel->findAll();
        }else{
            $u_details = $this->userInfoModel->curUserDetail();
            $data['centers'] = $this->centerModel->where('id', $u_details['center'])->findAll();
        }
        
        $data['districts'] = $this->districtModel->findAll();
        return view('template/header', ['page_title' => 'Student']) . view('student/add', $data) . view('template/footer', ['app_init' => 'initAddStudent']);
    }

    public function add()
    {
        $stu_id = $this->request->getPost('studentId');
        $remark = $this->request->getPost('remark') ? $this->request->getPost('remark') : '';
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
            'fees' => $this->request->getPost('course_amt'),
            'b_time' => $this->request->getPost('b_time'),
            'adhar' => $this->request->getPost('adhar'),
            'center' => $this->request->getPost('center'),
            'dist' => $this->request->getPost('dist'),
            'address' => $this->request->getPost('address'),
            'ref_by' => $this->request->getPost('ref_by'),
            'adm_date' => $this->request->getPost('adm_date'),
            'updated_by' => auth()->user()->email,
            'discount' => $this->request->getPost('discount') ? $this->request->getPost('discount') : 0,
        ];
        
        if($stu_id){
            $res = $this->model->updateStudent($stu_id, $data, $remark);
            if ($res) {
                return json_encode(['success' => 1]);
            } else {
                return json_encode(['success' => 0, 'message' => 'Failed to add student']);
            }
        }else{
            $res = $this->model->addStudent($data);
            if ($res) {
                return json_encode(['success' => 1]);
            } else {
                return json_encode(['success' => 0, 'message' => 'Failed to add student']);
            }
        }
    }

    public function edit($id)
    {
        $student = $this->model->getEditInfo($id);
        if (!$student) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }

        $data['student'] = $student[0];
        //$data['courses'] = $this->courseModel->findAll();
        $data['districts'] = $this->districtModel->findAll();
        if(Auth()->user()->inGroup('superadmin')){
            $data['centers'] = $this->centerModel->findAll();
        }else{
            $u_details = $this->userInfoModel->curUserDetail();
            $data['centers'] = $this->centerModel->where('id', $u_details['center'])->findAll();
        }

        return view('template/header', ['page_title' => 'Edit Student']) . view('student/edit', $data) . view('template/footer', ['app_init' => 'initEditStudent']);
    }

    public function update_delete_sts()
    {
        $id = $this->request->getPost('id');

        $data = [
            'del_sts' => 1,
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->email
        ];

        if ($this->model->update($id, $data)) {
            return json_encode(['success' => 1]);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to delete inquiry.']);
        }
    }

    public function view($id)
    {
        $student = $this->model->find($id);
        if (!$student) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }

        $data['student'] = $student;
        $data['centers'] = $this->centerModel->findAll();
        $data['courses'] = $this->courseModel->findAll();
        $data['districts'] = $this->districtModel->findAll();

        return view('template/header', ['page_title' => 'View Student']) . view('student/view', $data) . view('template/footer', ['app_init' => 'initViewStudent']);
    }

    public function list()
    {   
        if(Auth()->user()->inGroup('superadmin')){
            $data['centers'] = $this->centerModel->findAll();
            $data['users'] = $this->userModel->getUsers();
            $data['courses'] = $this->courseModel->findAll();
        }else{
            $u_details = $this->userInfoModel->curUserDetail();
            $data['centers'] = $this->centerModel->where('id', $u_details['center'])->findAll();
            $users = $this->userModel->getUsers();
            // Only include the user whose id matches $u_details['user_id'], if present
            $data['users'] = array_filter($users ?? [], function($user) use ($u_details) {
                return isset($u_details['user_id']) && $user['id'] == $u_details['user_id'];
            });
        }
        
        return view('template/header', ['page_title' => 'Student List']) . view('student/list', $data) . view('template/footer', ['app_init' => 'initStudentList']);
    }

    public function export()
    {
        $data = [
            'center_ftr' => $this->request->getGet('center_ftr'),
            'user_ftr'   => $this->request->getGet('user_ftr'),
            'date_ftr'   => $this->request->getGet('date_ftr'),
            'type_ftr'   => $this->request->getGet('type_ftr'),
        ];

        $students = $this->model->getStudentsForExport($data);

        $filename = 'students_' . date('Ymd_His') . '.csv';

        $response = service('response');
        $response->setHeader('Content-Type', 'text/csv; charset=utf-8');
        $response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $fh = fopen('php://temp', 'w');

        fputcsv($fh, ['SVCA Id', 'Name', 'Center', 'Number', 'Phone', 'Course', 'Referred By']);

        foreach ($students as $row) {
            fputcsv($fh, [
                $row['id'] ?? '',
                $row['name'] ?? '',
                $row['center_name'] ?? '',
                $row['pnumber'] ?? '',
                $row['apnumber'] ?? '',
                $row['course_name'] ?? '',
                $row['referred_by'] ?? '',
            ]);
        }

        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        return $response->setBody($csv);
    }

    public function getStudents()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? '',
            'center_ftr' => $this->request->getPost('center_ftr'),
            'user_ftr' => $this->request->getPost('user_ftr'),
            'date_ftr' => $this->request->getPost('date_ftr'),
            'type_ftr' => $this->request->getPost('type_ftr')
        ];

        $students = $this->model->getStudents($data);
        if ($students) {
            return json_encode($students);
        } else {
            return json_encode(['success' => 0, 'message' => 'No students found']);
        }
    }

    public function birthdayBuzz()
    {
        return view('template/header', ['page_title' => 'Birthday Buzz']) . view('student/birthday_buzz') . view('template/footer', ['app_init' => 'initBirthdayBuzz']);
    }

    public function getStuBirthday()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? '',
            'month' => $this->request->getPost('month'),
        ];

        $students = $this->model->getStuBirthday($data);
        if ($students) {
            return json_encode($students);
        } else {
            return json_encode(['success' => 0, 'message' => 'No students found']);
        }
    }
}
