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

    $user = $db->table('users')->where('email', $email)->get()->getRow();

    if ($user && password_verify($password, $user->password)) {
        // ✅ Store basic session info
        $sessionData = [
            'user_id'    => $user->id,
            'role'       => $user->role,
            'full_name'  => $user->full_name,
            'isLoggedIn' => true,
        ];

        // ✅ If employer, get company_name from employers table
        if ($user->role === 'employer') {
            $employer = $db->table('employers')->where('user_id', $user->id)->get()->getRow();
            if ($employer) {
                $sessionData['company_name'] = $employer->company_name;
            }
        }

        $session->set($sessionData);

        // ✅ Redirect
        if ($user->role === 'employer') {
            return redirect()->to(site_url('boss_dashboard'));
        } elseif ($user->role === 'job_seeker') {
            return redirect()->to(site_url('emp_dashboard'));
        }
    }

    return redirect()->back()->with('error', 'Invalid email or password.');
}


    // ✅ REGISTRATION LOGIC
public function register()
{
    $db = \Config\Database::connect();

    $role = $this->request->getPost('role');

    // Insert into users table
    $userData = [
        'full_name' => $this->request->getPost('full_name'),
        'email'     => $this->request->getPost('email'),
        'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role'      => $role,
    ];

    $db->table('users')->insert($userData);
    $user_id = $db->insertID();

    // ✅ If Job Seeker, insert to job_seekers table
    if ($role === 'job_seeker') {
        $jobSeekerData = [
            'user_id'     => $user_id,
            'age'         => $this->request->getPost('age'),
            'gender'      => $this->request->getPost('gender'),
            'contact_no'  => $this->request->getPost('job_contact'),
        ];
        $db->table('job_seekers')->insert($jobSeekerData);
    }

    // ✅ If Employer, insert to employers table
    if ($role === 'employer') {
        $employerData = [
            'user_id'      => $user_id,
            'company_name' => $this->request->getPost('company_name'),
            'industry'     => $this->request->getPost('industry'),
            'contact_no'   => $this->request->getPost('emp_contact'),
        ];
        $db->table('employers')->insert($employerData);
    }

    // ✅ Instead of auto-login, show a success message and redirect to login page
    return redirect()->to(site_url('login'))
                     ->with('success', 'Account created successfully! Please log in to continue.');
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
