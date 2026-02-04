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
        $query .= " ORDER BY added_date DESC LIMIT $start, $end";

        $result['data'] = $this->db->query($query)->getResultArray();

        return $result;
    }
}
