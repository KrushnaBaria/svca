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
        $query = "SELECT * FROM my_task WHERE 1=1";

        $query .= " ORDER BY id DESC";

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        if($data['end'] != -1){
            $query .= " LIMIT ". $data['start'] .", ". $data['end'];
        }

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }
}
