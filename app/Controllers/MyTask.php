<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MyTask extends BaseController
{
    public function index()
    {
        return view('template/header', ['page_title' => 'My Task']) . view('task/my_task') . view('template/footer', ['app_init' => 'initMyTask']);
    }
}
