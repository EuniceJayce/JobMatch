<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id'])) {
    $job_id = intval($_POST['job_id']);

    // Step 1: Delete all applications for that job
    $deleteApplications = $conn->prepare("DELETE FROM applications WHERE job_id = ?");
    $deleteApplications->bind_param("i", $job_id);
    $deleteApplications->execute();

    // Step 2: Delete the job post itself
    $deleteJob = $conn->prepare("DELETE FROM job_posts WHERE id = ?");
    $deleteJob->bind_param("i", $job_id);
    $deleteJob->execute();

    // Step 3: Redirect with success message
    header("Location: boss_view_applicants.php?deleted=1");
    exit;
} else {
    header("Location: boss_view_applicants.php?error=1");
    exit;
}
?>
