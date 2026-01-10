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
    protected $allowedFields    = ['stu_id', 'amount', 'add_date', 'updated_by', 'updated_date'];

    public function getPayHistory($data)
    {
        $query = "SELECT * FROM payment WHERE stu_id = " . $data['student_id'];
        $query .= " ORDER BY id ASC LIMIT " . $data['start'] . ", " . $data['end'];
        
        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();
        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }
}
