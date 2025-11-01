<?php
namespace App\Models;
use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'job_applications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['job_id', 'applicant_id', 'cover_letter', 'resume' ,'status',          // ← MUST be here
        'date_applied'];
    
    // 🚫 Disable auto timestamps
    protected $useTimestamps = false;
}
