
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Create Job Listing - JobMatch</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
  background-color: #f2f2f2;
}

/* Navbar */
.navbar {
  background-color: #446d1c;
}
.navbar a {
  color: white !important;
  font-weight: 500;
  margin-right: 20px;
  text-decoration: none !important;
}
.navbar a.active {
  color: #FFD43B !important;
}
.logo-img {
  height: 40px;
  width: auto;
  margin-left: 80px;
}

/* Form Container */
.create-job-container {
  max-width: 600px;
  margin: 60px auto;
  background: white;
  border: 1px solid #ccc;
  border-radius: 10px;
  padding: 40px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}
.create-job-container h4 {
  font-family: 'Gabarito', sans-serif;
  font-weight: 700;
  text-align: center;
  margin-bottom: 30px;
}

/* Inputs */
.form-label { font-weight: 600; margin-bottom: 6px; }
.form-control, .form-select {
  border-radius: 8px;
  border: 1px solid #ccc;
}

/* Buttons */
.btn-confirm {
  background-color: #446d1c;
  color: white;
  border: none;
  font-weight: 600;
  padding: 10px 0;
  border-radius: 8px;
}
.btn-confirm:hover { background-color: #385c17; }

.btn-cancel {
  background-color: #949494;
  color: white;
  border: none;
  font-weight: 600;
  padding: 10px 0;
  border-radius: 8px;
   text-decoration: none;
}
.btn-cancel:hover { background-color: #7a7a7a;  text-decoration: none; }

.form-check-inline { margin-right: 15px; }
</style>
</head>

<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <img src="<?= base_url('imgs/logo.png') ?>" alt="JobMatch Logo" class="logo-img">
    <div class="ms-auto">
      <a href="<?= site_url('boss_dashboard') ?>" class="nav-link d-inline">Dashboard</a>
      <a href="<?= site_url('boss_view_applicants') ?>" class="nav-link d-inline">View Applicants</a>
      <a href="<?= site_url('boss_profile') ?>" class="nav-link d-inline">Profile</a>
      <a href="<?= site_url('login') ?>" class="nav-link d-inline" id="logoutBtn">Log Out</a>
    </div>
  </div>
</nav>

<!-- ✅ Create Job Form -->
<div class="create-job-container">
  <h4>Create a New Job Listing</h4>
  <form method="POST" action="<?= site_url('create_jobpost'); ?>">

    
    <!-- Company Name -->
    <div class="mb-3">
      <label class="form-label">Company Name</label>
      <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-building"></i></span>
        <input type="text" name="company_name" class="form-control"
       value="<?php echo htmlspecialchars($company_name); ?>" readonly>

      </div>
    </div>

    <!-- Job Title -->
    <div class="mb-3">
      <label class="form-label">Job Title</label>
      <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-person-workspace"></i></span>
        <input type="text" name="title" class="form-control" placeholder="e.g. Senior Software Engineer" required>
      </div>
    </div>

    <!-- Description -->
    <div class="mb-3">
      <label class="form-label">Job Description</label>
      <textarea name="description" class="form-control" rows="4" placeholder="Enter job responsibilities, qualifications, and requirements..." required></textarea>
    </div>

    <!-- Work Type -->
    <div class="mb-3">
      <label class="form-label d-block">Work Type</label>
      <div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="job_type" id="fullTime" value="Full-Time" required>
          <label class="form-check-label" for="fullTime">Full-Time</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="job_type" id="partTime" value="Part-Time">
          <label class="form-check-label" for="partTime">Part-Time</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="job_type" id="gig" value="Gig">
          <label class="form-check-label" for="gig">Gig</label>
        </div>
      </div>
    </div>

    <!-- Salary Range -->
    <div class="mb-4">
      <label class="form-label">Salary Range</label>
      <input type="text" name="salary_range" class="form-control" placeholder="e.g. ₱20,000 - ₱30,000 / monthly" required>
    </div>

    <!-- Buttons -->
    <div class="d-flex justify-content-center gap-3">
      <button type="submit" class="btn-confirm w-50">Confirm</button>
      <a href="<?= site_url('boss_dashboard') ?>" class="btn-cancel w-50 text-center">Cancel</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
