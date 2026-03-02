<?php

namespace App\Models;

use CodeIgniter\Model;

class StuCertificateModel extends Model
{
    protected $table            = 'stu_certificates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'stu_id', 'certificate_no', 'issue_date', 'updated_by', 'updated_date'];

    public function getList($data)
    {
        $search = $this->db->escapeLikeString($data['search'] ?? '');
        $start = (int) ($data['start'] ?? 0);
        $length = (int) ($data['end'] ?? 10);

        $query = "SELECT sc.id, sc.stu_id, sc.certificate_no, sc.issue_date, sc.updated_by, sc.updated_date,
            s.name, s.pnumber AS phone, s.fees, c.center
            FROM stu_certificates AS sc
            LEFT JOIN students AS s ON sc.stu_id = s.id
            LEFT JOIN centers AS c ON s.center = c.id
            WHERE 1=1";

        if ($search !== '') {
            $query .= " AND (s.name LIKE '%" . $search . "%' OR sc.certificate_no LIKE '%" . $search . "%' OR s.pnumber LIKE '%" . $search . "%')";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY sc.updated_date DESC";
        if($length != -1){
            $query .= " LIMIT " . $start . ", " . $length;
        }
        
        $result['data'] = $this->db->query($query)->getResultArray();

        return $result;
    }
}
