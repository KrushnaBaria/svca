<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Expense extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        
    }

    public function index()
    {
        return view('template/header', ['page_title' => 'Expense']). 
               view('expense').  
               view('template/footer', ['app_init' => 'initExpense']);
    }
}
