<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Find Jobs - JobMatch</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background-color: #f2f2f2; }
.navbar { background-color: #446d1c; }
.navbar a { color: white !important; font-weight: 500; margin-right: 20px; text-decoration: none !important; }
.navbar a.active { color: #FFD43B !important; }
.logo-img { height: 40px; width: auto; margin-left: 80px; }
.main { max-width: 1100px; margin: auto; padding: 30px; background-color: #ffffffff; }
.sidebar { background: #fff; border: 1px solid #000; border-radius: 10px; padding: 20px; height: fit-content; }
.search-box { position: relative; margin-bottom: 20px; }
.search-box input { width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #ccc; }
.search-box i { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #777; }
.container-main { background: #bdbdbdff; border: 1px solid #000; border-radius: 10px; padding: 25px; }
.job-card { background: #fff; border: 1px solid #000; border-radius: 10px; padding: 18px; margin-bottom: 20px; }
.job-card h5 { font-weight: 700; }
.job-card .desc-preview { color: #555; max-height: 3.6em; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
.badge-type { background-color: #e3e3e3ff; font-size: 0.85rem; border-radius: 6px; padding: 5px 10px; font-weight: 600; }
.btn-apply { background-color: #689F38; color: white; border: none; padding: 8px 20px; border-radius: 6px; font-weight: 600; }
.btn-apply:hover { background-color: #558B2F; }
.btn-details { background-color: #949494; color: black; border: none; padding: 8px 20px; border-radius: 6px; font-weight: 600; }
.btn-details:hover { background-color: #b0b0b0; }
.modal { pointer-events:auto !important; }
.modal-backdrop.show { pointer-events:none !important; }
@media (max-width: 991px) { .main { padding: 0 15px; } }
</style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <img src="<?= base_url('imgs/logo.png') ?>" alt="JobMatch Logo" class="logo-img">
    <div class="ms-auto">
      <a href="<?= site_url('emp_dashboard') ?>" class="nav-link d-inline">Dashboard</a>
      <a href="<?= site_url('emp_find_jobs') ?>" class="nav-link active d-inline">Find Jobs</a>
      <a href="<?= site_url('emp_profile') ?>" class="nav-link d-inline">Profile</a>
      <a href="<?= site_url('login') ?>" class="nav-link d-inline" id="logoutBtn">Log Out</a>
    </div>
  </div>
</nav>

<div class="main">
  <div class="row g-4 p-4">
    <div class="col-lg-4">
      <div class="sidebar">
        <div class="search-box">
          <input type="text" id="searchInput" placeholder="Search something...">
          <i class="bi bi-search"></i>
        </div>
        <h6 class="fw-bold mb-2">Search Filter:</h6>
        <div class="filter-list">
          <div><input type="checkbox" class="filterType" value="Full-Time" id="fullTime"> <label for="fullTime">Full-Time</label></div>
          <div><input type="checkbox" class="filterType" value="Part-Time" id="partTime"> <label for="partTime">Part-Time</label></div>
          <div><input type="checkbox" class="filterType" value="Gig" id="gig"> <label for="gig">Gig</label></div>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="container container-main">
        <h5 class="fw-bold mb-3 text-center">Available Jobs:</h5>
        <div class="text-end">
          <button class="btn btn-sm btn-outline-secondary mb-3" id="refreshJobs">Refresh Jobs</button>
        </div>

        <div id="jobList">
  <?php if (!empty($jobs)): ?>
    <?php 
      $hasVisibleJobs = false; 
      foreach ($jobs as $job): 
        if (!in_array($job['id'], $appliedJobs)): 
          $hasVisibleJobs = true;
    ?>
          <div class="job-card" id="job-<?= $job['id'] ?>">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
              <h5 class="fw-bold mb-0"><?= esc($job['title']) ?></h5>
              <h6>Work Type: <span class="badge-type"><?= esc($job['job_type']) ?></span></h6>
            </div>
            <small class="text-muted"><?= esc($job['company_name']) ?></small><br>
            <p class="desc-preview mt-2"><?= nl2br(esc($job['description'])) ?></p>
            <small class="fw-semibold">₱<?= esc($job['salary_range']) ?> / monthly</small>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
              <div>
                <button class="btn-details btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal"
                  data-id="<?= $job['id'] ?>"
                  data-title="<?= esc($job['title']) ?>"
                  data-company="<?= esc($job['company_name']) ?>"
                  data-type="<?= esc($job['job_type']) ?>"
                  data-desc="<?= esc($job['description']) ?>"
                  data-salary="<?= esc($job['salary_range']) ?>"
                  data-date="<?= date('M d, Y', strtotime($job['date_posted'])) ?>">
                  View Details
                </button>
                <button class="btn-apply" 
                  data-bs-toggle="modal" 
                  data-bs-target="#applyModal"
                  data-id="<?= $job['id'] ?>">
                  Apply
                </button>
              </div>
              <small class="text-muted mt-2">
                Posted on: <?= date('M d, Y', strtotime($job['date_posted'])) ?>
              </small>
            </div>
          </div>
    <?php 
        endif;
      endforeach;
      if (!$hasVisibleJobs):
    ?>
      <p id="noJobsMsg" class="text-center text-dark mt-4">No available jobs right now.</p>
    <?php endif; ?>
  <?php else: ?>
    <p id="noJobsMsg" class="text-center text-dark mt-4">No available jobs right now.</p>
  <?php endif; ?>
</div>


    </div>
  </div>
</div>

<!-- ✅ Job Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-3">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Job Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body mt-2" style="max-height: 70vh; overflow-y: auto;">
        <h4 id="modalJobTitle" class="fw-bold mb-1"></h4>
        <p><strong>Company:</strong> <span id="modalCompany"></span></p>
        <p><strong>Work Type:</strong> <span id="modalType"></span></p>
        <p><strong>Salary:</strong> <span id="modalSalary"></span></p>
        <div class="border-top pt-3">
          <h6 class="fw-bold mb-2">Description:</h6>
          <p id="modalDesc" style="white-space: pre-line; text-align: justify; line-height: 1.6;"></p>
        </div>
        <div class="text-muted mt-3 small"><strong>Posted on:</strong> <span id="modalDate"></span></div>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-success px-4" style="background-color:#446d1c; border:none;" id="detailsApplyButton">Apply Now</button>
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Apply Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold w-100 text-center">Apply Form</h5>
      </div>
      <div class="modal-body">
        <h6 class="fw-bold text-center mb-3">Hello! <?= esc($full_name ?? 'Guest') ?></h6>
        <form id="applyForm" method="POST" enctype="multipart/form-data" action="<?= base_url('submit_application') ?>">

          <input type="hidden" name="job_id" id="applyJobId">
          <div class="mb-3">
            <label class="form-label fw-semibold">Cover Letter <small>(Optional)</small></label>
            <textarea name="cover_letter" class="form-control" rows="4" placeholder="Write your message to the employer..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Upload Resume</label>
            <input type="file" name="resume" class="form-control" required>
          </div>
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-success px-4" style="background-color:#446d1c; border:none;">Confirm</button>
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
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
        <p>Are you sure you want to log out of your JobMatch personal account?</p>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmLogoutBtn">Logout</button>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const detailsModalEl = document.getElementById('detailsModal');
  const applyModalEl = document.getElementById('applyModal');
  const detailsApplyButton = document.getElementById('detailsApplyButton');
  const applyForm = document.getElementById('applyForm');
  const applyJobIdInput = document.getElementById('applyJobId');
  let currentJobId = null;

  detailsModalEl.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    currentJobId = button.getAttribute('data-id');
    document.getElementById('modalJobTitle').textContent = button.getAttribute('data-title');
    document.getElementById('modalCompany').textContent = button.getAttribute('data-company');
    document.getElementById('modalType').textContent = button.getAttribute('data-type');
    document.getElementById('modalSalary').textContent = button.getAttribute('data-salary');
    document.getElementById('modalDesc').textContent = button.getAttribute('data-desc');
    document.getElementById('modalDate').textContent = button.getAttribute('data-date');
  });

  detailsApplyButton.addEventListener('click', () => {
    const detailsModal = bootstrap.Modal.getInstance(detailsModalEl);
    detailsModal.hide();
    detailsModalEl.addEventListener('hidden.bs.modal', () => {
      applyJobIdInput.value = currentJobId;
      const applyModal = new bootstrap.Modal(applyModalEl);
      applyModal.show();
    }, { once: true });
  });

  applyForm.addEventListener('submit', async (e) => {
    console.log("JOB ID SENT:", jobId);

    e.preventDefault();
    const jobId = applyJobIdInput.value;
    const formData = new FormData(applyForm);
    formData.set('job_id', jobId);

    try {
      const res = await fetch('<?= base_url("submit_application") ?>', { method: 'POST', body: formData });
      const result = await res.json();

      if (result.success) {
        document.querySelector(`#job-${jobId}`)?.remove();
        bootstrap.Modal.getInstance(applyModalEl)?.hide();
        alert('✅ Application submitted successfully!');
      } else {
        alert('⚠ ' + result.message);
      }
    } catch (err) {
      console.error(err);
      alert('❌ Something went wrong.');
    }
  });

  // ... (keep all the existing JavaScript above this point, including the details modal logic)

  // 1. Logic for the 'Apply' button on the Job Card
  applyModalEl.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget; // The button that triggered the modal
    // Check if the button has the data-id attribute (only the card's 'Apply' button will)
    if (button.hasAttribute('data-id')) { 
      const jobId = button.getAttribute('data-id');
      // Set the hidden input field's value to the job ID
      applyJobIdInput.value = jobId; 
    }
  });


// --- Search + Filter Logic ---
const searchInput = document.getElementById("searchInput");
const filterCheckboxes = document.querySelectorAll(".filterType");
const jobContainer = document.querySelector(".container-main");
const jobList = document.getElementById("jobList");
let jobCards = jobList ? jobList.querySelectorAll(".job-card") : [];



// Create "no result" message
const noResultMsg = document.createElement("p");
noResultMsg.textContent = "No posts related to your search.";
noResultMsg.className = "text-center text-muted fw-semibold mt-3";
noResultMsg.style.display = "none";
jobContainer.appendChild(noResultMsg);

function filterJobs() {
  const searchQuery = searchInput.value.toLowerCase();
  const selectedTypes = Array.from(filterCheckboxes)
    .filter(cb => cb.checked)
    .map(cb => cb.value.toLowerCase());

  let visibleCount = 0;

  jobCards.forEach(card => {
    const title = card.querySelector("h5").textContent.toLowerCase();
    const company = card.querySelector(".text-muted").textContent.toLowerCase();
    const desc = card.querySelector(".desc-preview").textContent.toLowerCase();
    const jobType = card.querySelector(".badge-type").textContent.toLowerCase();

    const matchesSearch =
      title.includes(searchQuery) ||
      company.includes(searchQuery) ||
      desc.includes(searchQuery);

    const matchesType =
      selectedTypes.length === 0 || selectedTypes.includes(jobType);

    if (matchesSearch && matchesType) {
      card.style.display = "";
      visibleCount++;
    } else {
      card.style.display = "none";
    }
  });

  // ✅ Show or hide "no result" message
  noResultMsg.style.display = visibleCount === 0 ? "block" : "none";
}

// --- Add event listeners ---
searchInput.addEventListener("input", filterJobs);
filterCheckboxes.forEach(cb => cb.addEventListener("change", filterJobs));

}); // End of DOMContentLoaded
</script>

<script>
document.getElementById('applyForm').addEventListener('submit', function(event) {
    event.preventDefault(); // stop page reload

    const formData = new FormData(this);

    fetch('<?= base_url('submit_application') ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = "<?= base_url('emp_find_jobs') ?>"; // redirect after success
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error('Error submitting:', err);
        alert('Something went wrong!');
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



</body>
</html>
