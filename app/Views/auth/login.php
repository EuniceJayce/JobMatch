


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JobMatch Login</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: radial-gradient(circle at center, #ffffff, #f4f6d4, #d8f08a, #98b64d);
      height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
.logo-img {
  height: 40px;
  width: auto;
  margin-left: 80px;
}

    .top-bar {
      background-color: #5e7a1f;
      height: 60px;
      display: flex;
      align-items: center;
      padding-left: 50px;
    }

    .main-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 80px;
      flex-wrap: wrap;
    }

    .login-box {
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
      gap: 10px;
    }

    .tab-buttons button,
    .tab-buttons a {
      border: none;
      background: none;
      padding: 10px 25px;
      font-weight: 600;
      font-size: 16px;
      border-radius: 20px;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
      color: #333;
    }

    .tab-buttons .active,
    .tab-buttons a:hover {
      background-color: #f9f9b7;
      color: #5e7a1f;
      font-weight: 700;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .form-control {
      border-radius: 8px;
      padding-left: 40px;
    }

    .position-relative i {
      position: absolute;
      left: 15px;
      top: 13px;
      color: #777;
    }

    .btn-login {
      background-color: #5e7a1f;
      border: none;
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      color: white;
      font-weight: 600;
      margin-top: 15px;
      transition: 0.3s;
      text-align: center;
    }

    .btn-login:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    .right-section {
      max-width: 450px;
      text-align: center;
    }

    .main-title {
      font-size: 50px;
      font-weight: 800;
      background: linear-gradient(90deg, #6f9722, #e2c12d);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 15px;
    }

    .description {
      font-size: 12px;
      color: #333;
      line-height: 1.6;
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <img src="<?= base_url('imgs/logo.png') ?>" alt="JobMatch Logo" class="logo-img">
  </div>

  <div class="main-section">
    <div class="login-box">
      <div class="tab-buttons">
        <a href="<?= site_url('login') ?>" class="active">Log in</a>
        <a href="<?= site_url('signup') ?>">Sign Up</a>
      </div>

      <!-- ✅ Error alert -->
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-center">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?= site_url('login') ?>">
        <div class="mb-3 position-relative">
          <i class="bi bi-envelope"></i>
          <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        </div>

        <div class="mb-3 position-relative">
          <i class="bi bi-lock"></i>
          <input type="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>

        <button type="submit" name="login" class="btn-login">Log in</button>
      </form>

      
    </div>

    <div class="right-section">
      <h1 class="main-title">JobMatch</h1>
      <p class="description">
        Welcome to JobMatch — your trusted platform for connecting job seekers and employers. 
        Whether you're looking for your dream career or the perfect candidate, our system makes the process 
        fast, easy, and efficient. Explore opportunities and take your next step toward success today! 🌟
      </p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
