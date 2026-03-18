<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;
use App\Models\UserInfoModel;
use App\Models\CenterModel;

class UserInfo extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(UserInfoModel::class);
        $this->UserModel = model(UserModel::class);
        $this->centerModel = model(CenterModel::class);
    }

    public function index()
    {
        
    }

    public function profile()
    {
        $userInfo = $this->model->curUserDetail();
        $authUser = auth()->user();
        $centerName = '';
        if ($userInfo && !empty($userInfo['center'])) {
            $center = $this->centerModel->find($userInfo['center']);
            $centerName = $center['center'] ?? '';
        }
        $data = [
            'user_info' => $userInfo,
            'auth_user' => $authUser,
            'center_name' => $centerName,
        ];
        return view('template/header', ['page_title' => 'My Profile'])
            . view('user/profile', $data)
            . view('template/footer');
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

    public function edit($id)
    {
        // Only superadmin can edit other users; admins can edit only themselves
        $authUser = auth()->user();
        if (!$authUser) {
            return redirect()->to('/');
        }

        $isSuperAdmin = Auth()->user()->inGroup('superadmin');
        if (!$isSuperAdmin && (int) $authUser->id !== (int) $id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $userInfo = $this->model->where('user_id', $id)->first();
        if (!$userInfo) {
            // Allow editing even if user_info row is missing (create on save)
            $userInfo = [
                'user_id' => (int) $id,
                'center' => null,
                'first_name' => '',
                'last_name' => '',
                'dob' => null,
            ];
        }

        if ($isSuperAdmin) {
            $centers = $this->centerModel->findAll();
        } else {
            $cur = $this->model->curUserDetail();
            $centers = $cur && !empty($cur['center'])
                ? $this->centerModel->where('id', $cur['center'])->findAll()
                : [];
        }

        $data = [
            'user_info' => $userInfo,
            'centers' => $centers,
        ];

        return view('template/header', ['page_title' => 'Edit User'])
            . view('user/edit', $data)
            . view('template/footer');
    }

    public function updateInfo()
    {
        $authUser = auth()->user();
        if (!$authUser) {
            return redirect()->to('/');
        }

        $id = (int) $this->request->getPost('user_id');
        $isSuperAdmin = Auth()->user()->inGroup('superadmin');
        if (!$isSuperAdmin && (int) $authUser->id !== $id) {
            return redirect()->back()->with('error', 'You are not allowed to update this user.');
        }

        $rules = [
            'user_id' => 'required|is_natural_no_zero',
            'center' => 'required|is_natural_no_zero',
            'first_name' => 'required|string|min_length[1]|max_length[100]',
            'last_name' => 'required|string|min_length[1]|max_length[100]',
            'dob' => 'permit_empty|valid_date[Y-m-d]',
        ];

        $payload = $this->request->getPost([
            'user_id',
            'center',
            'first_name',
            'last_name',
            'dob',
        ]);

        if (! $this->validateData($payload, $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'user_id' => $id,
            'center' => (int) $payload['center'],
            'first_name' => trim((string) $payload['first_name']),
            'last_name' => trim((string) $payload['last_name']),
            'dob' => !empty($payload['dob']) ? $payload['dob'] : null,
        ];

        $existing = $this->model->where('user_id', $id)->first();
        if ($existing) {
            $ok = $this->model->where('user_id', $id)->set($data)->update();
        } else {
            $ok = (bool) $this->model->insert($data);
        }

        if (!$ok) {
            return redirect()->back()->withInput()->with('error', 'Failed to update user.');
        }

        return redirect()->to('/user/admin-list');
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
