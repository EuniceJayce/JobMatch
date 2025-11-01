<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class JobController extends Controller
{
    public function create()
    {
        return view('create_jobpost');
    }

    public function create_jobpost()
    {
        // Example insert job posting logic here
    }
}
