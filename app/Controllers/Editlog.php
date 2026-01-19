<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\EditlogModel;

class Editlog extends BaseController
{
    private $model;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(EditlogModel::class);
    }

    public function index()
    {
        return view('template/header', ['page_title' => 'Logs']). view('logs').  view('template/footer', ['app_init' => 'initLogs']);
    }

    public function getStudentEditLogs()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? ''
        ];

        $logs = $this->model->getStudentEditLogs($data);
        if($logs){
            return json_encode($logs);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to get student edit logs']);
        }
    }
}
