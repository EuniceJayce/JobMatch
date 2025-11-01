<?php
// Data passed from controller
$session = session();
$emp = $emp ?? [];
$job_seeker_id = $user_id ?? 0;
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Profile - JobMatch</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
  background-color: #f2f2f2;
}
.navbar {
  background-color: #446d1c;
}
.navbar a {
  color: white !important;
  font-weight: 500;
  margin-right: 20px;
}
.navbar a.active {
  color: #FFD43B !important;
}
.logo-img {
  height: 40px;
  width: auto;
  margin-left: 80px;
}
/* Main Container */
.container-main {
  max-width: 1000px;
  margin: auto;
  background: white;
  
  padding: 40px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
/* Profile Picture */
.profile-pic {
  width: 130px;
  height: 130px;
  border-radius: 50%;
  background-color: #d9d9d9;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 50px;
  color: #999;
  margin: 0 auto;
  border: 1px solid #000;
}
/* Info Boxes */
.info-box {
  background: #fff;
  border: 1px solid #000;
  border-radius: 10px;
  padding: 25px;
  height: 100%;
  box-shadow: 0 3px 8px rgba(0,0,0,0.05);
}
/* Buttons */
.btn-edit {
  border: 1px solid #000;
  background: #fff;
  color: #000;
  padding: 6px 20px;
  border-radius: 8px;
  font-weight: 500;
  
}
.btn-edit:hover {
  background: #f8f8f8;
}
.btn-view {
  background-color: #446d1c;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 8px 20px;
  font-weight: 500;
  text-decoration: none; /* 🔥 removes underline */
  display: inline-block; /* ensures it looks like a button */
}
.btn-view:hover {
  background-color: #385c17;
  text-decoration: none; /* keep underline removed on hover too */
}

.btn-delete {
  background-color: #b02a37;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 8px 20px;
  font-weight: 500;
}
.btn-delete:hover {
  background-color: #8b1f2c;
}
@media (max-width: 768px) {
  .container-main { padding: 25px; }
  .info-box { margin-bottom: 20px; }
}
</style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <img src="<?= base_url('imgs/logo.png') ?>" alt="JobMatch Logo" class="logo-img">
    <div class="ms-auto">
      <a href="<?= site_url('emp_dashboard') ?>" class="nav-link  d-inline">Dashboard</a>
      <a href="<?= site_url('emp_find_jobs') ?>" class="nav-link d-inline">Find Jobs</a>
      <a href="<?= site_url('emp_profile') ?>" class="nav-link active d-inline">Profile</a>
      <a href="<?= site_url('login') ?>" class="nav-link d-inline" id="logoutBtn">Log Out</a>
    </div>
  </div>
</nav>

<!-- ✅ Main Profile Content -->
<div class="container container-main text-center">

  <!-- Profile Section -->
  <div class="profile-section mb-4">
 <div class="profile-pic mb-3 position-relative">
  <?php if (!empty($emp['profile_picture']) && file_exists(FCPATH . $emp['profile_picture'])): ?>
  <img src="<?= base_url($emp['profile_picture']) ?>" 
       alt="Profile Picture" 
       style="width:130px; height:130px; object-fit:cover; border-radius:50%; border:1px solid #000;">
<?php else: ?>
  <i class="bi bi-person"></i>
<?php endif; ?>


  <button class="btn btn-sm btn-light position-absolute bottom-0 end-0 rounded-circle shadow-sm"
          data-bs-toggle="modal" data-bs-target="#uploadProfileModal"
          style="width:35px; height:35px;">
    <i class="bi bi-camera"></i>
  </button>
</div>


   <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($emp['full_name']); ?></h5>
<p class="text-muted"><?php echo htmlspecialchars($emp['email']); ?></p>
<button class="btn-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit</button>
  </div>

  <!-- Info Boxes -->
  <div class="row mt-5 text-start">
    <div class="col-md-6">
      <div class="info-box">
        <p><strong><br>Full Name: </strong><?php echo htmlspecialchars($emp['full_name']); ?></p>
<p><strong>Email: </strong><?php echo htmlspecialchars($emp['email']); ?></p>
<p><strong>Age: </strong> <?php echo htmlspecialchars($emp['age']); ?></p>
<p><strong>Gender: </strong> <?php echo htmlspecialchars($emp['gender']); ?></p>
<p><strong>Contact No.: </strong> <?php echo htmlspecialchars($emp['contact_no']); ?></p>

      </div>
    </div>

    <div class="col-md-6 text-center">
      <div class="info-box d-flex flex-column justify-content-center align-items-center">
        <i class="bi bi-file-earmark-text mb-3" style="font-size:40px;"></i>
        <h6 class="fw-bold mb-3">Resume</h6>
        <div id="resumeButtons">
  <?php if (!empty($emp['resume_path']) && file_exists($emp['resume_path'])): ?>
    <a href="<?= base_url($emp['resume_path']); ?>" target="_blank" class="btn-view">View</a>


    <form action="<?= site_url('emp_profile/deleteResume') ?>" method="POST" style="display:inline;">
  <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($job_seeker_id); ?>">
  <button type="submit" class="btn-delete ms-2">Delete</button>
</form>



  <?php else: ?>
    <button class="btn-view" data-bs-toggle="modal" data-bs-target="#uploadResumeModal">Upload</button>
  <?php endif; ?>
</div>

      </div>
    </div>
  </div>
</div>

<!-- ✅ Upload Resume Modal -->

<div class="modal fade" id="uploadResumeModal" tabindex="-1" aria-labelledby="uploadResumeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center fw-bold" id="uploadResumeModalLabel">Upload Resume</h5>
      </div>

      <div class="modal-body">
        <form action="<?= site_url('emp_profile/uploadResume') ?>" method="POST" enctype="multipart/form-data">

          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($job_seeker_id); ?>">
          <div class="mb-3">
            <label for="resumeFile" class="form-label fw-semibold">Choose Resume File</label>
            <input type="file" name="resume" id="resumeFile" class="form-control" accept=".pdf, .doc, .docx" required>
            <small class="text-muted">Accepted formats: PDF, DOC, DOCX (Max: 5MB)</small>
          </div>
          <div class="d-flex justify-content-center gap-3 mt-3">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success px-4" style="background-color:#446d1c; border:none;">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- ✅ Upload Profile Picture Modal -->
<div class="modal fade" id="uploadProfileModal" tabindex="-1" aria-labelledby="uploadProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center fw-bold" id="uploadProfileModalLabel">Upload Profile Picture</h5>
      </div>

      <div class="modal-body">
        <form action="<?= site_url('emp_profile/uploadProfile') ?>" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($job_seeker_id); ?>">
  <div class="mb-3">
    <label for="profilePicFile" class="form-label fw-semibold">Choose Image</label>
    <input type="file" name="profile_image" id="profilePicFile" class="form-control" accept="image/*" required>
    <small class="text-muted">Accepted formats: JPG, PNG (Max: 2MB)</small>
  </div>
  <div class="d-flex justify-content-center gap-3 mt-3">
    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success px-4" style="background-color:#446d1c; border:none;">Upload</button>
  </div>
</form>

      </div>
    </div>
  </div>
</div>




<!-- ✅ Edit Info Modal -->
 <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-dark">
          <h5 class="modal-title fw-bold" id="editModalLabel">Edit Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form id="editForm">
            <div class="mb-3">
              <label class="form-label">Full Name:</label>
              <input type="text" class="form-control" placeholder="Enter full name" id="fullName">
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Age:</label>
                <input type="number" class="form-control" placeholder="Enter age" id="age">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Gender:</label>
                <select class="form-select" id="gender">
                  <option value="" disabled selected>Select gender</option>
                  <option>Male</option>
                  <option>Female</option>
                  <option>Other</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Email:</label>
              <input type="email" class="form-control" placeholder="Enter email" id="email">
            </div>

            <div class="mb-3">
              <label class="form-label">Contact No.:</label>
              <input type="tel" class="form-control" placeholder="Enter contact number" id="contact">
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success">Save Changes</button>
        </div>
      </div>
    </div>
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center fw-bold" id="logoutModalLabel">Confirm Logout</h5>
      </div>
      <div class="modal-body text-center">
        <p>Are you sure you want to log out of your JobMatch personal account?</p>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmLogoutBtn">Logout</button>
      </div>
    </div>
  </div>
</div>



<!-- ✅ Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center fw-bold" id="editProfileModalLabel">Edit Profile Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="<?= site_url('emp_profile/updateProfile') ?>" method="POST">
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($job_seeker_id); ?>">

          <div class="mb-3">
            <label class="form-label fw-semibold">Full Name:</label>
            <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($emp['full_name']); ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($emp['email']); ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Age:</label>
            <input type="number" class="form-control" name="age" value="<?php echo htmlspecialchars($emp['age']); ?>" min="18" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Gender:</label>
            <select class="form-select" name="gender" required>
              <option value="" disabled>Select gender</option>
              <option value="Male" <?php echo ($emp['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
              <option value="Female" <?php echo ($emp['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
              <option value="Other" <?php echo ($emp['gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Contact No.:</label>
            <input type="text" class="form-control" name="contact_no" value="<?php echo htmlspecialchars($emp['contact_no']); ?>" required>
          </div>

          <div class="d-flex justify-content-center gap-3 mt-4">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success px-4" style="background-color:#446d1c; border:none;">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
  const logoutBtn = document.getElementById("logoutBtn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", function(e) {
      e.preventDefault();
      const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
      modal.show();
    });
  }

  const confirmBtn = document.getElementById("confirmLogoutBtn");
  if (confirmBtn) {
    confirmBtn.addEventListener("click", function() {
      window.location.href = "<?= site_url('logout') ?>";
    });
  }
});
</script>






<script>



// Show upload button
function showUploadButton() {
  resumeButtons.innerHTML = `
    <button class="btn-view" id="uploadBtn" data-bs-toggle="modal" data-bs-target="#uploadResumeModal">Upload</button>
  `;
}

// Show view + delete buttons
function showViewDeleteButtons() {
  resumeButtons.innerHTML = `
    <button class="btn-view" id="viewResumeBtn">View</button>
    <button class="btn-delete ms-2" id="deleteResumeBtn">Delete</button>
  `;

  document.getElementById("viewResumeBtn").addEventListener("click", () => {
    alert("Opening uploaded resume...");
  });

  document.getElementById("deleteResumeBtn").addEventListener("click", () => {
    if (confirm("Are you sure you want to delete your resume?")) {
      localStorage.removeItem(resumeKey);
      showUploadButton();
    }
  });
}

// Handle Upload button inside modal
document.getElementById("saveResumeBtn").addEventListener("click", () => {
  const fileInput = document.getElementById("resumeFile");
  if (fileInput.files.length > 0) {
    localStorage.setItem(resumeKey, "true");
    showViewDeleteButtons();
    alert("Resume uploaded successfully!");
    const modal = bootstrap.Modal.getInstance(document.getElementById("uploadResumeModal"));
    modal.hide();
  } else {
    alert("Please select a file to upload.");
  }
});
</script>

</body>
</html>
