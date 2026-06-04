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

    public function getCourseType()
    {
        $center_id = $this->request->getPost('center_id');
        $types = $this->model->getCourseTypes($center_id);
        if($types){
            return json_encode(['success' => '1', 'types' => $types]);
        } else {
            return json_encode(['success' => '0', 'types' => []]);
        }
    }

    public function getCourseByCenter()
    {
        $center_id = $this->request->getPost('center_id');
        $courses = $this->model->where(['center' => $center_id])->findAll();
        if($courses){
            return json_encode(['success' => '1', 'courses' => $courses]);
        } else {
            return json_encode(['success' => '0', 'courses' => []]);
        }
    }

    public function getCoursesByType()
    {
        $center_id = $this->request->getPost('center_id');
        $type = $this->request->getPost('type');
        $courses = $this->model->where(['center' => $center_id, 'type' => $type])->findAll();
        if($courses){
            return json_encode(['success' => '1', 'courses' => $courses]);
        } else {
            return json_encode(['success' => '0', 'courses' => []]);
        }
    }
}
