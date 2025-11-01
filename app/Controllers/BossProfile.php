<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BossProfile extends Controller
{
    public function index()
    {
        $session = session();
        $db = \Config\Database::connect();
        $user_id = $session->get('user_id');

        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        // Fetch employer + user info
        $query = $db->query("
            SELECT 
                u.full_name, 
                u.email, 
                e.company_name, 
                e.industry, 
                e.contact_no, 
                e.website, 
                e.profile_image
            FROM users u
            LEFT JOIN employers e ON u.id = e.user_id
            WHERE u.id = ?
        ", [$user_id]);

        $company = $query->getRowArray();

        if (!$company) {
            $company = [
                'full_name' => $session->get('full_name') ?? 'Unknown',
                'email' => $session->get('email') ?? 'No email found',
                'company_name' => 'Not set',
                'industry' => 'Not set',
                'contact_no' => 'Not set',
                'website' => '',
                'profile_image' => ''
            ];
        }

        return view('boss/boss_profile', ['company' => $company]);
    }

    // ✅ Upload profile image
    public function uploadProfile()
    {
        $session = session();
        $db = \Config\Database::connect();
        $user_id = $session->get('user_id');

        $file = $this->request->getFile('profile_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/profile_pictures/'; // full path for moving

            // make sure folder exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // move file to correct folder
            $file->move($uploadPath, $newName);

            // store relative path for web access
            $path = 'uploads/profile_pictures/' . $newName;

            $builder = $db->table('employers');
            $builder->where('user_id', $user_id);
            $builder->update(['profile_image' => $path]);

            return redirect()->to('/boss_profile')->with('success', 'Profile picture updated successfully!');
        }

        return redirect()->to('/boss_profile')->with('error', 'Failed to upload image.');
    }

    // ✅ Update profile info
    public function updateProfile()
    {
        $session = session();
        $db = \Config\Database::connect();
        $user_id = $session->get('user_id');

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email')
        ];

        // Update users table
        $db->table('users')->where('id', $user_id)->update($data);

        // Update employer details
        $db->table('employers')->where('user_id', $user_id)->update([
            'company_name' => $this->request->getPost('company_name'),
            'industry' => $this->request->getPost('industry'),
            'contact_no' => $this->request->getPost('contact_no')
        ]);

        return redirect()->to('/boss_profile')->with('success', 'Profile updated successfully!');
    }

    // ✅ Update website
    public function updateWebsite()
    {
        $session = session();
        $db = \Config\Database::connect();
        $user_id = $session->get('user_id');
        $website = $this->request->getPost('website');

        $db->table('employers')->where('user_id', $user_id)->update(['website' => $website]);

        return redirect()->to('/boss_profile')->with('success', 'Website added successfully!');
    }

    // ✅ Delete website
    public function deleteWebsite()
    {
        $session = session();
        $db = \Config\Database::connect();
        $user_id = $session->get('user_id');

        $db->table('employers')->where('user_id', $user_id)->update(['website' => '']);

        return redirect()->to('/boss_profile')->with('success', 'Website removed successfully!');
    }
}
