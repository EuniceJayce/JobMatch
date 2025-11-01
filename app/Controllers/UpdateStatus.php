<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class UpdateStatus extends Controller
{
    public function update_status()
    {
        $db = \Config\Database::connect();

        $application_id = $this->request->getPost('application_id');
        $status = $this->request->getPost('status');

        if (empty($application_id) || empty($status)) {
            return redirect()->back()->with('error', 'Missing data.');
        }

        $builder = $db->table('job_applications');
        $builder->where('id', $application_id);
        $updated = $builder->update(['status' => $status]);

        if ($updated) {
            return redirect()->back()->with('success', 'Status updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update status.');
        }
    }
}
