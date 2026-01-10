<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table            = 'expenses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function add($data)
    {
        $query = "INSERT INTO expenses (id, exp, center, amount) VALUES (NULL, '" . $data['description'] . "', '" . $data['center_id'] . "', '" . $data['amount'] . "')";
         if($this->db->query($query)){
            return true;
        } else {
            return false;
        };
    }

    public function getList($data)
    {
        $start = $data['start'];
        $end = $data['end'];
        $search = $data['search'];

        $query = "SELECT e.id, e.exp, c.center, e.amount, c.center AS center_name
                  FROM expenses e 
                  JOIN centers c ON e.center = c.id ";

        if(!empty($search)){
            $query .= " WHERE e.exp LIKE '%" . $search . "%' OR c.center LIKE '%" . $search . "%' ";
        }

        $query .= " ORDER BY e.id DESC LIMIT " . $start . ", " . $end;

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }
}
