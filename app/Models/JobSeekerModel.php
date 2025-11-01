<?php

namespace App\Models;

use CodeIgniter\Model;

class JobSeekerModel extends Model
{
    protected $table = 'job_seekers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'age', 'gender', 'contact_no', 'profile_picture', 'resume_path'];
}
