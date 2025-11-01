<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployerModel extends Model
{
    protected $table = 'employers';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_id', 'company_name'];
}
