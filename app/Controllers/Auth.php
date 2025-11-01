<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class Auth extends Controller
{
    // ✅ LOGIN PAGE
    public function index()
    {
        return view('auth/login');
    }

    // ✅ SIGNUP PAGE
    public function signup()
    {
        return view('auth/signup');
    }

    // ✅ LOGIN LOGIC
    public function login()
    {
        $db = Database::connect();
        $session = session();
    


        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Fetch user by email
        $user = $db->table('users')->where('email', $email)->get()->getRow();

        if ($user && password_verify($password, $user->password)) {
            // ✅ Set session
            $session->set([
                'user_id'    => $user->id,
                'role'       => $user->role,
                'full_name'  => $user->full_name,
                'isLoggedIn' => true,
            ]);

            // ✅ Redirect based on role
            if ($user->role === 'employer') {
                return redirect()->to(site_url('boss_dashboard'));
            } elseif ($user->role === 'job_seeker') {
                return redirect()->to(site_url('emp_dashboard'));
            }
        }

        // ❌ Invalid credentials
        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    // ✅ REGISTRATION LOGIC
    public function register()
    {
        $db = Database::connect();

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'      => $this->request->getPost('role'),
        ];

        $db->table('users')->insert($data);
        $user_id = $db->insertID();

        $session = session();
        $session->set([
            'user_id'    => $user_id,
            'role'       => $data['role'],
            'full_name'  => $data['full_name'],
            'isLoggedIn' => true,
        ]);

        if ($data['role'] === 'employer') {
            return redirect()->to(site_url('boss_dashboard'));
        } else {
            return redirect()->to(site_url('emp_dashboard'));
        }
    }

    // ✅ EMPLOYER DASHBOARD
    public function boss_dashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'employer') {
            return redirect()->to(site_url('login'));
        }

        $db = Database::connect();
        $employer_id = $session->get('user_id');

        $jobs = $db->table('job_posts')
                   ->where('employer_id', $employer_id)
                   ->orderBy('date_posted', 'DESC')
                   ->get()
                   ->getResultArray();

        return view('boss/boss_dashboard', [
            'jobs' => $jobs,
            'full_name' => $session->get('full_name')
        ]);
    }

    // ✅ JOB SEEKER DASHBOARD
    public function emp_dashboard()
{
    $session = session();
    $db = \Config\Database::connect();
    $user_id = $session->get('user_id');

    // ✅ Fetch all jobs this user applied for
    $sql = "
        SELECT 
            ja.id AS application_id,
            ja.date_applied,
            j.id AS job_id,
            j.title,
            j.description AS job_description,
            j.salary_range,
            j.job_type,
            COALESCE(e.company_name, j.company_name, 'Company not specified') AS company_name
        FROM job_applications ja
        JOIN job_posts j ON ja.job_id = j.id
        LEFT JOIN employers e ON e.user_id = j.employer_id
        WHERE ja.applicant_id = ?
        ORDER BY ja.date_applied DESC
    ";

    $apps = $db->query($sql, [$user_id])->getResultArray();

    return view('employee/emp_dashboard', [
        'applications' => $apps,
        'full_name' => $session->get('full_name'),
    ]);
}


    // ✅ LOGOUT
    public function logout()
{
    $session = session();
    $session->destroy();
    return redirect()->to('/login');
}

}
