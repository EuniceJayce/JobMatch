<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\JobSeekerModel;

class EmployeeProfile extends Controller
{
    public function index()
    {
        $session = session();

        if (!$session->has('user_id')) {
            return redirect()->to('/login');
        }

        $user_id = $session->get('user_id');

        $userModel = new UserModel();
        $jobSeekerModel = new JobSeekerModel();

        $emp = $userModel
            ->select('users.id AS user_id, users.full_name, users.email, job_seekers.id AS seeker_id, job_seekers.age, job_seekers.gender, job_seekers.contact_no, job_seekers.profile_picture, job_seekers.resume_path')
            ->join('job_seekers', 'users.id = job_seekers.user_id')
            ->where('users.id', $user_id)
            ->first();

        return view('employee/emp_profile', [
            'emp' => $emp,
            'user_id' => $user_id
        ]);
    }

public function uploadResume()
{
    $user_id = $this->request->getPost('user_id');
    $file = $this->request->getFile('resume');

    if ($file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();

        // Make sure upload folder exists
        $uploadPath = FCPATH . 'uploads/resumes';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $file->move($uploadPath, $newName);

        $resumePath = 'uploads/resumes/' . $newName;

        // ✅ Use JobSeekerModel, not UserModel
        $jobSeekerModel = new JobSeekerModel();
        $seeker = $jobSeekerModel->where('user_id', $user_id)->first();

        if ($seeker) {
            $jobSeekerModel->update($seeker['id'], [
                'resume_path' => $resumePath
            ]);
        }

        return redirect()->to('/emp_profile')->with('success', 'Resume uploaded successfully!');
    }

    return redirect()->back()->with('error', 'Resume upload failed!');
}


    // ✅ Upload Profile Picture
public function uploadProfile()
{
    $user_id = $this->request->getPost('user_id');
    $file = $this->request->getFile('profile_image');

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();

        // Make sure the uploads folder exists
        $uploadPath = FCPATH . 'uploads/profile_pictures';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Move the uploaded file
        $file->move($uploadPath, $newName);

        // Get the correct job seeker record using user_id
        $jobSeekerModel = new JobSeekerModel();
        $seeker = $jobSeekerModel->where('user_id', $user_id)->first();

        if ($seeker) {
            $jobSeekerModel->update($seeker['id'], [
                'profile_picture' => 'uploads/profile_pictures/' . $newName // ✅ fixed path
            ]);
        }
    }

    return redirect()->to('emp_profile');
}


    // ✅ Delete Resume
    public function deleteResume()
    {
        $user_id = $this->request->getPost('user_id');

        $jobSeekerModel = new JobSeekerModel();
        $seeker = $jobSeekerModel->where('user_id', $user_id)->first();

        if ($seeker && !empty($seeker['resume_path']) && file_exists($seeker['resume_path'])) {
            unlink($seeker['resume_path']);
        }

        if ($seeker) {
            $jobSeekerModel->update($seeker['id'], ['resume_path' => null]);
        }

        return redirect()->to('emp_profile');
    }

    // ✅ Update Profile
    public function updateProfile()
    {
        $user_id = $this->request->getPost('user_id');

        $userModel = new UserModel();
        $jobSeekerModel = new JobSeekerModel();

        // Update user info
        $userModel->update($user_id, [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
        ]);

        // Find and update job seeker info
        $seeker = $jobSeekerModel->where('user_id', $user_id)->first();

        if ($seeker) {
            $jobSeekerModel->update($seeker['id'], [
                'age' => $this->request->getPost('age'),
                'gender' => $this->request->getPost('gender'),
                'contact_no' => $this->request->getPost('contact_no'),
            ]);
        }

        return redirect()->to('emp_profile');
    }
}
