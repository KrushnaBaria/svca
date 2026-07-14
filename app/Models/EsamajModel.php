<?php

namespace App\Models;

use CodeIgniter\Model;

class EsamajModel extends Model
{
    protected $table            = 'esmj_student';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'phone',
        'alt_phone',
        'reg_id',
        'password',
        'address',
        'cheque',
        'undertaking',
        'verify',
        'remark',
    ];

    public function importStudent(array $data): bool|int
    {
        return $this->insert($data);
    }

    public function regIdExists(int $regId): bool
    {
        return $this->where('reg_id', $regId)->countAllResults() > 0;
    }

    public function getList($data)
    {
        $query = "SELECT * FROM esmj_student WHERE 1=1";

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        if($data['length'] != -1){
            $query .= " LIMIT {$data['start']}, {$data['length']}";
        }

        $result['data'] = $this->db->query($query)->getResult();

        return $result;
    }
}
