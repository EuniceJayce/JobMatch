<?php

namespace App\Models;

use CodeIgniter\Model;

class JobPostModel extends Model
{
    protected $table = 'job_posts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employer_id', 'title', 'description', 'job_type', 'salary_range', 'company_name', 'date_posted'
    ];
}
