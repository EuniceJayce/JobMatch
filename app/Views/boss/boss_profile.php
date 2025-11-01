
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Profile - JobMatch (Company)</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@700;800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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

.main {
  max-width: 1000px;
  margin: auto;
  background: white;
  padding: 40px;
}

.profile-pic {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 2px solid #446d1c;
  overflow: hidden;
  background-color: #e0e0e0;
  color: #6c757d;
}

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

.info-box {
  background: #f9f9f9;
  border: 1px solid #000;
  border-radius: 10px;
  padding: 20px;
  height: 100%;
}

.btn-outline-success {
  border-color: #446d1c;
  color: #446d1c;
}
.btn-outline-success:hover {
  background-color: #446d1c;
  color: #fff;
}

.modal-content {
  border-radius: 12px;
  border: 1px solid #888;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
.modal-header h5 {
  font-family: 'Gabarito', sans-serif;
  font-weight: 700;
}
</style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <img src="<?= base_url('imgs/logo.png') ?>" alt="JobMatch Logo" class="logo-img">
    <div class="ms-auto">
      <a href="<?= site_url('boss_dashboard') ?>" class="nav-link  d-inline">Dashboard</a>
      <a href="<?= site_url('boss_view_applicants') ?>" class="nav-link  d-inline">View Applicants</a>
      <a href="<?= site_url('boss_profile') ?>" class="nav-link d-inline">Profile</a>
      <a href="<?= site_url('login') ?>" class="nav-link d-inline" id="logoutBtn">Log Out</a>
    </div>
  </div>
</nav>


<!-- ✅ Success Alert -->
<?php if (isset($_GET['updated'])): ?>
  <div class="alert alert-success text-center mb-0">✅ Profile updated successfully!</div>
<?php endif; ?>
<?php if (isset($_GET['website_added'])): ?>
  <div class="alert alert-success text-center mb-0">✅ Website link added successfully!</div>
<?php endif; ?>
<?php if (isset($_GET['website_removed'])): ?>
  <div class="alert alert-warning text-center mb-0">⚠️ Website link removed.</div>
<?php endif; ?>



<!-- ✅ Profile Section -->
<div class="main text-center">
  <div class="profile-section">
    <div class="position-relative d-inline-block">
      <?php if (!empty($company['profile_image'])): ?>
        <img src="<?= base_url($company['profile_image']) ?>" 
          alt="Profile Picture" 
          class="profile-pic object-fit-cover">

      <?php else: ?>
        <div class="profile-pic d-flex align-items-center justify-content-center bg-light text-secondary">
          <i class="bi bi-person-fill" style="font-size: 60px;"></i>
        </div>
      <?php endif; ?>

      <!-- ✅ Upload Button -->
      <form action="<?= site_url('upload_profile') ?>" method="POST" enctype="multipart/form-data" class="position-absolute bottom-0 end-0">
        <label for="profileUpload" class="btn btn-sm btn-success rounded-circle" style="cursor:pointer;">
          <i class="bi bi-camera-fill"></i>
        </label>
        <input type="file" name="profile_image" id="profileUpload" accept="image/*" style="display:none;" onchange="this.form.submit()">
      </form>
    </div>

    <h4 class="fw-bold mt-3"><?php echo htmlspecialchars($company['full_name']); ?></h4>
    <p class="text-muted mb-3"><?php echo htmlspecialchars($company['email']); ?></p>
    <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit</button>
  </div>

  <div class="row mt-5 g-4">
    <div class="col-md-6">
      <div class="info-box text-start">
        <h5 class="fw-bold mb-3">Company Information</h5>
        <p><strong>Company Name:</strong> <?php echo htmlspecialchars($company['company_name']); ?></p>
        <p><strong>Industry:</strong> <?php echo htmlspecialchars($company['industry']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($company['email']); ?></p>
        <p><strong>Contact:</strong> <?php echo htmlspecialchars($company['contact_no']); ?></p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="info-box d-flex flex-column justify-content-center align-items-center">
        <i class="bi bi-globe2" style="font-size: 40px; color: #000000ff; margin-bottom: 10px;"></i>
        <h6 class="fw-bold mb-3">Company Website</h6>

        <?php if (!empty($company['website'])): ?>
  <div class="d-flex gap-2">
    <a href="<?php echo htmlspecialchars($company['website']); ?>" target="_blank" class="btn btn-success px-4">View</a>
    <form action="<?= site_url('delete_website') ?>" method="POST" onsubmit="return confirm('Are you sure you want to remove this website link?');">
      <button type="submit" class="btn btn-danger px-4">Delete</button>
    </form>
  </div>
<?php else: ?>
  <button type="button" class="btn btn-outline-dark px-4" data-bs-toggle="modal" data-bs-target="#websiteModal">
    Link Website
  </button>
<?php endif; ?>

      </div>
    </div>
  </div>
</div>

<!-- ✅ Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center" id="editProfileModalLabel">Edit Information</h5>
      </div>
      <div class="modal-body">
        <form action="<?= site_url('update_profile') ?>" method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Full Name:</label>
            <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($company['full_name']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Company Name:</label>
            <input type="text" class="form-control" name="company_name" value="<?php echo htmlspecialchars($company['company_name']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($company['email']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Industry:</label>
            <input type="text" class="form-control" name="industry" value="<?php echo htmlspecialchars($company['industry']); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Contact No.:</label>
            <input type="text" class="form-control" name="contact_no" value="<?php echo htmlspecialchars($company['contact_no']); ?>">
          </div>

          <div class="d-flex justify-content-center gap-3">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success px-4">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Website Modal -->
<div class="modal fade" id="websiteModal" tabindex="-1" aria-labelledby="websiteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center fw-bold" id="websiteModalLabel">Add Company Website</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= site_url('update_website') ?>" method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Website Link:</label>
            <input type="url" name="website" class="form-control" placeholder="https://example.com" required>
          </div>
          <div class="text-center mt-4">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success px-4">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center fw-bold" id="logoutModalLabel">Confirm Logout</h5>
      </div>
      <div class="modal-body text-center">
        <p>Are you sure you want to log out of your JobMatch company account?</p>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmLogoutBtn">Logout</button>
      </div>
    </div>
  </div>
</div>


<script>
// ✅ Logout modal trigger
document.getElementById("logoutBtn").addEventListener("click", function(e) {
  e.preventDefault();
  const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
  logoutModal.show();
});

// ✅ Confirm logout
document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
  window.location.href = "login.php";
});

// ✅ Auto-hide success alert
document.addEventListener("DOMContentLoaded", function() {
  const alertBox = document.querySelector(".alert-success");
  if (alertBox) {
    setTimeout(() => {
      alertBox.style.transition = "opacity 0.5s ease";
      alertBox.style.opacity = "0";
      setTimeout(() => alertBox.remove(), 500);
    }, 3000);
  }
});
</script>

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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
