<?php

namespace App\Models;

use CodeIgniter\Model;

class MyTaskModel extends Model
{
    protected $table            = 'my_task';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'user_id', 'task', 'status', 'approve', 'updated_date'];

    public function getList($data)
    {
        $query = "SELECT * FROM my_task WHERE DATE(updated_date) = CURDATE() AND user_id = ". auth()->user()->id . "";

        $query .= " ORDER BY id DESC";

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        if ($data['end'] != -1) {
            $query .= " LIMIT " . $data['start'] . ", " . $data['end'];
        }

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }

    public function getAllTaskList($data)
    {
        $start  = (int) $data['start'];
        $length = (int) $data['end'];

        if (!empty($data['date_ftr'])) {
            $parts = explode('to', $data['date_ftr']);
            $start_date = $parts[0];
            $end_date = $parts[1];
        }

        $baseQuery = "SELECT mt.id, mt.user_id, mt.task, mt.updated_date, ui.first_name, ui.last_name, u.secret AS email, c.center AS center_name
            FROM my_task AS mt
            LEFT JOIN user_info AS ui ON ui.user_id = mt.user_id
            LEFT JOIN auth_identities AS u ON u.id = mt.user_id
            LEFT JOIN centers AS c ON c.id = ui.center WHERE 1=1";

        if (!empty($data['search'])) {
            $baseQuery .= " AND (ui.first_name LIKE '%{$data['search']}%' OR ui.last_name LIKE '%{$data['search']}%' OR u.secret LIKE '%{$data['search']}%' OR c.center LIKE '%{$data['search']}%' OR mt.task LIKE '%{$data['search']}%')";
        }

        if (!empty($data['center_ftr'])) {
            $baseQuery .=" AND c.id = '{$data['center_ftr']}'";
        }

        if (!empty($data['date_ftr'])) {
            $baseQuery .= " AND DATE(mt.updated_date) BETWEEN '" . trim($start_date) . "' AND '" . trim($end_date) . "' ";
        }

        if (!empty($data['user_ftr'])) {
            $baseQuery .= " AND u.secret = '{$data['user_ftr']}'";
        }

        $countQuery = $baseQuery;

        $countResult = $this->db->query($countQuery)->getNumRows();

        if ($length !== -1) {
            $baseQuery .= " ORDER BY mt.id DESC LIMIT {$start}, {$length}";
        } else {
            $baseQuery .= " ORDER BY mt.id DESC";
        }

        $dataResult = $this->db->query($baseQuery)->getResultArray();

        //print_r($dataResult); exit;

        return [
            'recordsTotal'    => $countResult,
            'recordsFiltered' => $countResult,
            'data'            => $dataResult,
        ];
    }
}
