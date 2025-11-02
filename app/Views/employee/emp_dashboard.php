<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - JobMatch</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@700;800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

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
.main {
  max-width: 1100px;
  margin: auto;
  background: white;
  padding: 30px;
}

.containers {
  border: 1px solid #000;
  border-radius: 10px;
  margin-bottom: 30px;
}

.container-main {
  max-width: 1100px;
  margin: auto;
  background: lightgray;
  border: 1px solid #000;
  border-radius: 10px;
  padding: 30px;
}

/* Sidebar */
.sidebar {
  background: #fff;
  border: 1px solid #000;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.05);
  height: fit-content;
}
.search-box {
  position: relative;
}
.search-box input {
  width: 100%;
  padding: 8px 12px;
  border-radius: 8px;
  border: 1px solid #ccc;
}
.search-box i {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #777;
}
.filter-list input {
  margin-right: 8px;
}
.filter-list label {
  font-weight: 600;
}

/* Job Application Cards */
.job-card {
  background: #fff;
  border: 1px solid #000;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.05);
}
.job-card h6 {
  font-weight: 700;
}
.btn-details {
  background-color: #949494ff;
  color: black;
  border: none;
  padding: 8px 18px;
  border-radius: 6px;
}
.btn-details:hover {
  background-color: #e5e5e5;
}
.status-badge {
  background-color: #666666ff;
  font-size: 0.85rem;
  border-radius: 6px;
  padding: 5px 10px;
  font-weight: 600;
}

/* Welcome Section */
.welcome-section {
  background-color: white;
  text-align: center;
  padding: 40px;
  border-radius: 10px;
}
.welcome-section h2 {
  font-weight: 700;
  margin: 5px;
}
.btn-apply {
  background-color: #446d1c;
  color: white;
  border: none;
  padding: 8px 18px;
  border-radius: 6px;
  text-decoration: none;
  display: inline-block;
}
.btn-apply:hover {
  background-color: #385c17;
  text-decoration: none;
}

/* Status Colors */
.status-badge.pending { background-color: #FFD966; }
.status-badge.hired { background-color: #7CB342; color: white; }
.status-badge.rejected { background-color: #E57373; color: white; }

@media (max-width: 991px) {
  .container-main { padding: 20px; }
}
@media (max-width: 768px) {
  .sidebar { margin-bottom: 20px; }
  .navbar a { margin-right: 10px; }
}
</style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <img src="<?= base_url('imgs/logo.png') ?>" alt="JobMatch Logo" class="logo-img">
    <div class="ms-auto">
      <a href="<?= base_url('emp_dashboard') ?>" class="nav-link active d-inline">Dashboard</a>
      <a href="<?= base_url('emp_find_jobs') ?>" class="nav-link d-inline">Find Jobs</a>
      <a href="<?= base_url('emp_profile') ?>" class="nav-link d-inline">Profile</a>
      <a href="<?= base_url('login') ?>" class="nav-link d-inline btn-secondary" id="logoutBtn">Log Out</a>
    </div>
  </div>
</nav>

<!-- ✅ Main Section -->
<div class="main">
  <div class="containers">
    <div class="welcome-section">
      <h2>Welcome <?= esc(session('full_name')) ?>!</h2>
      <p>Discover jobs, connect with top companies, and explore talent opportunities.</p>
      <a href="<?= base_url('emp_find_jobs') ?>" class="btn-apply btn-sm mt-2">Explore</a>
    </div>
  </div>

  <div class="row g-4">
    <!-- Sidebar -->
    <div class="col-lg-4">
      <div class="sidebar">
        <div class="search-box mb-3">
          <input type="text" id="searchInput" placeholder="Search something...">
          <i class="bi bi-search"></i>
        </div>
        <h6 class="fw-bold mb-2">Search Filter:</h6>
        <div class="filter-list">
          <div><input type="checkbox" class="statusFilter" value="pending" id="pending"> <label for="pending">Pending</label></div>
          <div><input type="checkbox" class="statusFilter" value="hired" id="hired"> <label for="hired">Hired</label></div>
          <div><input type="checkbox" class="statusFilter" value="rejected" id="rejected"> <label for="rejected">Rejected</label></div>
        </div>
      </div>
    </div>

    <!-- Job Applications -->
    <div class="col-lg-8">
      <div class="container container-main">
        <h5 class="fw-bold mb-3 text-center">Jobs that you’ve applied for:</h5>

        <?php if (empty($applications)): ?>
          <p class="text-center text-muted">You haven’t applied to any jobs yet.</p>
        <?php else: ?>
          <div id="applicationsList">
            <?php foreach ($applications as $row): ?>
              <?php 
                $status = strtolower(trim($row['status'] ?? 'pending'));
                if ($status === 'hired') $status = 'hired';
              ?>
              <div class="job-card" data-status="<?= esc($status) ?>" data-title="<?= esc(strtolower($row['title'])) ?>">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-1">
                  <h6 class="fw-bold mb-0"><?= esc($row['title']) ?></h6>
                  <h6>Status:
                    <span class="status-badge <?= esc($status) ?>">
                      <?= ucfirst(esc($status)) ?>
                    </span>
                  </h6>
                </div>
                <small class="text-muted"><?= esc($row['company_name']) ?></small><br>
                <small>Applied on: <?= date('M d, Y', strtotime($row['date_applied'])) ?></small>

                <div class="mt-3 text-start">
                  <button class="btn btn-details me-2"
                    data-bs-toggle="modal"
                    data-bs-target="#jobDetailsModal"
                    data-title="<?= esc($row['title']) ?>"
                    data-company="<?= esc($row['company_name']) ?>"
                    data-type="<?= esc($row['job_type'] ?? 'Not specified') ?>"
                    data-salary="<?= esc($row['salary_range'] ?? 'Not specified') ?>"
                    data-description="<?= esc($row['job_description'] ?? 'No description available') ?>">
                    View Details
                  </button>

                  <button class="btn btn-details viewMessageBtn"
                          data-bs-toggle="modal"
                          data-bs-target="#messageModal"
                          data-jobid="<?= esc($row['job_id']) ?>">
                    View Message
                  </button>

                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Job Details Modal -->
<div class="modal fade" id="jobDetailsModal" tabindex="-1" aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-3">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold w-100 text-center">Job Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body mt-2" style="max-height:70vh; overflow-y:auto;">
        <div class="mb-3">
          <h4 id="jobTitle" class="fw-bold mb-1"></h4>
          <p><strong>Company:</strong> <span id="jobCompany"></span></p>
          <p><strong>Work Type:</strong> <span id="jobType"></span></p>
          <p><strong>Salary Range:</strong> <span id="jobSalary"></span></p>
        </div>
        <div class="border-top pt-3">
          <h6 class="fw-bold mb-2">Description:</h6>
          <p id="jobDescription" style="white-space:pre-line; text-align:justify; line-height:1.6;"></p>
        </div>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- 📩 Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold w-100 text-center">Message from Company</h5>
      </div>
      <div class="modal-body" id="messageContent" style="max-height:60vh; overflow-y:auto;">
        <p class="text-center text-muted">Loading message...</p>
      </div>
      <div class="modal-footer border-0 text-center">
        <button type="button" class="btn btn-secondary mx-auto px-4" data-bs-dismiss="modal">Back</button>
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
        <p>Are you sure you want to log out of your JobMatch personal account?</p>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmLogoutBtn">Logout</button>
      </div>
    </div>
  </div>
</div>



<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const jobDetailsModal = document.getElementById('jobDetailsModal');
  jobDetailsModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    document.getElementById('jobTitle').textContent = button.getAttribute('data-title');
    document.getElementById('jobCompany').textContent = button.getAttribute('data-company');
    document.getElementById('jobType').textContent = button.getAttribute('data-type');
    document.getElementById('jobSalary').textContent = button.getAttribute('data-salary');
    document.getElementById('jobDescription').textContent = button.getAttribute('data-description');
  });

  // ✅ JS Filtering by title or status
  const searchInput = document.getElementById('searchInput');
  const statusFilters = document.querySelectorAll('.statusFilter');
  const cards = document.querySelectorAll('.job-card');
  const container = document.getElementById('applicationsList') || document.querySelector('.container-main');

  // Create “no results” message
  const noResultMsg = document.createElement('p');
  noResultMsg.textContent = "No posts match your search.";
  noResultMsg.className = "text-center text-muted fw-semibold mt-3";
  noResultMsg.style.display = "none";
  container.appendChild(noResultMsg);

  function filterCards() {
    const query = searchInput.value.toLowerCase();
    const activeStatuses = Array.from(statusFilters)
      .filter(chk => chk.checked)
      .map(chk => chk.value);

    let visibleCount = 0;

    cards.forEach(card => {
      const title = card.dataset.title;
      const status = card.dataset.status;
      const matchesSearch = title.includes(query);
      const matchesStatus = activeStatuses.length === 0 || activeStatuses.includes(status);
      const isVisible = matchesSearch && matchesStatus;
      card.style.display = isVisible ? '' : 'none';
      if (isVisible) visibleCount++;
    });

    // ✅ Show or hide “no result” message
    noResultMsg.style.display = visibleCount === 0 ? 'block' : 'none';
  }

  searchInput.addEventListener('input', filterCards);
  statusFilters.forEach(chk => chk.addEventListener('change', filterCards));
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const messageModal = document.getElementById('messageModal');
  const messageContent = document.getElementById('messageContent');

  document.querySelectorAll('.viewMessageBtn').forEach(btn => {
    btn.addEventListener('click', async () => {
      const jobId = btn.getAttribute('data-jobid');
      messageContent.innerHTML = '<p class="text-center text-muted">Loading message...</p>';

      try {
        const response = await fetch(`<?= base_url('fetch_messages/') ?>${jobId}`);
        const data = await response.json();

        if (data.messages && data.messages.length > 0) {
          messageContent.innerHTML = data.messages.map(msg => `
            <div class='mb-3 p-3 border rounded bg-light'>
              <strong>${msg.sender_name}</strong><br>
              <small class='text-muted'>${new Date(msg.date_sent).toLocaleString()}</small>
              <p class='mt-2 mb-0'>${msg.message.replace(/\n/g, '<br>')}</p>
            </div>
          `).join('');
        } else {
          messageContent.innerHTML = `<p class='text-center text-muted'>No messages for this job yet.</p>`;
        }
      } catch (err) {
        console.error(err);
        messageContent.innerHTML = `<p class='text-danger text-center'>Error loading messages.</p>`;
      }
    });
  });
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
      window.location.href = "<?= base_url('logout') ?>";
    });
  }
});
</script>


</body>
</html>
