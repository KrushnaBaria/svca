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

    public function ChangePassword($id)
    {   
        $data['user_id'] = $id;
        return view('template/header', ['page_title' => 'Change Password']). view('change_password', $data).  view('template/footer', ['app_init' => 'initChangePassword']);
    }

    public function updatePassword()
    {
        $data = [
            'user_id' => $this->request->getPost('user_id'),
            'new_password' => $this->request->getPost('new_password'),
            'confirm_password' => $this->request->getPost('confirm_password')
        ];

        if ($data['new_password'] !== $data['confirm_password']) {
            return json_encode(['success' => 0, 'message' => 'New password and confirm password do not match']);
        }
        
        $users = auth()->getProvider();
        $user = $users->findById($data['user_id']);

        $user->fill([
            'password' => $data['confirm_password']
        ]);

        $update = $users->save($user);

        if ($update) {
            return json_encode(['success' => 1, 'message' => 'Password updated successfully']);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to update password']);
        }
    }

    public function deleteUser()
    {
        $user_id = $this->request->getPost('user_id');

        $user_info_dlt = $this->model->where('user_id', $user_id)->delete();

        if(!$user_info_dlt){
            return json_encode(['success' => 0, 'message' => 'Failed to delete user info']);
        }

        $users = auth()->getProvider();

        $user = $users->findById($user_id);
        $delete = $users->delete($user->id, true);

        if ($delete) {
            return json_encode(['success' => 1, 'message' => 'User deleted successfully']);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to delete user']);
        }
    }

    public function changeStatus()
    {
        $user_id = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');

        $user = auth()->getProvider()->findById($user_id);

        if ($user) {
            if($status == 1){
                $user->ban('You are currently not part of this organization');
            } else {
                $user->unBan();
            }
            
            return json_encode(['success' => 1, 'message' => 'User status updated successfully']);

        } else {
            return json_encode(['success' => 0, 'message' => 'User not found']);
        }
    }
}
