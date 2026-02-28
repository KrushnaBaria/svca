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
}
