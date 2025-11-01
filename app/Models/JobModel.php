<?php
namespace App\Models;
use CodeIgniter\Model;

class JobModel extends Model
{
    protected $table = 'job_posts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employer_id', 'company_name', 'title', 'description', 'job_type', 'salary_range'
    ];
}
