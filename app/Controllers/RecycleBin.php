<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\StudentModel;

class RecycleBin extends BaseController
{
    private $studentModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->studentModel = model(StudentModel::class);
    }

    public function index()
    {
        return view('template/header', ['page_title' => 'Recycle Bin']). view('recycle_bin').  view('template/footer', ['app_init' => 'initRecycleBin']);
    }

    public function getDeletedStudents()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? ''
        ];

        $deletedStudents = $this->studentModel->getDeletedStudents($data);
        if($deletedStudents){
            return json_encode($deletedStudents);
        } else {
            return json_encode(['data' => []]);
        }
    }

    public function getDeletedInquiries()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? ''
        ];

        $deletedInquiries = $this->studentModel->getDeletedInquiries($data);
        if($deletedInquiries){
            return json_encode($deletedInquiries);
        } else {
            return json_encode(['data' => []]);
        }
    }

    public function deleteStudent()
    {
        $studentId = $this->request->getPost('student_id');
        $res = $this->studentModel->where('id', $studentId)->delete();
        if($res){
            return json_encode(['success' => 1, 'message' => 'Student deleted permanently.']);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to delete student.']);
        }
    }

    public function restoreStudent()
    {
        $studentId = $this->request->getPost('student_id');
        $res = $this->studentModel->update($studentId, ['del_sts' => 0, 'updated_by' => auth()->user()->email, 'updated_date' => date('Y-m-d H:i:s')]);
        if($res){
            return json_encode(['success' => 1, 'message' => 'Student restored successfully.']);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to restore student.']);
        }
    }

    public function deleteInquiry()
    {
        $inquiryId = $this->request->getPost('inquiry_id');
        $res = $this->studentModel->where('id', $inquiryId)->delete();
        if($res){
            return json_encode(['success' => 1, 'message' => 'Inquiry deleted permanently.']);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to delete inquiry.']);
        }
    }

    public function restoreInquiry()
    {
        $inquiryId = $this->request->getPost('inquiry_id');
        $res = $this->studentModel->update($inquiryId, ['del_sts' => 0, 'updated_by' => auth()->user()->email, 'updated_date' => date('Y-m-d H:i:s')]);
        if($res){
            return json_encode(['success' => 1, 'message' => 'Inquiry restored successfully.']);
        } else {
            return json_encode(['success' => 0, 'message' => 'Failed to restore inquiry.']);
        }
    }
}
