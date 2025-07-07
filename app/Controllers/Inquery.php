<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\Center;
use App\Models\Course;

class Inquery extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->centerModel = model(Center::class);
        $this->courseModel = model(Course::class);
    }

    public function index()
    {
        $data['centers'] = $this->centerModel->findAll();
        $data['courses'] = $this->courseModel->findAll();
        return view('template/header', ['page_title' => 'Inquery']) . view('inquery/inquery', $data) . view('template/footer', ['app_init' => 'initInquery']);
    }
}
