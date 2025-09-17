<?php
// Start session (optional for future login/cart integration)
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SERVICES | C MOTOR PARTS AND ACCESSORIES</title>
  <link rel="stylesheet" href="css/services.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- ================= NAVBAR ================= -->
  <nav aria-label="Main Navigation">
    <ul class="navbar">
      <li><a href="home.php"><i class="fas fa-home"></i> HOME</a></li>
      <li><a href="about.php"><i class="fas fa-info-circle"></i> ABOUT US</a></li> 
      <li><a href="products.php"><i class="fas fa-box"></i> PRODUCTS</a></li>
      <li><a href="services.php" class="active"><i class="fas fa-cogs"></i> SERVICES</a></li>
      <li><a href="contact.php"><i class="fas fa-envelope"></i> CONTACT</a></li>
    </ul>
  </nav>

  <!-- ================= MAIN CONTENT ================= -->
  <main class="main-concept">
    <section id="services" class="about-section">
      <div class="about-header">
        <h2><i class="fas fa-cogs"></i> OUR SERVICES</h2>
      </div>

      <!-- Services Grid -->
      <div class="services-list">
        <article class="service-item">
          <h3><i class="fas fa-wrench"></i> COMPREHENSIVE MOTORCYCLE REPAIR</h3>
          <p>We offer full-service motorcycle repair handled by highly trained mechanics, ensuring your bike gets back on the road in the best condition possible. From engine overhauls to brake system adjustments and suspension tuning, we cover everything your motorcycle may need to perform safely and efficiently.</p>
        </article>

        <article class="service-item">
          <h3><i class="fas fa-oil-can"></i> PREMIUM OIL CHANGE SERVICE</h3>
          <p>Our oil change service uses only top-quality lubricants to maximize engine performance and extend your motorcycle’s lifespan. We also inspect and replace filters as necessary and perform additional maintenance checks, ensuring your engine runs smoothly and reliably.</p>
        </article>

        <article class="service-item">
          <h3><i class="fas fa-tools"></i> PROFESSIONAL PARTS INSTALLATION</h3>
          <p>Whether you purchased your parts from us or brought your own, our expert team ensures proper installation with precision and care. We guarantee safety and compatibility with your motorcycle’s systems, from brakes and engines to exhausts and suspension parts, providing long-lasting performance.</p>
        </article>

        <article class="service-item">
          <h3><i class="fas fa-motorcycle"></i> MOTORCYCLE CUSTOMIZATION & UPGRADES</h3>
          <p>Transform your ride with personalized designs, performance enhancements, and stylish modifications. We handle bodywork, paint, decals, performance tuning, and accessory upgrades, ensuring your motorcycle is uniquely tailored to your style and performance preferences.</p>
        </article>

        <article class="service-item">
          <h3><i class="fas fa-bolt"></i> ELECTRICAL SYSTEM DIAGNOSIS & REPAIR</h3>
          <p>We troubleshoot and repair motorcycle electrical issues, including faulty wiring, battery replacements, lighting, and ignition systems. Our detailed diagnostics ensure all electrical components work perfectly, providing safety and reliability while riding.</p>
        </article>

        <article class="service-item">
          <h3><i class="fas fa-shield-alt"></i> SAFETY INSPECTION & MAINTENANCE</h3>
          <p>Our thorough safety inspection covers brakes, tires, suspension, lights, and other vital components. Regular maintenance and detailed safety checks keep you riding confidently and reduce the risk of accidents due to mechanical failure.</p>
        </article>

        <article class="service-item">
          <h3><i class="fas fa-shipping-fast"></i> FAST DELIVERY OF MOTORCYCLE PARTS</h3>
          <p>Need parts urgently? We offer quick and reliable delivery services, ensuring you receive essential components on time. Whether you are a casual rider or a professional workshop owner, our logistics guarantee fast access to quality parts.</p>
        </article>

        <article class="service-item">
          <h3><i class="fas fa-soap"></i> MOTORCYCLE WASHING & DETAILING</h3>
          <p>Keep your motorcycle looking spotless and showroom-ready with our thorough washing and detailing services. We remove dirt, grease, and grime from every component, restore shine, and enhance the overall appearance of your bike while protecting its paint and metal surfaces.</p>
        </article>

        <article class="service-item">
          <h3><i class="fas fa-cogs"></i> ADVANCED MOTORCYCLE TUNING & PERFORMANCE</h3>
          <p>Optimize your bike’s performance with our advanced tuning services. From engine calibration to suspension adjustments, we enhance speed, efficiency, and handling, making sure your motorcycle delivers the best riding experience possible.</p>
        </article>
      </div>
    </section>
  </main>

  <!-- ================= FOOTER ================= -->
  <footer>
    <p>&copy; 2025 C MOTOR PARTS. ALL RIGHTS RESERVED.</p>
  </footer>
</body>
</html>
