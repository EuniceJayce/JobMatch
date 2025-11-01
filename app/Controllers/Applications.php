<?php

namespace App\Controllers;
use App\Models\ApplicationModel;
use CodeIgniter\Controller;

class SubmitApplication extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        $session = session();
        $request = service('request');
        $model = new ApplicationModel();

        $job_id = $request->getPost('job_id');
        $cover_letter = $request->getPost('cover_letter');
        $user_id = $session->get('user_id'); // Logged-in user

        // ✅ Get the corresponding seeker ID from job_seekers table
        $seeker = $db->query("SELECT id FROM job_seekers WHERE user_id = ?", [$user_id])->getRow();

        if (!$seeker) {
            return $this->response->setJSON(['success' => false, 'message' => 'No job seeker profile found.']);
        }

        $applicant_id = $seeker->id;

        // ✅ Check if already applied
        $existing = $model->where('job_id', $job_id)
                          ->where('applicant_id', $applicant_id)
                          ->first();
        if ($existing) {
            return $this->response->setJSON(['success' => false, 'message' => 'You have already applied for this job.']);
        }

        // ✅ Handle file upload
        $resumeFile = $this->request->getFile('resume');
        $resumeName = null;
        if ($resumeFile && $resumeFile->isValid()) {
            $resumeName = $resumeFile->getRandomName();
            $resumeFile->move('uploads/resumes', $resumeName);
        }

        // ✅ Insert new application
        $data = [
            'job_id' => $job_id,
            'applicant_id' => $applicant_id,
            'cover_letter' => $cover_letter,
            'resume' => $resumeName
        ];

        $model->insert($data);

        // ✅ Redirect back to Find Jobs (so the page updates)
        return redirect()->to('/emp_find_jobs')->with('success', 'Application submitted successfully!');
    }
}
