<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;
use App\Models\UserInfoModel;

class UserInfo extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(UserInfoModel::class);
        $this->UserModel = model(UserModel::class);
    }

    public function index()
    {
        
    }

    public function AdminList()
    {
        return view('template/header', ['page_title' => 'Admin List']). view('admin_list').  view('template/footer', ['app_init' => 'initAdminList']);
    }

    public function getAdminList()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? '',
            // 'center_ftr' => $this->request->getPost('center_ftr'),
            // 'user_ftr' => $this->request->getPost('user_ftr'),
            // 'date_ftr' => $this->request->getPost('date_ftr'),
            // 'type_ftr' => $this->request->getPost('type_ftr')
        ];

        $admin_list = $this->UserModel->getAdminList($data);
        if ($admin_list) {
            return json_encode($admin_list);
        } else {
            return json_encode(['success' => 0, 'message' => 'No admin list found']);
        }
    }
}
