<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JobMatch</title>

  <!-- ✅ Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@700;800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- ✅ Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      min-height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    /* Top Header */
    .top-bar {
      background-color: #5e7a1f;
      height: 60px;
      display: flex;
      align-items: center;
      padding-left: 40px;
    }

    .logo-img {
      height: 40px;
      width: auto;
      margin-left: 100px;
    }

    /* Background Gradient */
    .main-section {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: radial-gradient(circle at center, #ffffff, #f4f6d4, #d8f08a, #98b64d);
      text-align: center;
      padding: 60px 20px;
    }

    .content-box {
      max-width: 800px;
    }

    .main-title {
      font-family: 'Gabarito', sans-serif;
      font-size: 60px;
      font-weight: 800;
      background: linear-gradient(90deg, #6f9722, #e2c12d);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 25px;
    }

    .description {
      color: #333;
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 40px;
    }

    .role-label {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 25px;
      color: #000;
    }

    .role-btn {
      font-size: 18px;
      font-weight: 700;
      color: white;
      padding: 12px 40px;
      border: none;
      border-radius: 12px;
      margin: 10px;
      background: linear-gradient(90deg, #6f9722, #e2c12d);
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .role-btn:hover {
      opacity: 0.9;
      transform: translateY(-3px);
      text-decoration: none;
    }

    @media (max-width: 768px) {
      .main-title { font-size: 40px; }
      .role-btn { display: block; width: 80%; margin: 10px auto; }
    }
  </style>
</head>
<body>
  <!-- Top Bar -->
  <div class="top-bar">
    <img src="<?= base_url('imgs/logo.png') ?>" alt="JobMatch Logo" class="logo-img">
  </div>

  <!-- Main Section -->
  <div class="main-section">
    <div class="content-box">
      <h1 class="main-title">JobMatch</h1>
      <p class="description">
        Welcome to JobMatch, your trusted platform for connecting job seekers and employers in one seamless space. 
        Whether you're an applicant searching for your dream career or an employer looking for the perfect candidate, 
        our system makes the process fast, easy, and efficient. With personalized dashboards, smart matching, and 
        real-time updates, JobMatch empowers users to take the next step toward professional success. Start exploring 
        opportunities today and let your journey to a better career begin! 🌟
      </p>
      <p class="role-label">Choose your role:</p>

      <!-- ✅ Fixed the links -->
      <a href="<?= site_url('login') ?>" class="role-btn">Employer</a>
<a href="<?= site_url('login') ?>" class="role-btn">Job Seeker</a>

    </div>
  </div>

  <!-- Bootstrap Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
