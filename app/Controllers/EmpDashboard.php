<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class EmpDashboard extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        $session = session();
        $user_id = $session->get('user_id');

        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        // ✅ Fetch the latest status for each job application
        $query = $db->query("
            SELECT 
                ja.id AS application_id,
                ja.job_id,   -- 👈 add this line
                ja.status,
                ja.date_applied,
                jp.title,
                jp.company_name,
                jp.salary_range,
                jp.job_type AS job_type,
                jp.description AS job_description
            FROM job_applications ja
            LEFT JOIN job_posts jp ON jp.id = ja.job_id
            WHERE ja.applicant_id = ?
            ORDER BY ja.date_applied DESC
        ", [$user_id]);

        $applications = $query->getResultArray();

        // ✅ Return data to view (DON’T exit)
        return view('employee/emp_dashboard', [
            'applications' => $applications
        ]);
    }
}
