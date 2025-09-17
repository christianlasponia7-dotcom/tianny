<?php
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>C MOTOR PARTS AND ACCESSORIES - Contact Us</title>
  <link rel="stylesheet" href="css/contact.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- =========================
       Custom Logout Confirmation Modal
       ========================= -->
  <div id="logoutModal" class="logout-modal" role="dialog" aria-modal="true" aria-labelledby="logoutTitle">
    <div class="logout-content">
      <h2 id="logoutTitle"><i class="fas fa-sign-out-alt"></i> Confirm Logout</h2>
      <p>Are you sure you want to log out?</p>
      <div class="logout-buttons">
        <button id="confirmLogout" class="confirm-btn">Yes</button>
        <button id="cancelLogout" class="cancel-btn">Cancel</button>
      </div>
    </div>
  </div>

  <!-- =========================
       Navigation
       ========================= -->
  <nav>
    <ul class="navbar">
      <li><a href="home.php"><i class="fas fa-home"></i> HOME</a></li>
      <li><a href="about.php"><i class="fas fa-info-circle"></i> ABOUT US</a></li>
      <li><a href="products.php"><i class="fas fa-box"></i> PRODUCTS</a></li>
      <li><a href="services.php"><i class="fas fa-cogs"></i> SERVICES</a></li>
      <li><a href="contact.php" class="active"><i class="fas fa-envelope"></i> CONTACT</a></li>
      <li><a href="#" class="logout-btn"><i class="fas fa-sign-out-alt"></i> LOG OUT</a></li>
    </ul>
  </nav>

  <!-- =========================
       Main Content
       ========================= -->
  <main class="main-concept">

    <!-- Contact Header -->
    <section id="contact" class="contact-section">
      <header class="about-header">
        <h1><i class="fas fa-envelope"></i> Contact Us</h1>
      </header>

      <!-- Contact Details -->
      <section class="contact-details" aria-label="Contact Information">
        <h2><i class="fas fa-address-book"></i> CONTACT INFORMATION</h2>
        <p><i class="fas fa-map-marker-alt"></i> <strong>ADDRESS:</strong> Malungon Gamay, Malungon, Sarangani Province</p>
        <p><i class="fas fa-phone"></i> <strong>PHONE:</strong> 0907-573-7458</p>
        <p><i class="fas fa-envelope"></i> <strong>Email:</strong> Christianlasponia7@gmail.com</p>
        <p><i class="fab fa-facebook"></i> <strong>FACEBOOK:</strong> Christianlasponia</p>
        <p><i class="fas fa-clock"></i> <strong>BUSINESS HOURS:</strong> Monday to Saturday | Sunday Closed</p>
      </section>

      <!-- Contact Form -->
      <section class="contact-form" aria-label="Send Message Form">
        <h2><i class="fas fa-paper-plane"></i> Send Us a Message</h2>
        <form id="contactForm" method="post" action="send_message.php" novalidate>
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" placeholder="Enter your full name" required aria-required="true">

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Enter your email address" required aria-required="true">

          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required aria-required="true"></textarea>

          <div class="form-buttons">
            <button type="submit" class="send-btn"><i class="fas fa-paper-plane"></i> SEND</button>
            <button type="button" class="logout-btn"><i class="fas fa-sign-out-alt"></i> LOG OUT</button>
          </div>
        </form>
      </section>
    </section>

  </main>

  <!-- =========================
       Footer
       ========================= -->
  <footer>
    <p>&copy; 2025 C MOTOR PARTS. ALL RIGHTS RESERVED.</p>
  </footer>

<script>
  const contactForm = document.getElementById('contactForm');

  contactForm.addEventListener('submit', function(event) {
    // Allow PHP to handle actual saving, just client-side validation here
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();

    if (!name || !email || !message) {
      event.preventDefault();
      alert("Please fill in all fields before sending your message.");
    }
  });

  // =========================
  // Logout Modal Functionality
  // =========================
  const logoutBtn = document.querySelector('.logout-btn');
  const logoutModal = document.getElementById('logoutModal');
  const confirmLogout = document.getElementById('confirmLogout');
  const cancelLogout = document.getElementById('cancelLogout');

  logoutBtn.addEventListener('click', () => logoutModal.classList.add('show'));
  confirmLogout.addEventListener('click', () => window.location.href = "logout.php");
  cancelLogout.addEventListener('click', () => logoutModal.classList.remove('show'));

  window.addEventListener('click', e => {
    if(e.target === logoutModal) logoutModal.classList.remove('show');
  });

  // =========================
  // Scroll Animation
  // =========================
  document.addEventListener("DOMContentLoaded", function() {
    const sections = document.querySelectorAll('.contact-details, .contact-form');
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if(entry.isIntersecting){
          entry.target.classList.add('show');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });
    sections.forEach(section => observer.observe(section));
  });
</script>
</body>
</html>
