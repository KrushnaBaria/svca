<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\MyTaskModel;

class Task extends BaseController
{
    protected $model;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->model = model(MyTaskModel::class);
    }

    public function index()
    {
        return view('template/header', ['page_title' => 'All Users Task List'])
            . view('task/list')
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
        ];

        $res = $this->model->getAllTaskList($data);

        if ($res) {
            return json_encode($res);
        }

        return json_encode(['success' => 0, 'data' => []]);
    }
}

