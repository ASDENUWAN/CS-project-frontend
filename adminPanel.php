<?php
session_start();
//Then check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
  header("Location: index.php?page=login");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <!-- Bootstrap CSS (Using Bootstrap 4 CDN here; you can switch to v5 if preferred) -->
  <link
    rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

  <!-- Bootstrap Icons (Optional, for icons) -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
    rel="stylesheet" />

  <!-- Custom CSS -->
  <style>
    /* Dark Theme */
    body {
      background-color: #070707;
      color: #f8f9fa;
      font-family: "Arial", sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background-color: #000;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      padding-top: 20px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
      z-index: 999;
    }

    .sidebar .logo-container {
      text-align: center;
      margin-bottom: 1rem;
    }

    .sidebar .logo-container img {
      width: 120px;
    }

    .sidebar .nav-link {
      color: #f8f9fa;
      padding: 12px 20px;
      font-weight: 500;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #1e1e1e;
      color: #e66a11;
    }

    .sidebar .bi {
      margin-right: 10px;
    }

    @media (max-width: 767.98px) {
      .sidebar {
        display: none;
        width: 100%;
        position: absolute;
        top: 56px;
        /* height of topbar */
        background-color: #000;
        z-index: 1000;
        padding-bottom: 1rem;
      }

      .sidebar.show {
        display: block;
      }

      .main-content {
        margin-left: 0 !important;
      }

      .top-navbar {
        left: 0;
      }
    }

    /* Main Content */
    .main-content {
      margin-left: 240px;
      padding: 20px;
    }

    /* Top Navbar */
    .top-navbar {
      background-color: #000;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: fixed;
      top: 0;
      left: 240px;
      right: 0;
      z-index: 998;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }

    .top-navbar .navbar-brand {
      color: #f8f9fa;
      font-weight: bold;
      text-decoration: none;
    }

    .top-navbar .navbar-brand:hover {
      color: #e66a11;
    }

    .top-navbar .nav-item .nav-link {
      color: #f8f9fa;
      margin-right: 15px;
      transition: color 0.3s ease;
    }

    .top-navbar .nav-item .nav-link:hover {
      color: #e66a11;
    }

    .btn-login {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background-color: #e66a11;
      color: #fff;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 1rem;
      font-weight: bold;
      transition: background-color 0.3s ease, transform 0.2s ease;
      margin-top: 5px;
      margin-bottom: 5px;
    }

    /* Dashboard Cards */
    .card {
      background-color: #1e1e1e;
      border: none;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      margin-bottom: 20px;
    }

    .card .card-body {
      color: #f8f9fa;
    }

    .card h5 {
      color: #f8f9fa;
    }

    .card p {
      color: #d1d1d1;
    }

    /* Table Styling */
    .table thead th {
      border-bottom: 2px solid #e66a11;
      color: #e66a11;
    }

    .table tbody td {
      color: #f8f9fa;
    }

    .table-dark.table-striped tbody tr:nth-of-type(2n + 1) {
      background-color: #2a2a2a;
    }

    /* Footer */
    .footer {
      margin-top: 20px;
      color: #d1d1d1;
      text-align: center;
      padding: 20px 0;
    }

    .footer a {
      color: #e66a11;
      text-decoration: none;
    }

    .footer a:hover {
      color: #e65c00;
    }

    @media (max-width: 767.98px) {
      .sidebar {
        display: none;
        width: 100%;
        position: absolute;
        top: 56px;
        /* height of topbar */
        background-color: #000;
        z-index: 1000;
        padding-bottom: 1rem;
      }

      .sidebar.show {
        display: block;
      }

      .main-content {
        margin-left: 0 !important;
      }

      .top-navbar {
        left: 0;
      }
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <?php include './components/sideBar.php'; ?>
  <?php include './components/topBar.php'; ?>
  <main>
    <?php
    $page = $_GET['page'] ?? 'adminDash';
    $folder = $_GET['fd'] ?? '';
    $file = $folder ? "./adminPages/$folder/$page.php" : "./adminPages/$page.php";

    if (file_exists($file)) {
      include $file;
    } else {
      echo "<section class='py-5 text-center mt-4'><h2>404: Page Not Found</h2></section>";
    }
    ?>
  </main>
  <?php include './components/adminFooter.php'; ?>
  <!-- JS (jQuery, Popper, Bootstrap) -->

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    document.getElementById("sidebarToggle").addEventListener("click", function() {
      const sidebar = document.querySelector(".sidebar");
      sidebar.classList.toggle("show");
    });
  </script>
  <!-- Optionally include a chart library like Chart.js if you want dynamic charts -->
</body>

</html>