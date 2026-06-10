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
    protected $allowedFields    = ['id', 'name', 'certificate_no', 'fees', 'phone', 'center', 'issue_date', 'updated_by', 'updated_date'];

    public function getList($data)
    {

        $center_ad = '';
        if(!Auth()->user()->inGroup('superadmin')){
            $query1 = "SELECT center FROM user_info WHERE user_id = ". auth()->user()->id ."";
            $center_ad = $this->db->query($query1)->getResultArray();
            if($center_ad){
                $center_ad = $center_ad[0]['center'];
            }
        }

        $query ="SELECT * FROM certificates
                LEFT JOIN centers ON certificates.center = centers.id
                WHERE 1=1";
        if($data['search'] != ''){
            $query .= " AND name LIKE '%".$data['search']."%'";
        }

        if($center_ad){
            $query .= " AND certificates.center = " . $center_ad . "";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        if($data['end'] != -1){
            $query .= " LIMIT ".$data['start'].", ".$data['end'];
        }

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }
}
