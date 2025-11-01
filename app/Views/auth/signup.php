<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JobMatch Sign Up</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      min-height: 100vh;
      background: linear-gradient(135deg, #ffffff, #f9f7d1, #d8f08a, #98b64d);
      display: flex;
      flex-direction: column;
      font-family: 'Poppins', sans-serif;
    }

    .top-bar {
      background-color: #5e7a1f;
      height: 60px;
      display: flex;
      align-items: center;
      padding-left: 30px;
    }

    .logo-img {
      height: 40px;
      width: auto;
      margin-left: 100px;
    }

    .main-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 60px;
      padding: 40px;
    }

    .signup-box {
      background: white;
      border-radius: 12px;
      padding: 35px;
      width: 350px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .tab-buttons {
      display: flex;
      justify-content: center;
      margin-bottom: 25px;
      gap: 15px;
    }

    .tab-buttons a, .tab-buttons button {
      border: none;
      background: none;
      padding: 10px 25px;
      font-weight: 600;
      font-size: 16px;
      border-radius: 20px;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
      color: inherit;
    }

    .tab-buttons .active {
      background-color: #f9f9b7;
      color: #5e7a1f;
      font-weight: 700;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }



.input-group-text {
  background: none;
  border: none;
  position: absolute;
  left: 3px;
  top: 50%;
  transform: translateY(-50%);
  color: #5e7a1f;
  font-size: 17px;
  z-index: 2;
  pointer-events: none;
}

.form-control,
.form-select {
  border-radius: 8px;
  padding-left: 38px; /* ensures text doesn’t overlap the icon */
  height: 42px;
  font-size: 14px;
}

.jobseeker-fields .col-6 .form-control,
.jobseeker-fields .col-6 .form-select {
  width: 100%;
  padding-left: 35px;
  height: 42px;
}

.jobseeker-fields .col-6 .input-group-text {
  left: 8px;
  font-size: 16px;
}

    .btn-signup {
      background-color: #5e7a1f;
      border: none;
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      color: white;
      font-weight: 600;
      margin-top: 10px;
      transition: 0.3s;
    }

    .btn-signup:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    .right-section {
      max-width: 400px;
    }

    .main-title {
      font-size: 50px;
      font-weight: 800;
      background: linear-gradient(90deg, #6f9722, #e2c12d);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 15px;
      text-align: center;
    }

    .description {
      font-size: 12px;
      color: #333;
      line-height: 1.6;
      text-align: center;
    }

    .extra-fields {
      display: none;
    }

    .other-label {
      font-weight: 600;
      margin-top: 15px;
      color: #5e7a1f;
    }

    @media (max-width: 992px) {
      .main-section {
        flex-direction: column;
        text-align: center;
      }
      .right-section {
        max-width: 90%;
      }
    }
  </style>
</head>
<body>

  <!-- ✅ Top Bar -->
  <div class="top-bar">
    <img src="<?= base_url('imgs/logo.png') ?>" alt="JobMatch Logo" class="logo-img">
  </div>

  <!-- ✅ Main Section -->
  <div class="main-section">
    <!-- ✅ Signup Box -->
    <div class="signup-box">
      <div class="tab-buttons">
         <a href="<?php echo site_url('login'); ?>" >Log in</button>
        <a href="<?php echo site_url('signup'); ?>" class="active">Sign Up</a>
      </div>

      <form method="POST" action="<?= site_url('signup') ?>">

      <!-- Role -->
        <div class="mb-3 position-relative">
          <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
          <select name="role" id="role" class="form-select" required>
            <option selected disabled>Choose a role</option>
            <option value="employer">Employer</option>
            <option value="job_seeker">Job Seeker</option>
          </select>
        </div>
        <!-- Full Name -->
        <div class="mb-3 position-relative">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
        </div>

        <!-- Email -->
        <div class="mb-3 position-relative">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>

        <!-- Password -->
        <div class="mb-3 position-relative">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        

       <!-- OTHER (hidden by default) -->
<div class="other-label" id="otherLabel" style="display: none;">OTHER:</div>

<!-- Employer Fields -->
<div class="extra-fields employer-fields">
  <div class="mb-3 position-relative">
    <span class="input-group-text"><i class="bi bi-building"></i></span>
    <input type="text" name="company_name" class="form-control" placeholder="Company Name">
  </div>
  <div class="mb-3 position-relative">
    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
    <input type="text" name="industry" class="form-control" placeholder="Industry">
  </div>
  <div class="mb-3 position-relative">
    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
    <input type="text" name="emp_contact" class="form-control" placeholder="Contact No.">
  </div>
</div>

<!-- Job Seeker Fields -->
<div class="extra-fields jobseeker-fields">
  <div class="row">
    <div class="col-6 mb-3 position-relative">
      <span class="input-group-text"><i class="bi bi-calendar"></i></span>
      <input type="number" name="age" class="form-control" placeholder="Age">
    </div>
    <div class="col-6 mb-3 position-relative">
      <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
      <select name="gender" class="form-select">
        <option selected disabled>Gender</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
      </select>
    </div>
  </div>
  <div class="mb-3 position-relative">
    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
    <input type="text" name="job_contact" class="form-control" placeholder="Contact No.">
  </div>
</div>


        <!-- Submit Button -->
        <button type="submit" name="signup" class="btn-signup">Sign Up</button>
      </form>
    </div>

    <!-- ✅ Right Section -->
    <div class="right-section">
      <h1 class="main-title text-start">Employer</h1>
      <p class="description text-start">
        Employers can easily post job openings, manage listings, and connect with qualified candidates through a dedicated dashboard. 
        Review applications, schedule interviews, and find the perfect match for your company — all in one place.
      </p>

      <h1 class="main-title mt-4 text-end">Job Seeker</h1>
      <p class="description text-end">
        Job seekers can create personalized profiles, browse available job opportunities, and apply directly to positions that fit their 
        skills and interests. With smart matching and real-time updates, finding your next opportunity has never been easier.
      </p>
    </div>
  </div>

  <!-- ✅ Bootstrap Icons + JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const roleSelect = document.getElementById('role');
  const employerFields = document.querySelector('.employer-fields');
  const jobseekerFields = document.querySelector('.jobseeker-fields');
  const otherLabel = document.getElementById('otherLabel');

  roleSelect.addEventListener('change', () => {
    if (roleSelect.value === 'employer') {
      employerFields.style.display = 'block';
      jobseekerFields.style.display = 'none';
      otherLabel.style.display = 'block';
    } else if (roleSelect.value === 'job_seeker') {
      jobseekerFields.style.display = 'block';
      employerFields.style.display = 'none';
      otherLabel.style.display = 'block';
    } else {
      employerFields.style.display = 'none';
      jobseekerFields.style.display = 'none';
      otherLabel.style.display = 'none';
    }
  });
</script>




</body>
</html>
