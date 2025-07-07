<?php

namespace App\Models;

use CodeIgniter\Model;

class Course extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'course'];

    public function addCourse($data)
    {
        $query = "INSERT INTO `{$this->table}` (course) VALUES ('" . $this->db->escapeString($data['course']) . "')";
        
        if ($this->db->query($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function getCourses($data)
    {
        $query = "SELECT * FROM `{$this->table}` WHERE 1=1";
        if (isset($data['search']) && !empty($data['search'])) {
            $query .= " AND course LIKE '%" . $this->db->escapeLikeString($data['search']) . "%'";
        }
        
        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " LIMIT " . $data['start'] . ", " . $data['end'];
        $result['data'] = $this->db->query($query)->getResultArray();
        
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }
}
