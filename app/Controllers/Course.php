<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\CourseModel;


class Course extends BaseController
{   
    protected $model;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(CourseModel::class);
    }

    public function index()
    {

    }

    public function getCourseFee()
    {
        $course_id = $this->request->getPost('course_id');
        $course = $this->model->find($course_id);
        if($course){
            return json_encode(['success' => '1', 'fee' => $course['price']]);
        } else {
            return json_encode(['success' => '0', 'fee' => '']);
        }
    }
}
