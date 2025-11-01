<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - JobMatch (Company)</title>

<!-- ✅ Bootstrap & Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@700;800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body { background-color: #f2f2f2; }
.navbar { background-color: #446d1c; }
.navbar a { color: white !important; font-weight: 500; margin-right: 20px; }
.navbar a.active { color: #FFD43B !important; }
.logo-img { height: 40px; width: auto; margin-left: 80px; }

/* Main */
.main { max-width: 1100px; margin: auto; background: white; padding: 30px; }
.containers { border: 1px solid #000; border-radius: 10px; margin-bottom: 30px; }
.container-main { max-width: 1100px; margin: auto; background: lightgray; border: 1px solid #000;
  border-radius: 10px; padding: 30px; }

/* Sidebar */
.sidebar { background: #fff; border: 1px solid #000; border-radius: 10px; padding: 20px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.05); height: fit-content; }
.search-box { position: relative; }
.search-box input { width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #ccc; }
.search-box i { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #777; }

/* Cards */
.job-card { background: #fff; border: 1px solid #000; border-radius: 10px; padding: 20px;
  margin-bottom: 20px; box-shadow: 0 3px 8px rgba(0,0,0,0.05); }
.job-card h6 { font-weight: 700; }
.btn-details { background-color: #949494ff; color: black; border: none; padding: 8px 18px; border-radius: 6px; text-decoration: none; }
.btn-details:hover { background-color: #e5e5e5; text-decoration: none;}
.btn-details.text-danger { border: 1px solid #dc3545; color: #dc3545; background-color: #fff; }
.btn-details.text-danger:hover { background-color: #ff6776; color: #fff; }

.status-badge { background-color: #c2c2c2ff; font-size: 0.85rem; border-radius: 5px;
  padding: 5px 10px; font-weight: 600; }

/* Welcome */
.welcome-section { background-color: white; text-align: center; padding: 40px; border-radius: 10px; }
.welcome-section h2 { font-weight: 700; margin: 5px; }
.btn-apply { background-color: #446d1c; color: white; border: none; padding: 8px 18px;
  border-radius: 6px; text-decoration: none; display: inline-block; }
.btn-apply:hover { background-color: #385c17; }

.tname { font-family: 'Gabarito', sans-serif; font-size: 24px; font-weight: bold; }

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
      <a href="<?= site_url('boss_dashboard') ?>" class="nav-link active d-inline">Dashboard</a>
      <a href="<?= site_url('boss_view_applicants') ?>" class="nav-link  d-inline">View Applicants</a>
     <a href="<?= site_url('boss_profile') ?>" class="nav-link d-inline">Profile</a>
      <a href="<?= site_url('login') ?>" class="nav-link d-inline" id="logoutBtn">Log Out</a>
    </div>
  </div>
</nav>


<!-- ✅ Main -->
<div class="main">
  <div class="containers">
    <div class="welcome-section">
      <h2>Welcome Back <?= esc($full_name) ?>!</h2>
      <p>Discover top talent, post new job openings, and manage your applications easily.</p>
      <a href="<?= site_url('create_jobpost') ?>" class="btn-apply btn-sm mt-2">Create a Post</a>
    </div>
  </div>

  <div class="row g-4">
    <!-- Sidebar -->
    <div class="col-lg-4">
      <div class="sidebar">
        <div class="search-box mb-3">
          <input type="text" id="searchInput" placeholder="Search job posts...">
          <i class="bi bi-search"></i>
        </div>
        <h6 class="fw-bold mb-2">Filter by Type:</h6>
        <div class="filter-list">
          <div><input type="checkbox" class="filterType" value="Full-Time" id="fullTime"> <label for="fullTime">Full-Time</label></div>
          <div><input type="checkbox" class="filterType" value="Part-Time" id="partTime"> <label for="partTime">Part-Time</label></div>
          <div><input type="checkbox" class="filterType" value="Gig" id="gig"> <label for="gig">Gig</label></div>
        </div>
      </div>
    </div>

    <!-- Job Posts -->
    <div class="col-lg-8">
      <div class="container container-main">
        <h5 class="fw-bold mb-3 text-center">Jobs that you’ve posted:</h5>

        <div id="jobList">
          <?php if (!empty($jobs)): ?>
            <?php foreach ($jobs as $job): ?>
              <div class="job-card"
                   data-title="<?= strtolower(esc($job['title'])) ?>"
                   data-company="<?= strtolower(esc($job['company_name'] ?? $company_name)) ?>"
                   data-type="<?= esc($job['job_type']) ?>">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                  <div>
                    <h6 class="tname"><?= esc($job['title']) ?></h6>
                    <small><?= esc($job['company_name'] ?? $company_name) ?></small><br>
                    <small>Posted on: <?= date('M d, Y', strtotime($job['date_posted'])) ?></small>
                  </div>
                  <div class="text-end">
                    <span class="status-badge"><?= esc($job['job_type']) ?></span>
                  </div>
                </div>
                <div class="d-flex gap-2 mt-3 flex-wrap">
                  <a href="<?= site_url('edit_jobpost/' . $job['id']); ?>" class="btn-details btn-sm">
    <i class="bi bi-pencil-square"></i> Edit
</a>

                  <form method="POST" action="<?= site_url('delete_jobpost') ?>" 
                        onsubmit="return confirm('Are you sure you want to delete this job post? This action cannot be undone.');">
                    <input type="hidden" name="job_id" value="<?= $job['id']; ?>">
                    <button type="submit" class="btn-details btn-sm text-danger">Delete</button>
                  </form>


                </div>
              </div> 
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-center text-muted">No job post has been made.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Logout Modal -->
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

<!-- ✅ Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const checkboxes = document.querySelectorAll('.filterType');
  const jobCards = document.querySelectorAll('.job-card');
  const container = document.getElementById('jobList');

  function filterJobs() {
    const searchText = searchInput.value.toLowerCase().trim();
    const checkedTypes = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value.toLowerCase());

    let visibleCount = 0;
    jobCards.forEach(card => {
      const title = card.dataset.title;
      const company = card.dataset.company;
      const type = card.dataset.type.toLowerCase();

      const matchesSearch = title.includes(searchText) || company.includes(searchText);
      const matchesType = checkedTypes.length === 0 || checkedTypes.includes(type);

      card.style.display = (matchesSearch && matchesType) ? 'block' : 'none';
      if (matchesSearch && matchesType) visibleCount++;
    });

    let message = document.querySelector('.no-jobs-msg');
    if (!message) {
      message = document.createElement('p');
      message.className = 'text-center text-muted no-jobs-msg mt-3';
      message.textContent = 'No job post has been made.';
      container.appendChild(message);
    }
    message.style.display = visibleCount === 0 ? 'block' : 'none';
  }

  searchInput.addEventListener('input', filterJobs);
  checkboxes.forEach(cb => cb.addEventListener('change', filterJobs));

  // Logout modal
  const logoutBtn = document.getElementById("logoutBtn");
  logoutBtn.addEventListener("click", function(e) {
    e.preventDefault();
    const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
    modal.show();
  });

  document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
    window.location.href = "<?= site_url('logout') ?>";
  });
});
</script>

</body>
</html>
