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

        fputcsv($fh, ['No', 'Name', 'Center', 'Number', 'Phone', 'Course', 'Cast', 'DOB', 'Adhar Number', 'Admission Date']);

        $i = 0;
        foreach ($students as $row) {
            fputcsv($fh, [
                ++$i,
                ($row['name'] ?? '') . ' ' . ($row['fname'] ?? ''),
                $row['center_name'] ?? '',
                $row['pnumber'] ?? '',
                $row['apnumber'] ?? '',
                $row['course_name'] ?? '',
                $row['cast'] ?? '',
                !empty($row['dob']) ? date('d-m-Y', strtotime($row['dob'])) : '',
                $row['adhar'] ?? '',
                !empty($row['admi_date']) ? date('d-m-Y', strtotime($row['admi_date'])) : ''
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

    public function importForm()
    {
        return view('template/header', ['page_title' => 'Import Students']) . view('student/import') . view('template/footer', ['app_init' => 'initImportStudent']);
    }

    public function importCsv()
    {
        $file = $this->request->getFile('csv_file');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => 0, 'message' => 'Please upload a CSV file.']);
        }

        if (strtolower($file->getClientExtension()) !== 'csv') {
            return $this->response->setJSON(['success' => 0, 'message' => 'Only CSV files are allowed.']);
        }

        $handle = fopen($file->getTempName(), 'r');
        if (!$handle) {
            return $this->response->setJSON(['success' => 0, 'message' => 'Unable to read uploaded file.']);
        }

        $inserted = 0;
        $skipped  = 0;
        $errors   = [];
        $rowNum   = 0;

        // Use a transaction so that if any row fails, nothing is imported
        $db = $this->model->db;
        $db->transBegin();

        // Expected columns:
        // 0 => No
        // 1 => Student Name
        // 2 => Father Name
        // 3 => Center (name)
        // 4 => Course (name)
        // 5 => Admission Date (Y-m-d or d-m-Y)
        // 6 => Phone Number
        // 7 => Alternative Number

        // Skip header row
        if (($header = fgetcsv($handle)) === false) {
            fclose($handle);
            return $this->response->setJSON(['success' => 0, 'message' => 'CSV file is empty.']);
        }

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;

            if (count($row) < 9) {
                $errors[] = "Row {$rowNum}: Not enough columns.";
                continue;
            }

            $studentName = trim($row[1] ?? '');
            $fatherName  = trim($row[2] ?? '');
            $centerName  = trim($row[3] ?? '');
            $courseName  = trim($row[4] ?? '');
            $admDateRaw  = trim($row[5] ?? '');
            $phone       = trim($row[6] ?? '');
            $altPhone    = trim($row[7] ?? '');
            $fees        = trim($row[8] ?? '');

            if ($studentName === '' || $centerName === '' || $courseName === '' || $admDateRaw === '' || $phone === '') {
                $errors[] = "Row {$rowNum}: Missing required fields.";
                continue;
            }

            $center = $this->centerModel->where('center', $centerName)->first();
            $course = $this->courseModel->where('course', $courseName)->where('center', $center['id'])->first();

            if (!$center) {
                $errors[] = "Row {$rowNum}: Center not found.";
                continue;
            }

            if (!$course) {
                $errors[] = "Row {$rowNum}: Course not found.";
                continue;
            }

            if ($fees){
                $fees = $fees;
            }else{
                $fees = $course['price'];
            }

            $admDate = \DateTime::createFromFormat('Y-m-d', $admDateRaw)
                ?: \DateTime::createFromFormat('d-m-Y', $admDateRaw)
                ?: \DateTime::createFromFormat('d/m/Y', $admDateRaw);

            if ($admDate) {
                $admDateForModel = $admDate->format('d/m/Y');
            } else {
                $admDateForModel = '';
            }

            $data = [
                's_name'      => $studentName,
                'f_name'      => $fatherName,
                'm_name'      => '',
                'dob'         => '',
                'p_number'    => $phone,
                'ap_number'   => $altPhone,
                'gender'      => '',
                'marital_sts' => '',
                'cast'        => '',
                'lst_qulifi'  => '',
                'per'         => '',
                'course'      => $course['id'],
                'fees'        => $fees,
                'b_time'      => '',
                'adhar'       => '',
                'center'      => $center['id'],
                'dist'        => '',
                'address'     => '',
                'ref_by'      => '',
                'adm_date'    => $admDateForModel,
                'updated_by'  => auth()->user()->email,
                'discount'    => 0,
            ];
            
            $res = $this->model->addStudent($data);
            if ($res) {
                $inserted++;
            } else {
                $errors[] = "Row {$rowNum}: Failed to insert.";
            }
        }

        fclose($handle);

        // If there were any errors for any row, roll back the entire import
        if (!empty($errors)) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => 0,
                'message' => 'Import failed. No students were imported due to errors.',
                'errors'  => $errors,
            ]);
        }

        // Otherwise commit all inserted rows
        $db->transCommit();

        return $this->response->setJSON([
            'success'  => 1,
            'inserted' => $inserted,
            'skipped'  => $skipped,
            'errors'   => $errors,
        ]);
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
