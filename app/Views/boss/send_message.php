<?php
session_start();
include 'db_connect.php';

// Make sure the boss is logged in
if (!isset($_SESSION['user_id'])) {
  echo "Unauthorized";
  exit;
}

$sender_id = $_SESSION['user_id']; // the boss (employer)
$receiver_id = $_POST['receiver_id']; // applicant user_id
$job_id = $_POST['job_id'];
$message = trim($_POST['message']);

if (empty($message)) {
  echo "Message cannot be empty.";
  exit;
}

$sql = "INSERT INTO messages (job_id, sender_id, receiver_id, message)
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $job_id, $sender_id, $receiver_id, $message);

if ($stmt->execute()) {
  echo "success";
} else {
  echo "error";
}
?>
