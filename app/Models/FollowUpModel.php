<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowUpModel extends Model
{
    protected $table            = 'follow_up';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'stu_id', 'note', 'status', 'follow_date', 'added_date', 'added_by'];

    public function getFollowUps($data)
    {
        $start = $data['start'] ?? 0;
        $end = $data['end'] ?? 10;
        $search = $data['search'] ?? '';

        $query = "SELECT * FROM follow_up WHERE stu_id = ". $data['student_id'] ."";

        if (!empty($search)) {
            $query .= " AND (note LIKE '%" . $search . "%' OR status LIKE '%" . $search . "%')";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();
        $query .= " ORDER BY added_date DESC";

        if($end != -1) {
            $query .= " LIMIT $start, $end";
        }

        $result['data'] = $this->db->query($query)->getResultArray();

        return $result;
    }

    public function todayFollowUps()
    {
        $start = $data['start'] ?? 0;
        $end = $data['end'] ?? 10;
        $search = $data['search'] ?? '';

        $center_ad = '';
        if(!Auth()->user()->inGroup('superadmin')){
            $query1 = "SELECT center FROM user_info WHERE user_id = ". auth()->user()->id ."";
            $center_ad = $this->db->query($query1)->getResultArray();
            if($center_ad){
                $center_ad = $center_ad[0]['center'];
            }
        }

        $today = date('Y-m-d');
        $query = "SELECT f.*, s.name as stu_name, s.pnumber as phone, c.course as course_name, ce.center as center_name FROM follow_up AS f
                JOIN students s ON f.stu_id = s.id
                JOIN courses c ON s.course = c.id
                JOIN centers ce ON s.center = ce.id
                WHERE DATE(f.follow_date) = '$today'";
        if($center_ad){
            $query .= " AND ce.id = '$center_ad'";
        }
        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();
        
        $query .= " ORDER BY f.added_date DESC";
        if($end != -1) {
            $query .= " LIMIT $start, $end";
        }

        $result['data'] = $this->db->query($query)->getResultArray();

        return $result;
    }
}
