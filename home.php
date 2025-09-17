<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>C MOTOR PARTS AND ACCESSORIES</title>
  <link rel="stylesheet" href="css/home.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <nav>
    <ul class="navbar">
      <li><a href="home.php"><i class="fas fa-home"></i> HOME</a></li>
      <li><a href="about.php"><i class="fas fa-info-circle"></i> ABOUT US</a></li>
      <li><a href="products.php"><i class="fas fa-box"></i> PRODUCTS</a></li>
      <li><a href="services.php"><i class="fas fa-cogs"></i> SERVICES</a></li>
      <li><a href="contact.php"><i class="fas fa-envelope"></i> CONTACT</a></li>

      <?php if (isset($_SESSION['user_id'])): ?>
        <!-- If logged in -->
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> LOGOUT</a></li>
      <?php else: ?>
        <!-- If not logged in -->
        <li><a href="index.php"><i class="fas fa-sign-in-alt"></i> LOGIN</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <div class="floating-title">
    <h1 class="title-box">
      <span class="line">C MOTOR PARTS</span>
      <span class="line">AND</span>
      <span class="line">ACCESSORIES</span>
    </h1>
  </div>

  <footer>
    <p>&copy; 2025 C MOTOR PARTS. ALL RIGHTS RESERVED.</p>
  </footer>
</body>
</html>
