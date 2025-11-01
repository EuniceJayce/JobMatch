<?php

namespace App\Controllers;

use App\Models\ApplicationModel;
use CodeIgniter\Controller;
use Config\Database;

class SubmitApplication extends Controller
{
    public function index()
    {
        $session = session();
        $request = service('request');
        $model = new ApplicationModel();

        // ✅ Check login
        if (!$session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to apply.'
            ]);
        }

        if (session()->get('role') !== 'employee') {
            return redirect()->back()->with('error', 'Only employees can apply for jobs.');
        }


        $job_id = $request->getPost('job_id');
        $cover_letter = $request->getPost('cover_letter');
        $applicant_id = $session->get('user_id');

        // ✅ Validate job ID
        if (empty($job_id) || !is_numeric($job_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid job ID. Please try again.'
            ]);
        }

        // ✅ Check if already applied
        $existing = $model->where('job_id', $job_id)
                          ->where('applicant_id', $applicant_id)
                          ->first();

        if ($existing) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You have already applied for this job.'
            ]);
        }

        // ✅ Handle file upload (resume)
        $resumeFile = $this->request->getFile('resume');
        $resumeName = null;

        if ($resumeFile && $resumeFile->isValid() && !$resumeFile->hasMoved()) {
            $resumeName = $resumeFile->getRandomName();
            $resumeFile->move(FCPATH . 'uploads/resumes', $resumeName);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please upload a valid resume file.'
            ]);
        }

        // ✅ Save to database
        $data = [
            'job_id' => $job_id,
            'applicant_id' => $applicant_id,
            'cover_letter' => $cover_letter,
            'resume' => $resumeName,
        ];

        $model->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Application submitted successfully!',
            'job_id' => $job_id
        ]);
    }
}
