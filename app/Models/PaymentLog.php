<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentLog extends Model
{
    protected $table            = 'payment_log';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'stu_id', 'transaction_id', 'remark', 'updated_by', 'updated_date'];

    public function getPaymentLogs($data)
    {
        $search = $data['search'];
        $start = $data['start'];
        $end = $data['end'];

        $query = "SELECT * FROM payment_log";
        
        if(!empty($search)){
            $query .= " WHERE stu_id LIKE '%". $search ."%' OR transaction_id LIKE '%". $search ."%' OR remark LIKE '%". $search ."%'";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " LIMIT ". $start .", ". $end;

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }
}
