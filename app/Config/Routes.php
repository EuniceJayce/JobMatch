<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');

$routes->get('signup', 'Auth::signup');
$routes->post('signup', 'Auth::register');

$routes->get('boss_dashboard', 'Auth::boss_dashboard');


// ✅ keep this only once
$routes->get('emp_find_jobs', 'FindJobs::index');



// ✅ for submitting job applications
$routes->post('submit_application', 'SubmitApplication::index');


$routes->get('emp_dashboard', 'EmpDashboard::index');

$routes->get('emp_profile', 'EmployeeProfile::index');
$routes->post('emp_profile/uploadResume', 'EmployeeProfile::uploadResume');
$routes->post('emp_profile/uploadProfile', 'EmployeeProfile::uploadProfile');
$routes->post('emp_profile/deleteResume', 'EmployeeProfile::deleteResume');
$routes->post('emp_profile/updateProfile', 'EmployeeProfile::updateProfile');

$routes->get('logout', 'Auth::logout');



// ✅ Boss (Employer) Dashboard + Job Management
$routes->get('boss_dashboard', 'BossJobController::dashboard');

// Create job post
$routes->get('create_jobpost', 'BossJobController::createJobPost');
$routes->post('create_jobpost', 'BossJobController::createJobPost');


// ✅ Edit job post routes (with numeric job ID)

$routes->get('edit_jobpost/(:num)', 'BossJobController::editJobPost/$1');
$routes->post('edit_jobpost/(:num)', 'BossJobController::editJobPost/$1');


// Delete job post
$routes->post('delete_jobpost', 'BossJobController::deleteJobPost');


// View applicants for a specific job
$routes->get('boss_view_applicants', 'BossJobController::viewApplicants');


// Update applicant status


// Send message to applicant

$routes->post('update_status', 'UpdateStatus::update_status');

$routes->get('fetch_messages/(:num)', 'Messages::fetchMessages/$1');


$routes->post('send_message', 'ViewApplicants::sendMessage');

$routes->post('fetch_sent_messages', 'MessageController::fetchMessages');



$routes->get('/boss_profile', 'BossProfile::index');
$routes->post('/upload_profile', 'BossProfile::uploadProfile');
$routes->post('/update_profile', 'BossProfile::updateProfile');
$routes->post('/update_website', 'BossProfile::updateWebsite');
$routes->post('/delete_website', 'BossProfile::deleteWebsite');




