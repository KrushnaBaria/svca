<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Esamaj extends BaseController
{
    public function index()
    {
        //
    }

    public function list()
    {
        return view('template/header', ['page_title' => 'Esamj Student']) . view('esamaj/list') . view('template/footer', ['app_init' => 'initEsamajList']);
    }
}
