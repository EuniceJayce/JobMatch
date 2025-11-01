<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class FindJobs extends Controller
{
    public function index()
    {
        $session = session();

        // ✅ Make sure user is logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        $db = Database::connect();
        $user_id = $session->get('user_id');

        // ✅ Get user info
        $user = $db->table('users')->where('id', $user_id)->get()->getRow();

        // ✅ Get all job posts
        $jobs = $db->table('job_posts')
                   ->orderBy('date_posted', 'DESC')
                   ->get()
                   ->getResultArray();

        // ✅ Get list of job IDs user already applied for
        $appliedJobs = $db->table('job_applications')
                          ->select('job_id')
                          ->where('applicant_id', $user_id)
                          ->get()
                          ->getResultArray();

        // ✅ Convert to plain array for easy in_array() check
        $appliedJobs = array_column($appliedJobs, 'job_id');

        // ✅ Pass everything to view
        return view('employee/emp_find_jobs', [
            'jobs' => $jobs,
            'appliedJobs' => $appliedJobs,
            'full_name' => $user->full_name ?? 'User'
        ]);
    }
}
