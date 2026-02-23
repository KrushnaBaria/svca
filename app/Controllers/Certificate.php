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
}
