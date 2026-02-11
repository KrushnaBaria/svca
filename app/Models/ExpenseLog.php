<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseLog extends Model
{
    protected $table            = 'expense_log';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'exp_id', 'remark', 'updated_by', 'updated_date'];

    public function add_log($exp_id, $data)
    {
        $query1 = "SELECT exp, amount FROM expenses WHERE id =".$exp_id."";
        $exp_data = $this->db->query($query1)->getResultArray();
        $remark = "";
        if(count($exp_data) > 0){
            if(!($exp_data[0]['exp'] == $data['exp'])){
                $remark .= "Change Title ". $exp_data[0]['exp'] ." To ".$data['exp'].".";
            }

            if(!($exp_data[0]['amount'] == $data['amount'])){
                $remark .= "Change Amount ". $exp_data[0]['amount'] ." To ".$data['amount'].".";
            }

            $query2 = "INSERT INTO expense_log (id, exp_id, remark, updated_by, updated_date) VALUES ('', ". $exp_id .", '". $remark ."', '". $data['updated_by'] ."', '". $data['updated_date'] ."')";
            $res = $this->db->query($query2);
            if($res){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function getExpenseLogs($data)
    {
        $searchQuery = "";
        if(!empty($data['search'])){
            $searchQuery = " AND (remark LIKE '%". $data['search'] ."%' OR exp_id LIKE '%". $data['search'] ."%' OR updated_by LIKE '%". $data['search'] ."%')";
        }

        $query = "SELECT * FROM expense_log WHERE 1=1 ". $searchQuery;

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY updated_date DESC LIMIT ". $data['start'] .", ". $data['end'];
        $result['data'] = $this->db->query($query)->getResultArray();
        
        return $result;
    }
}
