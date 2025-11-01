<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\JobPostModel;
use App\Models\UserModel;

class BossJobController extends Controller
{
    // ✅ Show all jobs of the logged-in employer
    public function dashboard()
    {
        $session = session();
        if (!$session->has('user_id')) {
            return redirect()->to('/login');
        }

        $user_id = $session->get('user_id');
        $userModel = new UserModel();
        $jobModel = new JobPostModel();

        $user = $userModel->find($user_id);
        $jobs = $jobModel->where('employer_id', $user_id)->findAll();

        return view('boss/boss_dashboard', [
            'full_name' => $user['full_name'],
            'jobs' => $jobs
        ]);
    }

    // ✅ Create new job post
    public function createJobPost()
    {
        $session = session();
        if (!$session->has('user_id')) {
            return redirect()->to('/login');
        }

        if ($this->request->getMethod() === 'POST') {
            $jobModel = new JobPostModel();
            $data = [
                'employer_id' => $session->get('user_id'),
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'job_type' => $this->request->getPost('job_type'),
                'salary_range' => $this->request->getPost('salary_range'),
                'company_name' => $this->request->getPost('company_name'),
                'date_posted' => date('Y-m-d H:i:s')
            ];
            $jobModel->insert($data);

            return redirect()->to('/boss_dashboard');
        }

        $company_name = session()->get('company_name'); // or whatever field holds it
$data = ['company_name' => $company_name];

return view('boss/create_jobpost', $data);

    }

    public function editJobPost($jobId = null)
        {
            $session = session();

            if (!$jobId) {
                return redirect()->to('/boss_dashboard')->with('error', 'No job ID provided.');
            }

            $jobModel = new \App\Models\JobPostModel();
            $job = $jobModel->asArray()->find($jobId);


            if (!$job) {
                return redirect()->to('/boss_dashboard')->with('error', 'Job not found.');
            }

            // ✅ Handle POST (update job)
            if ($this->request->getMethod() === 'POST') {
                
                $updatedData = [
                    'title'        => $this->request->getPost('title'),
                    'description'  => $this->request->getPost('description'),
                    'job_type'     => $this->request->getPost('job_type'),
                    'salary_range' => $this->request->getPost('salary_range'),
                    'company_name' => $this->request->getPost('company_name'),
                ];

                $jobModel->update($jobId, $updatedData);
                return redirect()->to(site_url('boss_dashboard'))->with('success', 'Job updated successfully!');
            }

            // ✅ Display edit form
            $data = [
                'job'          => $job,
                'company_name' => $session->get('company_name') ?? $job['company_name'] ?? '',
                'full_name'    => $session->get('full_name') ?? '',
            ];

            return view('boss/edit_jobpost', $data);
        }


    // ✅ Delete job post
    public function deleteJobPost()
    {
        $job_id = $this->request->getPost('job_id');
        $jobModel = new JobPostModel();
        $jobModel->delete($job_id);

        return redirect()->to('/boss_dashboard');
    }



    public function viewApplicants()
{
    $db = \Config\Database::connect();

    // Get all jobs posted by the logged-in employer
    $session = session();
    $employer_id = $session->get('user_id');

    $jobs = $db->query("SELECT * FROM job_posts WHERE employer_id = ?", [$employer_id])->getResultArray();

    // Pass jobs to view
    return view('boss/boss_view_applicants', ['jobs' => $jobs]);
}




}
