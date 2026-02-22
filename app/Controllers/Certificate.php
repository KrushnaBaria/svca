<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Certificate extends BaseController
{
    public function index()
    {
        return View('template/header', ['page_title' => 'Certificate List']).View('certificate/list').View('template/footer', ['app_init' => 'initCertificateList']);
    }

    public function add()
    {
        return View('template/header', ['page_title' => 'Add Certificate']).View('certificate/add').View('template/footer', ['app_init' => 'initAddCertificate']);
    }
}
