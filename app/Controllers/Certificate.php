<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\CertificateModel;
use App\Models\CenterModel;
use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\UserInfoModel;
use App\Models\StuCertificateModel;

class Certificate extends BaseController
{
    protected $model;
    protected $centerModel;
    protected $courseModel;
    protected $studentModel;
    protected $userInfoModel;
    protected $stuCertificateModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(CertificateModel::class);
        $this->centerModel = model(CenterModel::class);
        $this->courseModel = model(CourseModel::class);
        $this->userInfoModel = model(UserInfoModel::class);
        $this->studentModel = model(studentModel::class);
        $this->stuCertificateModel = model(stuCertificateModel::class);
    }

    public function index()
    {
        return View('template/header', ['page_title' => 'Certificate List']).View('certificate/list').View('template/footer', ['app_init' => 'initCertificateList']);
    }

    public function add()
    {
        $id = $this->request->getGet('id');

        if(Auth()->user()->inGroup('superadmin')){
            $data['centers'] = $this->centerModel->findAll();
            $data['courses'] = $this->courseModel->findAll();
        }else{
            $u_details = $this->userInfoModel->curUserDetail();
            $data['centers'] = $this->centerModel->where('id', $u_details['center'])->findAll();
        }

        if($id){
            $data['student'] = $this->studentModel->find($id);
        }

        return View('template/header', ['page_title' => 'Add Certificate']).View('certificate/add', $data).View('template/footer', ['app_init' => 'initAddCertificate']);
    }

    public function list()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value']
        ];
        $result = $this->model->getList($data);
        if($result){
            return json_encode($result);
        }else{
            return json_encode(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);
        }
    }

    public function save()
    {
        $data = $this->request->getPost();

        $studentName = $data['student_name'] ?? null;
        $center = $data['center'] ?? null;
        $certificateNo = $data['certificate_no'] ?? null;
        $issuedDateRaw = $data['issued_date'] ?? null;
        $telNumber = $data['tel_number'] ?? null;
        $fees = $data['fees'] ?? ($data['fees'] ?? null);
        $stu_id = $data['stu_id'] ?? ($data['stu_id'] ?? null);

        if ($studentName === null || $center === null || $certificateNo === null || $issuedDateRaw === null || $telNumber === null || $fees === null) {
            return $this->response->setJSON([ 'success' => 0, 'message' => 'Missing required fields.']);
        }

        $issue_date = date('Y-m-d', strtotime(str_replace('/', '-', $issuedDateRaw)));

        if($stu_id){
            $res = $this->stuCertificateModel->save([
                'id' => '',
                'stu_id' => $stu_id,
                'certificate_no' => $certificateNo,
                'issue_date' => $issue_date,
                'updated_by' => Auth()->user()->email,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
        }else{
            $res = $this->model->save([
                'name' => $studentName,
                'certificate_no' => $certificateNo,
                'fees' => $fees,
                'phone' => $telNumber,
                'center' => $center,
                'issue_date' => $issue_date,
                'updated_by' => Auth()->user()->email,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
        }
        
        if($res){
            return $this->response->setJSON(['success' => 1, 'message' => 'Certificate information saved successfully.']);
        }else{
            return $this->response->setJSON(['success' => 0, 'message' => 'Failed to save certificate information. Please try again.']);
        }
    }
}
