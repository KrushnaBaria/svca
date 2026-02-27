<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\CertificateModel;
use App\Models\CenterModel;
use App\Models\CourseModel;

class Certificate extends BaseController
{
    protected $model;
    protected $centerModel;
    protected $courseModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(CertificateModel::class);
        $this->centerModel = model(CenterModel::class);
        $this->courseModel = model(CourseModel::class);
    }

    public function index()
    {
        return View('template/header', ['page_title' => 'Certificate List']).View('certificate/list').View('template/footer', ['app_init' => 'initCertificateList']);
    }

    public function add()
    {
        if(Auth()->user()->inGroup('superadmin')){
            $data['centers'] = $this->centerModel->findAll();
            $data['courses'] = $this->courseModel->findAll();
        }else{
            $u_details = $this->userInfoModel->curUserDetail();
            $data['centers'] = $this->centerModel->where('id', $u_details['center'])->findAll();
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
        $issue_date = date('Y-m-d', strtotime(str_replace('/', '-', $data['issued_date'])));

        $res = $this->model->save([
            'name' => $data['student_name'],
            'certificate_no' => $data['certificate_no'],
            'fees' => $data['fees'],
            'phone' => $data['tel_number'],
            'center' => $data['center'],
            'issue_date' => $issue_date,
            'updated_by' => Auth()->user()->email,
            'updated_date' => date('Y-m-d H:i:s')
        ]);
        if($res){
            return json_encode(['success' => 1, 'message' => 'Certificate information saved successfully.']);
        }else{
            return json_encode(['success' => 0, 'message' => 'Failed to save certificate information. Please try again.']);
        }
    }
}
