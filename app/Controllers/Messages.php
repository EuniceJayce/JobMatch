<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Messages extends Controller
{
    public function fetchMessages($job_id)
    {
        $session = session();
        $user_id = $session->get('user_id');

        if (!$user_id || !$job_id) {
            return $this->response->setJSON(['error' => 'Invalid request.']);
        }

        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT m.message, m.date_sent, u.full_name AS sender_name
            FROM messages m
            JOIN users u ON m.sender_id = u.id
            WHERE m.receiver_id = ? AND m.job_id = ?
            ORDER BY m.date_sent DESC
        ", [$user_id, $job_id]);

        $messages = $query->getResultArray();

        if (empty($messages)) {
            return $this->response->setJSON(['messages' => []]);
        }

        return $this->response->setJSON(['messages' => $messages]);
    }
}
