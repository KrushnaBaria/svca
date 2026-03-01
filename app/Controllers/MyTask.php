<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\MyTaskModel;

class MyTask extends BaseController
{
    protected $model;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(MyTaskModel::class);
    }

    public function index()
    {
        return view('template/header', ['page_title' => 'My Task']) . view('task/my_task') . view('template/footer', ['app_init' => 'initMyTask']);
    }

    public function add()
    {
        $task = $this->request->getPost('task');

        $res = $this->model->save([
            'user_id' => auth()->user()->id,
            'task' => $task,
            'updated_date' => date('Y-m-d H:i:s')
        ]);

        if($res){
            return json_encode(['success' => 1, 'message' => 'successfully Added']);
        } else {
            return json_encode(['success' => 0, 'message' => 'There are some error adding task']);
        }
    }

    public function list()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? ''
        ];

        $res = $this->model->getList($data);

        if($res){
            return json_encode($res);
        } else {
            return json_encode(['success' => 0, 'data' => []]);
        }
    }
}
