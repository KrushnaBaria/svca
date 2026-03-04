<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\CenterModel;
use App\Models\CourseModel;
use App\Models\AttendanceModel;

class Attendance extends BaseController
{
    protected $centerModel;
    protected $courseModel;
    protected $attendanceModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->centerModel     = model(CenterModel::class);
        $this->courseModel     = model(CourseModel::class);
        $this->attendanceModel = model(AttendanceModel::class);
    }

    public function index()
    {
        if (auth()->user()->inGroup('superadmin')) {
            $data['centers'] = $this->centerModel->findAll();
        } else {
            $u_details       = model(\App\Models\UserInfoModel::class)->curUserDetail();
            $data['centers'] = $this->centerModel->where('id', $u_details['center'] ?? 0)->findAll();
        }

        $data['courses'] = $this->courseModel->findAll();

        return view('template/header', ['page_title' => 'Attendance']) .
               view('attendance/index', $data) .
               view('template/footer', ['app_init' => 'initAttendance']);
    }

    public function getStudents()
    {
        $attDateInput = $this->request->getPost('att_date');

        if (empty($attDateInput)) {
            return json_encode([
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ]);
        }

        // att_date is already Y-m-d from flatpickr config on UI
        $data = [
            'start'      => $this->request->getPost('start'),
            'end'        => $this->request->getPost('length'),
            'search'     => $this->request->getPost('search')['value'] ?? '',
            'att_date'   => $attDateInput,
            'center_ftr' => $this->request->getPost('center_ftr') ?? '',
            'type_ftr'   => $this->request->getPost('type_ftr') ?? '',
        ];

        $students = $this->attendanceModel->getStudentsForAttendance($data);

        return json_encode($students);
    }

    public function save()
    {
        $attDateInput = $this->request->getPost('att_date');
        $items        = $this->request->getPost('attendance');

        if (empty($attDateInput) || empty($items) || !is_array($items)) {
            return json_encode(['success' => 0, 'message' => 'Invalid attendance data.']);
        }

        $saved = $this->attendanceModel->saveAttendanceForDate($attDateInput, $items);

        if ($saved) {
            return json_encode(['success' => 1]);
        }

        return json_encode(['success' => 0, 'message' => 'Failed to save attendance.']);
    }
}

