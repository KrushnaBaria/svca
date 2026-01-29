<?php

namespace App\Models;

use CodeIgniter\Model;

class UserInfoModel extends Model
{
    protected $table            = 'user_info';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'user_id', 'center', 'first_name', 'last_name', 'dob'];

    public function curUserDetail(){
        $user = auth()->user();
        if (!$user) {
            return null;
        }

        $query = "SELECT * FROM user_info WHERE user_id = ". $user->id ."";
        $result = $this->db->query($query)->getResultArray();
        if($result){
            return $result[0];
        }
    }
}
