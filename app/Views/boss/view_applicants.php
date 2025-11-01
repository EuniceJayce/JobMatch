<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['company_id'])) {
  header("Location: login.php");
  exit;
}

if (!isset($_GET['job_id'])) {
  die("Invalid request.");
}

$job_id = $_GET['job_id'];
$company_id = $_SESSION['company_id'];

// Verify job belongs to employer
$check = $conn->prepare("SELECT * FROM job_posts WHERE id = ? AND employer_id = ?");
$check->bind_param("ii", $job_id, $company_id);
$check->execute();
$job = $check->get_result()->fetch_assoc();

if (!$job) {
  die("Access denied.");
}

$applicants = $conn->query("
  SELECT j.*, u.full_name, u.email
  FROM job_applications j
  JOIN jobseekers u ON j.applicant_id = u.user_id
  WHERE j.job_id = $job_id
  ORDER BY j.date_applied DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Applicants for <?php echo htmlspecialchars($job['title']); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 p-4 bg-white shadow rounded" style="max-width: 900px;">
  <h3 class="text-center mb-4">Applicants for "<?php echo htmlspecialchars($job['title']); ?>"</h3>

  <?php if ($applicants->num_rows > 0): ?>
    <table class="table table-bordered text-center">
      <thead class="table-success">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Date Applied</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $applicants->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo date('M d, Y', strtotime($row['date_applied'])); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-center text-muted">No applicants yet.</p>
  <?php endif; ?>

  <div class="text-center mt-3">
    <a href="boss_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>
</div>

</body>
</html>
