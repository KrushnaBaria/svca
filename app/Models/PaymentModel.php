<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['stu_id', 'amount', 'pay_mod', 'discount', 'remark', 'add_date', 'updated_by', 'updated_date'];

    public function getPayHistory($data)
    {
        $query = "SELECT * FROM payment WHERE stu_id = " . $data['student_id'];

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY id ASC LIMIT " . $data['start'] . ", " . $data['end'];
        
        $result['data'] = $this->db->query($query)->getResultArray();

        $query_total_fee = "SELECT SUM(amount) as total_paid FROM payment WHERE stu_id = " . $data['student_id'];
        $total_paid = $this->db->query($query_total_fee)->getRowArray();

        $result['total_paid'] = $total_paid['total_paid'] ? $total_paid['total_paid'] : 0;

        return $result;
    }

    public function getPaymentList($data)
    {
        // If date_ftr is set as a string like "21-01-2026 to 28-01-2026", convert it to start and end dates
        $date_ftr = isset($data['date_ftr']) ? trim($data['date_ftr']) : '';
        $start_date = '';
        $end_date = '';

        if (!empty($date_ftr)) {
            $parts = explode('to', $date_ftr);
            $start_date = $parts[0];
            $end_date = $parts[1];
        }

        $query = "SELECT p.*, s.name, s.center, c.center as center_name FROM payment AS p
                    LEFT JOIN students AS s ON p.stu_id = s.id 
                    LEFT JOIN centers AS c ON s.center = c.id
                    WHERE 1=1";

        if(isset($data['center_ftr']) && !empty($data['center_ftr'])) {
            $query .= " AND s.center = " . trim($data['center_ftr']) . "";
        }

        if(isset($data['user_ftr']) && !empty($data['user_ftr'])) {
            $query .= " AND p.updated_by LIKE '%". trim($data['user_ftr']) ."%'";
        }

        if($start_date && $end_date){
            $query .= " AND DATE(p.add_date) BETWEEN '" . trim($start_date) . "' AND '" . trim($end_date) . "' ";
        }

        // if (isset($data['search']) && !empty($data['search'])) {
        //     $search = $data['search'];
        //     $query .= " WHERE p.remark LIKE '%$search%' OR u.username LIKE '%$search%'";
        // }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();
        
        $query .= " ORDER BY p.id DESC LIMIT " . $data['start'] . ", " . $data['length'];
        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }

    public function getPendingPayList($data)
    {
        $date_ftr = isset($data['date_ftr']) ? trim($data['date_ftr']) : '';
        $start_date = '';
        $end_date = '';

        if (!empty($date_ftr)) {
            $parts = explode('to', $date_ftr);
            $start_date = $parts[0];
            $end_date = $parts[1];
        }

        $query = "SELECT s.id, s.name, s.admi_date, c.center as center_name, co.course as course_name, s.fees as total_fees, 
                    (SELECT IFNULL(SUM(amount), 0) FROM payment WHERE stu_id = s.id) as paid_amount
                    FROM students AS s
                    LEFT JOIN centers AS c ON s.center = c.id
                    LEFT JOIN courses AS co ON s.course = co.id
                    WHERE (s.fees - (SELECT IFNULL(SUM(amount), 0) FROM payment WHERE stu_id = s.id)) > 0";

        if(isset($data['center_ftr']) && !empty($data['center_ftr'])) {
            $query .= " AND s.center = " . trim($data['center_ftr']) . "";
        }

        if(isset($data['course_ftr']) && !empty($data['course_ftr'])) {
            $query .= " AND s.course = " . trim($data['course_ftr']) . "";
        }

        if($start_date && $end_date){
            $query .= " AND DATE(s.admi_date) BETWEEN '" . trim($start_date) . "' AND '" . trim($end_date) . "' ";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();
        
        $query .= " ORDER BY s.id DESC LIMIT " . $data['start'] . ", " . $data['length'];
        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }
}
