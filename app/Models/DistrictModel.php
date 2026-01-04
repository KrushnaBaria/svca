<?php

namespace App\Models;

use CodeIgniter\Model;

class DistrictModel extends Model
{
    protected $table            = 'districts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'updated_by', 'updated_date'];

    public function addDistrict($data)
    {
        $query = "INSERT INTO `{$this->table}` (`id`, `name`, `updated_by`, `updated_date`) VALUES ('', '" . $data['district'] . "', '" . auth()->user()->email . "', NOW())";
        if($this->db->query($query)){
            return true;
        }else{
            return false;
        }
    }

    public function getDistricts($data)
    {
        $query = "SELECT * FROM `{$this->table}` WHERE 1=1";
        if (isset($data['search']) && !empty($data['search'])) {
            $query .= " AND `name` LIKE '%" . $data['search'] . "%'";
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
