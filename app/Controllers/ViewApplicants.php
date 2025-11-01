<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ViewApplicants extends Controller
{
    public function sendMessage()
    {
        $session = session();
        $db = \Config\Database::connect();

        $sender_id = $session->get('user_id'); // Employer
        $receiver_id = $this->request->getPost('receiver_id');
        $job_id = $this->request->getPost('job_id');
        $message = trim($this->request->getPost('message'));

        if (!$sender_id || !$receiver_id || !$job_id) {
            return redirect()->back()->with('error', 'Invalid request.');
        }

        if (empty($message)) {
            return redirect()->back()->with('error', 'Message cannot be empty.');
        }

        // Insert into messages table
        $builder = $db->table('messages');
        $builder->insert([
            'job_id'      => $job_id,
            'sender_id'   => $sender_id,
            'receiver_id' => $receiver_id,
            'message'     => $message,
            'date_sent'   => date('Y-m-d H:i:s')
        ]);

        if ($db->affectedRows() > 0) {
            return redirect()->back()->with('success', 'Message sent successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to send message.');
        }
    }
}
