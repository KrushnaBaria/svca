<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificateModel extends Model
{
    protected $table            = 'certificates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'certificate_no', 'phone', 'center', 'issue_date', 'updated_by', 'updated_date'];

    public function getList($data)
    {
        $query ="SELECT * FROM certificates
                LEFT JOIN centers ON certificates.center = centers.id
                WHERE 1=1";
        if($data['search'] != ''){
            $query .= " AND name LIKE '%".$data['search']."%'";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " LIMIT ".$data['start'].", ".$data['end'];

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }
}
