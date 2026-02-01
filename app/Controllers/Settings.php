<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\CenterModel;
use App\Models\CourseModel;
use App\Models\DistrictModel;

class Settings extends BaseController
{
    protected $centerModel;
    protected $courseModel;
    protected $districtModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->centerModel = model(CenterModel::class);
        $this->courseModel = model(CourseModel::class);
        $this->districtModel = model(DistrictModel::class);
    }

    public function index()
    {
        $data['centers'] = $this->centerModel->findAll();

        return view('template/header', ['page_title' => 'Settings']) . 
               view('settings', $data) .  
               view('template/footer', ['app_init' => 'initSettings']);
    }

    public function addCenter()
    {
        $data = [
            'center' => $this->request->getPost('center_name')
        ];

        $res = $this->centerModel->addCenter($data);
        if($res){
            return json_encode(['success' => 1]);
        }
    }

    public function deleteCenter()
    {
        $centerId = $this->request->getPost('center_id');

        $res = $this->centerModel->delete($centerId);
        if($res){
            return json_encode(['success' => 1, 'message' => 'Center deleted successfully.']);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to delete center.']);
        }
    }

    public function getCenters()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? ''
        ];

        $centers = $this->centerModel->getCenters($data);
        if(!empty($centers)){
            return json_encode($centers);
        }
    }

    public function addCourse()
    {
        $data = [
            'course' => $this->request->getPost('course_name'),
            'price' => $this->request->getPost('course_price'),
            'center' => $this->request->getPost('center'),
            'type' => $this->request->getPost('type')
        ];

        $res = $this->courseModel->addCourse($data);

        if($res){
            return json_encode(['success' => 1]);
        }
    }

    public function deleteCourse()
    {
        $courseId = $this->request->getPost('course_id');

        $res = $this->courseModel->delete($courseId);
        if($res){
            return json_encode(['success' => 1, 'message' => 'Course deleted successfully.']);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to delete course.']);
        }
    }

    public function getCourses()
    {   
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length')
        ];

        $courses = $this->courseModel->getCourses($data);
        if(!empty($courses)){
            return json_encode($courses);
        }
    }

    public function updateCouse()
    {
        $data = [
            'id' => $this->request->getPost('id'),
            'course' => $this->request->getPost('course_name'),
            'price' => $this->request->getPost('course_price'),
            'center' => $this->request->getPost('center'),
            'type' => $this->request->getPost('type')
        ];

        $res = $this->courseModel->updateCourse($data);

        if($res){
            return json_encode(['success' => 1]);
        }
    }

    public function addDidtrict()
    {
        $data = [
            'district' => $this->request->getPost('dist_name')
        ];

        $res = $this->districtModel->addDistrict($data);
        if($res){
            return json_encode(['success' => 1]);
        }else{
            return json_encode(['success' => 0, 'message' => 'Failed to add district']);
        }
    }

    public function deleteDistrict()
    {
        $districtId = $this->request->getPost('district_id');

        $res = $this->districtModel->delete($districtId);
        if($res){
            return json_encode(['success' => 1, 'message' => 'District deleted successfully.']);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to delete district.']);
        }
    }

    public function getDistricts()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length')
        ];

        $districts = $this->districtModel->getDistricts($data);
        if(!empty($districts)){
            return (json_encode($districts));
        }
    }
}
