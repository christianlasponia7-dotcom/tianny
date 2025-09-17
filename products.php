<?php
// Start session for future user handling (optional)
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PRODUCTS</title>
  <link rel="stylesheet" href="css/products.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- ================= HEADER / NAVIGATION ================= -->
  <header>
    <nav>
      <ul class="navbar">
        <li><a href="home.php"><i class="fas fa-home"></i> HOME</a></li>
        <li><a href="about.php"><i class="fas fa-info-circle"></i> ABOUT US</a></li>
        <li><a href="products.php" class="active"><i class="fas fa-box"></i> PRODUCTS</a></li>
        <li><a href="services.php"><i class="fas fa-cogs"></i> SERVICES</a></li>
        <li><a href="contact.php"><i class="fas fa-envelope"></i> CONTACT</a></li>
      </ul>
    </nav>
    <button class="cart-btn" onclick="openCart()">
      <i class="fas fa-shopping-cart"></i>
      <span id="cartCount">0</span>
    </button>
  </header>

  <!-- ================= MAIN CONTENT ================= -->
  <main>
    <section class="product-area">

      <!-- FILTER BUTTONS -->
      <div class="filter-buttons">
        <button onclick="filterProducts('ALL')" class="active">ALL</button>
        <button onclick="filterProducts('ENGINE')">ENGINE PARTS</button>
        <button onclick="filterProducts('FUEL')">FUEL PARTS</button>
        <button onclick="filterProducts('IGNITION')">IGNITION PARTS</button>
        <button onclick="filterProducts('COOLING')">COOLING PARTS</button>
        <button onclick="filterProducts('LUBRICATION')">LUBRICATION PARTS</button>
      </div>

      <!-- Example Category -->
      <div class="category-box" data-category="ENGINE">
        <h2>ENGINE PARTS</h2>
        <div class="product-grid">
          <div class="product-card">
            <img src="images/piston.jpg" alt="Piston">
            <h3>PISTON</h3>
            <p>High-quality piston for smooth engine operation.</p>
            <p><strong>₱1,000</strong></p>
            <button onclick="buyNow('Piston', 1000)">Buy Now</button>
            <button onclick="addToCart('Piston', 1000)">Add to Cart</button>
          </div>
          <!-- Add more products... -->
        </div>
      </div>

      <!-- Repeat other categories here (Fuel, Ignition, Cooling, Lubrication) -->

    </section>
  </main>

  <!-- ================= FOOTER ================= -->
  <footer>
    <p>&copy; 2025 C MOTOR PARTS. ALL RIGHTS RESERVED.</p>
  </footer>

  <!-- ================= CART MODAL ================= -->
  <div id="cartModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeCart()">&times;</span>
      <h2>🛒 Your Cart</h2>
      <div id="cartItems"></div>
      <p id="cartTotal"><strong>Total: ₱0</strong></p>
      <button onclick="checkoutCart()">Checkout</button>
    </div>
  </div>

  <!-- ================= ORDER SUMMARY MODAL ================= -->
  <div id="orderModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Order Summary</h2>
      <div id="orderDetails"></div>
      <form id="orderForm">
        <label>Full Name:</label>
        <input type="text" id="customerName" required />
        <label>Address:</label>
        <textarea id="customerAddress" required></textarea>
        <label>Payment Method:</label>
        <select id="paymentMethod" required>
          <option value="">-- Select Payment Method --</option>
          <option value="COD">Cash on Delivery</option>
          <option value="GCash">GCash</option>
          <option value="Debit Card">Debit Card</option>
        </select>
        <button type="button" onclick="placeOrder()">Confirm Order</button>
      </form>
    </div>
  </div>

  <!-- ================= SUCCESS MESSAGE MODAL ================= -->
  <div id="successModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="backToProducts()">&times;</span>
      <h2>✅ Order Successful</h2>
      <p>Thank you for trusting us!</p>
      <button onclick="backToProducts()">Back to Products</button>
    </div>
  </div>

  <!-- ================= NOTICE MODAL ================= -->
  <div id="noticeModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeNotice()">&times;</span>
      <h2>Notice</h2>
      <p id="noticeMessage" style="margin-top:10px;"></p>
      <button type="button" onclick="closeNotice()" style="margin-top:16px;">OK</button>
    </div>
  </div>

  <!-- ================= CONFIRM MODAL ================= -->
  <div id="confirmModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeConfirm()">&times;</span>
      <h2>Confirm</h2>
      <p id="confirmMessage" style="margin-top:10px;"></p>
      <div style="margin-top:16px; display:flex; gap:10px; justify-content:center;">
        <button id="confirmYes" type="button">Yes</button>
        <button id="confirmNo" type="button">No</button>
      </div>
    </div>
  </div>

  <!-- ================= ORDERS HISTORY MODAL ================= -->
  <div id="ordersModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeOrders()">&times;</span>
      <h2>📦 Your Orders</h2>
      <div id="ordersList"></div>
    </div>
  </div>

  <!-- ================= SCRIPT ================= -->
  <script src="js/products.js"></script>
  <script>
    // Quick Buy Now function
    function buyNow(name, price) {
      cart = [{ name, price, quantity: 1 }];
      checkoutCart();
    }
  </script>
</body>
</html>
