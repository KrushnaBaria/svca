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
    protected $allowedFields    = ['id', 'user_id', 'task', 'updated_date'];

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

        $baseQuery = "SELECT mt.id, mt.user_id, mt.task, mt.updated_date, u.first_name, u.last_name
            FROM my_task AS mt
            LEFT JOIN users AS u ON u.id = mt.user_id";

        $countQuery = $baseQuery;

        $countResult = $this->db->query($countQuery)->getNumRows();

        if ($length !== -1) {
            $baseQuery .= " ORDER BY mt.id DESC LIMIT {$start}, {$length}";
        } else {
            $baseQuery .= " ORDER BY mt.id DESC";
        }

        $dataResult = $this->db->query($baseQuery)->getResultArray();

        return [
            'recordsTotal'    => $countResult,
            'recordsFiltered' => $countResult,
            'data'            => $dataResult,
        ];
    }
}
