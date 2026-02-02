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
}
