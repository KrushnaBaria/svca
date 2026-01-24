<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'course', 'price', 'center', 'type', 'updated_by', 'updated_date'];

    public function addCourse($data)
    {
        $query = "INSERT INTO `{$this->table}` (`id`, `course`, `price`, `center`, `type`, updated_by, updated_date) VALUES ('', '" . $data['course'] . "', '". $data['price'] ."', '". $data['center'] ."', '". $data['type'] ."', '". auth()->user()->email ."', NOW())";
        
        if ($this->db->query($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCourse($data)
    {
        $query = "UPDATE `{$this->table}` SET course = '" . $data['course'] . "', price = " . $data['price'] . ", center = '" . $data['center'] . "', type = '" . $data['type'] . "', updated_by = '" . auth()->user()->email . "', updated_date = NOW() WHERE id = " . $data['id'];
        if($this->db->query($query)){
            return true;
        }else{
            return false;
        }
    }

    public function getCourses($data)
    {
        $query = "SELECT c.*, centers.center as center_name FROM `{$this->table}` as c
                LEFT JOIN centers ON c.center = centers.id
                WHERE 1=1";
        if (isset($data['search']) && !empty($data['search'])) {
            $query .= " AND c.course LIKE '%" . $this->db->escapeLikeString($data['search']) . "%'";
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

    public function getCourseTypes($center_id)
    {
        $query = "SELECT DISTINCT type FROM courses WHERE center = " . $center_id;
        $result = $this->db->query($query)->getResultArray();
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }
}
