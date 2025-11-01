<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use Config\Database;

class MessageController extends Controller
{
    public function fetchMessages()
    {
        $db = Database::connect();
        $sender_id = session()->get('user_id');
        $receiver_id = $this->request->getPost('receiver_id');
        $job_id = $this->request->getPost('job_id');

        if (!$sender_id || !$receiver_id || !$job_id) {
            return $this->response->setJSON([]);
        }

        $query = $db->query("
            SELECT message, date_sent 
            FROM messages 
            WHERE sender_id = ? AND receiver_id = ? AND job_id = ?
            ORDER BY date_sent DESC
        ", [$sender_id, $receiver_id, $job_id]);

        return $this->response->setJSON($query->getResultArray());
    }
}
