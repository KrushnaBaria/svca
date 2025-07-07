<?php

namespace App\Models;

use CodeIgniter\Model;

class Center extends Model
{
    protected $table            = 'centers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'center'];

    public function addCenter($data){
        $query = "INSERT INTO `{$this->table}` (center) VALUES ('" . $this->db->escapeString($data['center']) . "')";
        
        if(TRUE){
            return true;
        } else {
            return false;
        }
    }

    public function getCenters($data){
        $query = "SELECT * FROM `{$this->table}` WHERE 1=1";
        if(isset($data['search']) && !empty($data['search'])){
            $query .= " AND center LIKE '%" . $this->db->escapeLikeString($data['search']) . "%'";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows(); 

        $query .= " LIMIT ". $data['start'] .", ". $data['end'] ."";
        $result['data'] = $this->db->query($query)->getResultArray();
        
        if($result){
            return $result;
        } else {
            return [];
        }
    }
}
