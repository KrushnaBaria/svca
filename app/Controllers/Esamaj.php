<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\EsamajModel;

class Esamaj extends BaseController
{
    protected $model;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(EsamajModel::class);
    }

    public function index()
    {
        //
    }

    public function list()
    {
        return view('template/header', ['page_title' => 'Esamj Student']) . view('esamaj/list') . view('template/footer', ['app_init' => 'initEsamajList']);
    }

    public function get_list()
    {
            $data = [
                'search' => $this->request->getPost('search'),
                'order' => $this->request->getPost('order'),
                'start' => $this->request->getPost('start'),
                'length' => $this->request->getPost('length')
            ];
        $res = $this->model->getList($data);

        if($res){
            return json_encode($res);
        } else {
            return json_encode(['success' => 0, 'message' => 'No data found']);
        }
    }

    public  function add()
    {
        return view('template/header', ['page_title' => 'Add Esamaj Student']) . view('esamaj/add') . view('template/footer', ['app_init' => 'initEsamajAdd']);
    }
}
