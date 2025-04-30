<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fitness</title>
  <link
    rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <style>
    /* Hero Slider */
    .slider-image {
      width: 100%;
      height: 500px;
      object-fit: cover;
      filter: brightness(0.85);
    }

    .carousel-caption {
      background: rgba(0, 0, 0, 0.45);
      padding: 20px;
      border-radius: 10px;
    }

    .carousel-caption h1 {
      font-size: 2.8rem;
    }

    .carousel-caption p {
      font-size: 1.1rem;
      color: #d1d1d1;
    }

    .carousel-caption a.btn {
      background-color: #e66a11;
      border: none;
      padding: 10px 20px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .carousel-caption a.btn:hover {
      background-color: #e65c00;
    }

    /* Category Section */
    .category {
      text-align: center;
      background-color: #1e1e1e;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 30px;
    }

    .category:hover {
      transform: scale(1.03);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
    }

    .category img {
      width: 100%;
      max-height: 180px;
      object-fit: cover;
      border-radius: 10px;
    }

    .category h2 {
      margin-top: 15px;
    }

    .category p {
      color: #d1d1d1;
    }

    .category a {
      background-color: #ff6f00;
      color: #fff;
      font-weight: bold;
      padding: 0.5rem 1.5rem;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .category a:hover {
      background-color: #e66a11;
    }

    /* Services Section */
    .services-bg {
      background-color: #1e1e1e;
      border-radius: 5px;
      padding: 40px 20px;
      margin-top: 40px;
    }

    .services-bg h2 {
      color: #fff;
      margin-bottom: 30px;
    }

    .services img {
      width: 80px;
      margin: 15px auto;
    }

    .services h3 {
      color: #f8f9fa;
      margin-top: 15px;
    }

    .services p {
      color: #d1d1d1;
    }

    /* Pricing Section */
    .pricing-bg {
      background-color: #121212;
      color: #fff;
      padding: 60px 20px;
      border-radius: 8px;
      margin: auto;
      margin-top: 20px;
      margin-bottom: 10px;
    }

    .text-orange {
      color: #ff6f00;
    }

    .pricing-card {
      background-color: #1a1a1a;
      padding: 30px;
      border: 1px solid #333;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 30px;
    }

    .pricing-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
    }

    .pricing-card h3 {
      margin-bottom: 15px;
      color: #fff;
    }

    .pricing-card .price {
      font-size: 2.5rem;
      color: #ff6f00;
      margin: 20px 0;
    }

    .pricing-card p,
    .pricing-card ul li {
      color: #bbb;
      font-size: 0.95rem;
    }

    .pricing-card a.btn {
      background-color: #ff6f00;
      border: none;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      text-transform: uppercase;
      transition: background-color 0.3s ease;
    }

    .pricing-card a.btn:hover {
      background-color: #e65c00;
    }
  </style>
</head>

<body class="dark-theme">
  <?php include './components/navbar.php'; ?>

  <main>
    <?php
    $page = $_GET['page'] ?? 'home';
    $folder = $_GET['fd'] ?? '';
    $file = $folder ? "./memberPages/$page.php" : "$page.php";

    if (file_exists($file)) {
      include $file;
    } else {
      echo "<section class='py-5 text-center mt-4'>
      <h2>404: Page Not Found</h2>
    </section>";
    }
    ?>


  </main>

  <?php include './components/footer.php'; ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>