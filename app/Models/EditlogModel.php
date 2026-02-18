<?php

namespace App\Models;

use CodeIgniter\Model;

class EditlogModel extends Model
{
    protected $table            = 'edit_log';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'remark', 'student_id', 'updated_date', 'updated_by'];

    public function getStudentEditLogs($data)
    {
        $query = "SELECT * FROM edit_log WHERE 1=1 ";
        $query .= " ORDER BY id DESC";

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        if($data['end'] != -1) {
            $query .= " LIMIT ". $data['start'] .", ". $data['end'];
        }
        
        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }
}
