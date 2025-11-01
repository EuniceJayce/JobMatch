<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class EmpDashboard extends Controller
{
    public function index()
    {
        $session = session();
        $user_id = $session->get('user_id'); // ✅ logged in user's ID

        $db = \Config\Database::connect();

        // ✅ Get job seeker ID linked to this user
        $seeker = $db->query("SELECT id FROM job_seekers WHERE user_id = ?", [$user_id])->getRow();

        if (!$seeker) {
            $data['applications'] = [];
            return view('employee/emp_dashboard', $data);
        }

        $seeker_id = $seeker->id;

        // ✅ Fetch jobs this user applied for
        $data['applications'] = $db->query("
            SELECT jp.title, jp.company_name, jp.work_type, jp.salary_range, 
                   ja.date_applied, ja.status
            FROM job_applications ja
            JOIN job_posts jp ON ja.job_id = jp.id
            WHERE ja.applicant_id = ?
            ORDER BY ja.date_applied DESC
        ", [$seeker_id])->getResultArray();

        return view('employee/emp_dashboard', $data);
    }
}
