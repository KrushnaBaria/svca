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
}
