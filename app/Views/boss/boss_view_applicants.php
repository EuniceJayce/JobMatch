
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Applicants - JobMatch (Company)</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@700;800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background-color: #f2f2f2; }
.navbar { background-color: #446d1c; }
.navbar a { color: white !important; font-weight: 500; margin-right: 20px; text-decoration: none !important; }
.navbar a.active { color: #FFD43B !important; }
.logo-img { height: 40px; width: auto; margin-left: 80px; }
.main { max-width: 1100px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
.sidebar { background: #fff; border: 1px solid #000; border-radius: 10px; padding: 20px; height: fit-content; }
.container-main { background: #d9d9d9; border: 1px solid #000; border-radius: 10px; padding: 30px; margin-bottom: 20px; }
.job-header { display: flex; justify-content: space-between; align-items: flex-start; }
.job-header h5 { font-weight: 700; }
.status-badge { background-color: #FFD966; font-size: 0.85rem; border-radius: 6px; padding: 5px 10px; font-weight: 600; }
.btn-details { background-color: #949494; color: black; border: none; padding: 6px 16px; border-radius: 6px; text-decoration: none !important; }
.btn-details:hover { background-color: #e5e5e5; text-decoration: none !important; }
.applicant-card { background: white; border: 1px solid #000; border-radius: 10px; padding: 20px; margin-top: 15px; }
.btn-green { background-color: #446d1c; color: white; border: none; border-radius: 6px; padding: 6px 16px; }
.btn-green:hover { background-color: #385c17; }
.btn-gray { background-color: #6c757d; color: white; border: none; border-radius: 6px; padding: 6px 16px; }
.btn-gray:hover { background-color: #555; }
select.status-select { border: 1px solid #ccc; border-radius: 6px; padding: 4px 6px; }
form.app-actions { display: flex; align-items: center; gap: 10px; margin-top: 10px; }
.modal textarea { resize: none; }
.search-box {
  position: relative;
}

.search-box input {
  width: 100%;
  padding: 8px 36px 8px 12px; /* right padding for icon space */
  border-radius: 8px;
  border: 1px solid #ccc;
}

.search-box i {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #777;
  pointer-events: none; /* icon won’t block clicks */
}


button[data-bs-toggle="collapse"] {
  font-weight: 600;
}


.icon-btn {
  background: transparent;
  border: none;
  color: black;
  font-size: 1.3rem;
  cursor: pointer;
  transition: 0.2s ease;
}

.icon-btn:hover {
  color: #446d1c;
  transform: scale(1.1);
}

.icon-btn.text-danger:hover {
  color: #dc3545;
}



</style>
</head>
<body>
<?php if (session()->getFlashdata('success')): ?>
  <script>
    alert("<?= session()->getFlashdata('success') ?>");
  </script>
<?php endif; ?>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <img src="<?= base_url('imgs/logo.png') ?>" alt="JobMatch Logo" class="logo-img">
    <div class="ms-auto">
      <a href="<?= site_url('boss_dashboard') ?>" class="nav-link  d-inline">Dashboard</a>
      <a href="<?= site_url('boss_view_applicants') ?>" class="nav-link active d-inline">View Applicants</a>
      <a href="<?= site_url('boss_profile') ?>" class="nav-link d-inline">Profile</a>
      <a href="<?= site_url('login') ?>" class="nav-link d-inline" id="logoutBtn">Log Out</a>
    </div>
  </div>
</nav>

<!-- ✅ Main Section -->
<div class="main">
 <?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success text-center">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger text-center">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

 <?php if (isset($_GET['deleted'])): ?>
  <div id="deleteAlert" class="alert alert-success text-center">
    ✅ Job post deleted successfully.
  </div>
<?php endif; ?>

  <div class="row g-4">
    <!-- Sidebar -->
    <div class="col-lg-4">
      <div class="sidebar">
        <div class="search-box mb-3">
          <input type="text" placeholder="Search something..." class="form-control">
          <i class="bi bi-search"></i>
        </div>
        <h6 class="fw-bold mb-2">Search Filter:</h6>
        <div class="filter-list">
          <div><input type="checkbox" id="fullTime"> <label for="fullTime">Full-Time</label></div>
          <div><input type="checkbox" id="partTime"> <label for="partTime">Part-Time</label></div>
          <div><input type="checkbox" id="gig"> <label for="gig">Gig</label></div>
        </div>
      </div>
    </div>

    <!-- Job Details & Applicants -->
    <div class="col-lg-8">
      <?php if (!empty($jobs)): ?>
  <?php foreach ($jobs as $job): ?>
    <div class="container container-main">
      <div class="job-header">
        <div>
        <h5><?php echo htmlspecialchars($job['title']); ?></h5>
        <small class="text-muted d-block">
          <?php 
            echo !empty($job['company_name']) 
              ? htmlspecialchars($job['company_name']) 
              : "Not a company"; 
          ?>
        </small>
        <small>Posted on: <?php echo date('M d, Y', strtotime($job['date_posted'])); ?></small>
      </div>

        <div class="text-end">
          <span class="status-badge"><?php echo htmlspecialchars($job['job_type']); ?></span><br>
          
        </div>
      </div>

      
          
          <h6 class="fw-bold mt-3">Job Description:</h6>
<p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>

<!-- ✅ Add Company and Salary Info Below Description -->
<div class="mt-3 mb-4">
  <p><strong>Company:</strong> 
    <?php 
      echo !empty($job['company_name']) 
        ? htmlspecialchars($job['company_name']) 
        : "Not a company"; 
    ?>
  </p>

  <p><strong>Salary Range:</strong> 
  <?php 
    if (!empty($job['salary_range'])) {
      $salary = trim($job['salary_range']);

      // detect if range (like 20000 - 30000)
      if (strpos($salary, '-') !== false) {
        list($min, $max) = array_map('trim', explode('-', $salary));
        $minFormatted = '₱' . number_format((float)$min);
        $maxFormatted = '₱' . number_format((float)$max);
        echo $minFormatted . ' - ' . $maxFormatted;
      } else {
        // single value
        $salaryValue = preg_replace('/[^\d.]/', '', $salary);
        echo '₱' . number_format((float)$salaryValue);
      }
    } else {
      echo "Not specified";
    }
  ?>
</p>

</div>



  

      <button class="btn btn-sm btn-outline-secondary mt-3 d-flex align-items-center gap-1"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#jobCollapse<?php echo $job['id']; ?>"
        aria-expanded="false"
        aria-controls="jobCollapse<?php echo $job['id']; ?>">
  <i class="bi bi-eye"></i> View Applicants
</button>


<!-- Collapsible job details -->
      <div class="collapse mt-3" id="jobCollapse<?php echo $job['id']; ?>">
        <div class="card card-body border-0 p-20">
          <h6 class="fw-bold  mb-3">Applicants: </h6>

          <?php
          // ✅ Fetch applicants for this job
          $app_sql = "
              SELECT a.*, js.full_name 
              FROM job_applications a
              JOIN users js ON a.applicant_id = js.id
              WHERE a.job_id = ?
              ORDER BY a.date_applied DESC
          ";
          $db = \Config\Database::connect();
          $applicants = $db->query("
              SELECT a.*, js.full_name 
              FROM job_applications a
              JOIN users js ON a.applicant_id = js.id
              WHERE a.job_id = ?
                AND js.role = 'job_seeker'
              ORDER BY a.date_applied DESC
          ", [$job['id']])->getResultArray();

          if (!empty($applicants)):
            foreach ($applicants as $row):

          ?>
            <div class="applicant-card">
              <h6 class="fw-bold mb-2"><?php echo htmlspecialchars($row['full_name']); ?></h6>

              <p><strong>Cover Letter:</strong><br>
                <?php echo nl2br(htmlspecialchars($row['cover_letter'] ?? 'No cover letter provided.')); ?>
              </p>

              <p><strong>Requirements:</strong><br>
                <?php if (!empty($row['resume'])): ?>
                  <a href="<?= base_url('uploads/resumes/' . $row['resume']) ?>" target="_blank" class="text-decoration-none">
                    <i class="bi bi-paperclip"></i> Download Attachment
                  </a>

                <?php else: ?>
                  <span class="text-muted">No resume uploaded.</span>
                <?php endif; ?>
              </p>

            

                <form action="<?= site_url('update_status') ?>" method="POST" class="app-actions">
                <input type="hidden" name="application_id" value="<?= $row['id'] ?>">
                <select name="status" class="status-select">
                  <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                  <option value="hired" <?= $row['status'] === 'hired' ? 'selected' : '' ?>>Hired</option>
                  <option value="rejected" <?= $row['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>
                <button type="submit" class="btn btn-success">Update</button>
             
                <button type="button" class="btn-gray" data-bs-toggle="modal" data-bs-target="#messageModal<?php echo $row['id']; ?>">
                  Send Message
                </button>
              </form>

              <small class="text-muted d-block mt-2">
                Applied on: <?php echo !empty($row['date_applied']) ? date('M d, Y', strtotime($row['date_applied'])) : 'N/A'; ?>
              </small>
            </div>

            <!-- Modal for sending a message -->
            <div class="modal fade" id="messageModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="messageModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="<?= site_url('send_message') ?>" method="POST">
                    <div class="modal-header">
                      <h5 class="modal-title" id="messageModalLabel<?php echo $row['id']; ?>">Send Message to <?php echo htmlspecialchars($row['full_name']); ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="receiver_id" value="<?php echo $row['applicant_id']; ?>">
                      <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">

                      <!-- 🔹 Container for showing recent messages -->
                      <div id="sentMessages<?php echo $row['id']; ?>" class="mb-3 p-2 border rounded bg-light" 
                          style="max-height: 150px; overflow-y: auto; font-size: 0.9rem;">
                        <em class="text-muted">Loading previous messages...</em>
                      </div>

                      <textarea name="message" class="form-control" rows="4" placeholder="Type your message..."></textarea>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn-green">Send</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          <?php else: ?>
              <p class="text-center text-muted">No applicants have applied on this post.</p>
          <?php endif; ?>

        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p class="text-center text-muted">You haven’t posted any jobs yet.</p>
<?php endif; ?>


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
document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.querySelector(".search-box input");
  const checkboxes = document.querySelectorAll(".filter-list input[type='checkbox']");
  const jobContainers = document.querySelectorAll(".container-main");

  // 🔍 Filter function
  function filterJobs() {
    const searchText = searchInput.value.toLowerCase();
    const selectedFilters = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.id.toLowerCase());

    jobContainers.forEach(job => {
      const title = job.querySelector("h5").textContent.toLowerCase();
      const jobType = job.querySelector(".status-badge").textContent.toLowerCase();

      const matchesSearch = title.includes(searchText);
      const matchesFilter = selectedFilters.length === 0 || selectedFilters.includes(jobType.replace("-", ""));

      if (matchesSearch && matchesFilter) {
        job.style.display = "";
      } else {
        job.style.display = "none";
      }
    });

    // If no jobs match, show message
    const visibleJobs = Array.from(jobContainers).filter(j => j.style.display !== "none");
    if (visibleJobs.length === 0) {
      if (!document.querySelector(".no-results")) {
        const msg = document.createElement("p");
        msg.className = "no-results text-center text-muted mt-3";
        msg.textContent = "No post related to that.";
        document.querySelector(".col-lg-8").appendChild(msg);
      }
    } else {
      const msg = document.querySelector(".no-results");
      if (msg) msg.remove();
    }
  }

  // 🔁 Event listeners
  searchInput.addEventListener("input", filterJobs);
  checkboxes.forEach(cb => cb.addEventListener("change", filterJobs));
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const alertBox = document.getElementById("deleteAlert");
  if (alertBox) {
    setTimeout(() => {
      alertBox.style.transition = "opacity 0.5s ease";
      alertBox.style.opacity = "0";
      setTimeout(() => alertBox.remove(), 500); // remove from DOM after fade-out
    }, 3000); // ⏱️ 3 seconds
  }
});
</script>


<script>
function confirmDelete(jobId) {
  if (confirm("Are you sure you want to delete this job post?")) {
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "<?= base_url('delete_jobpost') ?>";
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "job_id";
    input.value = jobId;
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
  }
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const modals = document.querySelectorAll('[id^="messageModal"]');

  modals.forEach(modal => {
    modal.addEventListener('show.bs.modal', function(event) {
      const receiverId = modal.querySelector('input[name="receiver_id"]').value;
      const jobId = modal.querySelector('input[name="job_id"]').value;
      const messageBox = modal.querySelector('[id^="sentMessages"]');

      fetch("<?= site_url('fetch_sent_messages') ?>", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          receiver_id: receiverId,
          job_id: jobId
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.length === 0) {
          messageBox.innerHTML = "<em class='text-muted'>No previous messages.</em>";
        } else {
          let html = "";
          data.forEach(msg => {
            html += `
              <div class="border-bottom mb-1 pb-1">
                <small class="text-muted">${new Date(msg.date_sent).toLocaleString()}</small><br>
                ${msg.message}
              </div>
            `;
          });
          messageBox.innerHTML = html;
        }
      })
      .catch(() => {
        messageBox.innerHTML = "<em class='text-danger'>Error loading messages.</em>";
      });
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
      window.location.href = "<?= site_url('logout') ?>";
    });
  }
});
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
