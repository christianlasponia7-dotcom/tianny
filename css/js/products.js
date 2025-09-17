// =========================
// PRODUCT FILTERING
// =========================
function filterProducts(category) {
  const buttons = document.querySelectorAll(".filter-buttons button");
  const categories = document.querySelectorAll(".category-box");

  // Reset active button
  buttons.forEach(btn => btn.classList.remove("active"));

  // Activate clicked button
  const clickedBtn = Array.from(buttons).find(btn => {
    const text = btn.textContent.replace(/\s/g, "").toUpperCase();
    return text === category || (category === "ALL" && btn.textContent.toUpperCase() === "ALL");
  });
  if (clickedBtn) clickedBtn.classList.add("active");

  // Show / hide categories with fade effect
  categories.forEach(cat => {
    if (category === "ALL" || cat.dataset.category === category) {
      cat.style.display = "block";
      cat.style.opacity = "0";
      setTimeout(() => {
        cat.style.opacity = "1";
        cat.style.transition = "opacity 0.5s ease";
      }, 50);
    } else {
      cat.style.opacity = "0";
      setTimeout(() => (cat.style.display = "none"), 300);
    }
  });
}

// =========================
// CART & CHECKOUT SYSTEM
// =========================
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Update cart badge count
function updateCartCount() {
  const totalQty = cart.reduce((sum, item) => sum + item.quantity, 0);
  document.getElementById("cartCount").textContent = totalQty;
}

// Add product to cart
function addToCart(product, price) {
  const existing = cart.find(item => item.product === product);
  if (existing) {
    existing.quantity++;
  } else {
    cart.push({ product, price, quantity: 1 });
  }
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartCount();
  showNotice(`✅ ${product} added to cart!`);
}

// =========================
// RENDER CART ITEMS IN MODAL
// =========================
function renderCart() {
  const cartContainer = document.getElementById("cartItems");
  const totalContainer = document.getElementById("cartTotal");

  if (cart.length === 0) {
    cartContainer.innerHTML = "<p style='text-align:center;'>🛒 Your cart is empty.</p>";
    totalContainer.innerHTML = "";
    return;
  }

  let total = 0;
  const rows = cart.map((item, i) => {
    const subtotal = item.price * item.quantity;
    total += subtotal;
    return `
      <tr>
        <td style="padding:8px;">${i + 1}</td>
        <td style="padding:8px;">${item.product}</td>
        <td style="padding:8px; text-align:center;">
          <button onclick="decreaseQty(${i})" class="qty-btn"><i class="fas fa-minus"></i></button>
          ${item.quantity}
          <button onclick="increaseQty(${i})" class="qty-btn"><i class="fas fa-plus"></i></button>
        </td>
        <td style="padding:8px; text-align:right;">₱${item.price}</td>
        <td style="padding:8px; text-align:right;">₱${subtotal}</td>
        <td style="padding:8px; text-align:center;">
          <button onclick="removeFromCart(${i})" class="delete-btn"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    `;
  }).join("");

  cartContainer.innerHTML = `
    <table style="width:100%; border-collapse:collapse;">
      <thead>
        <tr style="background:#f4f4f4;">
          <th>#</th>
          <th>Product</th>
          <th style="text-align:center;">Qty</th>
          <th style="text-align:right;">Price (₱)</th>
          <th style="text-align:right;">Subtotal (₱)</th>
          <th style="text-align:center;">Action</th>
        </tr>
      </thead>
      <tbody>${rows}</tbody>
    </table>
  `;
  totalContainer.innerHTML = `<h3 style="text-align:right;">Total: ₱${total}</h3>`;
}

// =========================
// CART ACTIONS
// =========================
function increaseQty(index) {
  cart[index].quantity++;
  saveCartAndUpdate();
}

function decreaseQty(index) {
  if (cart[index].quantity > 1) {
    cart[index].quantity--;
  } else {
    cart.splice(index, 1);
  }
  saveCartAndUpdate();
}

function removeFromCart(index) {
  showConfirm("🗑 Remove this item?", () => {
    cart.splice(index, 1);
    saveCartAndUpdate();
  });
}

function saveCartAndUpdate() {
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartCount();
  renderCart();
}

// =========================
// CART MODAL HANDLING
// =========================
function openCart() {
  renderCart();
  document.getElementById("cartModal").classList.add("show");
}

function closeCart() {
  document.getElementById("cartModal").classList.remove("show");
}

// =========================
// CHECKOUT PROCESS
// =========================
function checkoutCart() {
  if (cart.length === 0) {
    showNotice("⚠️ Your cart is empty.");
    return;
  }

  let total = 0;
  let details = "<h3>Items:</h3><ul>";
  cart.forEach(item => {
    const subtotal = item.price * item.quantity;
    total += subtotal;
    details += `<li>${item.product} (x${item.quantity}) - ₱${subtotal}</li>`;
  });
  details += `</ul><p><strong>Total: ₱${total}</strong></p>`;

  const orderDetails = document.getElementById("orderDetails");
  orderDetails.innerHTML = details;

  // Store current order in modal dataset for later use
  const orderModal = document.getElementById("orderModal");
  orderModal.dataset.currentOrder = JSON.stringify({ items: cart, total });

  // Clear form fields
  document.getElementById("customerName").value = "";
  document.getElementById("customerAddress").value = "";
  document.getElementById("paymentMethod").value = "";

  closeCart();
  orderModal.classList.add("show");
}

// =========================
// BUY NOW (Single Item)
// =========================
function buyNow(product, price) {
  cart = [{ product, price, quantity: 1 }];
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartCount();
  checkoutCart();
}

// =========================
// ORDER MODALS
// =========================
function closeModal() {
  document.getElementById("orderModal").classList.remove("show");
}

function placeOrder() {
  const name = document.getElementById("customerName").value.trim();
  const address = document.getElementById("customerAddress").value.trim();
  const paymentMethod = document.getElementById("paymentMethod").value;

  if (!name || !address || !paymentMethod) {
    showNotice("⚠️ Please fill in all fields.");
    return;
  }

  const orderModal = document.getElementById("orderModal");
  const currentOrder = JSON.parse(orderModal.dataset.currentOrder || "{}");

  if (!currentOrder.items || currentOrder.items.length === 0) {
    showNotice("⚠️ No items in order.");
    return;
  }

  const order = {
    id: generateOrderId(),
    customerName: name,
    customerAddress: address,
    paymentMethod,
    items: currentOrder.items,
    total: currentOrder.total,
    status: 'Pending', // default status
    date: new Date().toLocaleString(),
  };

  // Save order to localStorage orders array
  const orders = JSON.parse(localStorage.getItem("myOrders")) || [];
  orders.push(order);
  localStorage.setItem("myOrders", JSON.stringify(orders));

  // Clear cart
  cart = [];
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();

  closeModal();
  openSuccessModal();
}

function openSuccessModal() {
  document.getElementById("successModal").classList.add("show");
}

function backToProducts() {
  document.getElementById("successModal").classList.remove("show");
  // Optionally reload page or reset UI
}

// =========================
// NOTICE MODAL
// =========================
function showNotice(message) {
  const noticeModal = document.getElementById("noticeModal");
  document.getElementById("noticeMessage").textContent = message;
  noticeModal.classList.add("show");
}

function closeNotice() {
  document.getElementById("noticeModal").classList.remove("show");
}

// =========================
// CONFIRM MODAL
// =========================
function showConfirm(message, onConfirm) {
  const confirmModal = document.getElementById("confirmModal");
  document.getElementById("confirmMessage").textContent = message;
  confirmModal.classList.add("show");

  const yesBtn = document.getElementById("confirmYes");
  const noBtn = document.getElementById("confirmNo");

  yesBtn.onclick = () => {
    onConfirm();
    closeConfirm();
  };
  noBtn.onclick = closeConfirm;
}

function closeConfirm() {
  document.getElementById("confirmModal").classList.remove("show");
}

// =========================
// ORDERS MANAGEMENT
// =========================
function openOrders() {
  loadMyOrders();
  document.getElementById('ordersModal').classList.add("show");
}

function closeOrders() {
  document.getElementById('ordersModal').classList.remove("show");
}

function loadMyOrders() {
  const ordersList = document.getElementById('ordersList');
  const orders = JSON.parse(localStorage.getItem('myOrders')) || [];
  ordersList.innerHTML = '';

  if (orders.length === 0) {
    ordersList.innerHTML = '<p>No orders placed yet.</p>';
    return;
  }

  orders.forEach(order => {
    let orderHtml = `
      <div class="order-card" style="border:1px solid #ccc; padding:10px; margin-bottom:10px; border-radius:5px;">
        <p><strong>Order ID:</strong> ${order.id}</p>
        <p><strong>Status:</strong> <span style="color:${getStatusColor(order.status)}">${order.status}</span></p>
        <p><strong>Date:</strong> ${new Date(order.date).toLocaleDateString()}</p>
        <p><strong>Customer:</strong> ${order.customerName}</p>
        <p><strong>Address:</strong> ${order.customerAddress}</p>
        <p><strong>Payment:</strong> ${order.paymentMethod}</p>
        <p><strong>Items:</strong></p>
        <ul>
    `;

    order.items.forEach(item => {
      orderHtml += `<li>${item.product} x ${item.quantity} - ₱${item.price * item.quantity}</li>`;
    });

    orderHtml += `</ul>`;

    if (order.status !== 'Cancelled' && order.status !== 'Declined') {
      orderHtml += `<button onclick="cancelOrder('${order.id}')">Cancel Order</button>`;
    }

    orderHtml += `</div>`;

    ordersList.innerHTML += orderHtml;
  });
}

function getStatusColor(status) {
  switch(status) {
    case 'Accepted': return 'green';
    case 'Declined': return 'red';
    case 'Pending': return 'orange';
    case 'Cancelled': return 'gray';
    default: return 'black';
  }
}

function cancelOrder(orderId) {
  const orders = JSON.parse(localStorage.getItem('myOrders')) || [];
  const orderIndex = orders.findIndex(o => o.id === orderId);
  if (orderIndex === -1) return;

  if (orders[orderIndex].status === 'Cancelled') {
    showNotice('Order already cancelled.');
    return;
  }

  showConfirm('Are you sure you want to cancel this order?', () => {
    orders[orderIndex].status = 'Cancelled';
    localStorage.setItem('myOrders', JSON.stringify(orders));
    loadMyOrders();
    showNotice('Order cancelled successfully.');
  });
}

// =========================
// UTILITY FUNCTIONS
// =========================
function generateOrderId() {
  return 'ORD' + Math.floor(Math.random() * 1000000);
}

// =========================
// UNIVERSAL MODAL CLOSE HANDLING
// =========================
document.addEventListener("DOMContentLoaded", () => {
  // Close button inside modals
  document.querySelectorAll(".close").forEach(btn => {
    btn.addEventListener("click", () => {
      btn.closest(".modal").classList.remove("show");
    });
  });

  // Click outside modal content closes modal
  document.querySelectorAll(".modal").forEach(modal => {
    modal.addEventListener("click", e => {
      if (e.target === modal) {
        modal.classList.remove("show");
      }
    });
  });

  updateCartCount();
});

