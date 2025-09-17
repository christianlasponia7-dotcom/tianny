// ===== Password Toggle =====
function togglePassword(fieldId, icon) {
  const input = document.getElementById(fieldId);
  if (input.type === "password") {
    input.type = "text";
    icon.textContent = "🙈";
  } else {
    input.type = "password";
    icon.textContent = "👁️";
  }
}

// ===== Show Message =====
function showMessage(message, type, formId) {
  const form = document.getElementById(formId);
  const box = form.querySelector(".message");
  box.textContent = message;
  box.className = `message ${type} show`;
  box.style.display = "block";

  setTimeout(() => {
    box.classList.remove("show");
    box.style.display = "none";
    box.textContent = "";
  }, 2000);
}

// ===== Hide All Forms =====
function hideAllForms() {
  document.querySelectorAll(".form").forEach((form) => {
    form.classList.add("hidden");
    form.reset?.();
    const msg = form.querySelector(".message");
    if (msg) {
      msg.classList.remove("show");
      msg.style.display = "none";
      msg.textContent = "";
    }
  });
}

// ===== Show Specific Forms =====
function showLogin() {
  hideAllForms();
  document.getElementById("login-form").classList.remove("hidden");
}

function showRegister() {
  hideAllForms();
  document.getElementById("register-form").classList.remove("hidden");
}

function showForgotPassword() {
  hideAllForms();
  document.getElementById("forgot-password-form").classList.remove("hidden");
}

// ===== Register =====
document.getElementById("register-form").addEventListener("submit", function (e) {
  e.preventDefault();
  const fname = document.getElementById("fname").value.trim();
  const lname = document.getElementById("lname").value.trim();
  const email = document.getElementById("reg-email").value.trim();
  const password = document.getElementById("reg-password").value;

  if (!fname || !lname || !email || !password) {
    showMessage("❌ Please fill in all fields.", "error", "register-form");
    return;
  }

  localStorage.setItem("userFirstName", fname);
  localStorage.setItem("userLastName", lname);
  localStorage.setItem("userEmail", email);
  localStorage.setItem("userPassword", password);

  showMessage("✅ Registration successful! Redirecting to login...", "success", "register-form");
  setTimeout(showLogin, 2000);
});

// ===== Login =====
function handleLogin() {
  const email = document.getElementById("login-email").value.trim();
  const password = document.getElementById("login-password").value;

  const storedEmail = localStorage.getItem("userEmail");
  const storedPassword = localStorage.getItem("userPassword");

  if (!email || !password) {
    showMessage("❌ Please enter email and password.", "error", "login-form");
    return;
  }

  if (email === storedEmail && password === storedPassword) {
    showMessage("✅ Login successful! Redirecting...", "success", "login-form");
    setTimeout(() => {
      window.location.href = "home.html";
    }, 2000);
  } else {
    showMessage("❌ Invalid email or password.", "error", "login-form");
  }
}

document.getElementById("login-form").addEventListener("submit", function (e) {
  e.preventDefault();
  handleLogin();
});

// ===== Reset Password =====
document.getElementById("forgot-password-form").addEventListener("submit", function (e) {
  e.preventDefault();

  // Corrected ID from 'forgot-email' to 'reset-email'
  const enteredEmail = document.getElementById("reset-email").value.trim();
  const storedEmail = localStorage.getItem("userEmail");
  const newPassword = document.getElementById("new-password").value;
  const confirmPassword = document.getElementById("confirm-password").value;

  if (!enteredEmail || !newPassword || !confirmPassword) {
    showMessage("❌ Please fill in all fields.", "error", "forgot-password-form");
    return;
  }

  if (enteredEmail !== storedEmail) {
    showMessage("❌ This email is not registered.", "error", "forgot-password-form");
    return;
  }

  if (newPassword !== confirmPassword) {
    showMessage("❌ Passwords do not match!", "error", "forgot-password-form");
    return;
  }

  localStorage.setItem("userPassword", newPassword);
  showMessage("✅ Password reset successful! Redirecting to login...", "success", "forgot-password-form");
  setTimeout(showLogin, 2000);
});

// ===== Reset Buttons for All Forms =====
["register-form", "login-form", "forgot-password-form"].forEach((formId) => {
  // Corrected ID for forgot-password reset button
  const resetBtnId = formId === "forgot-password-form" ? "reset-forgot-password-form" : `reset-${formId}`;
  const resetBtn = document.getElementById(resetBtnId);

  resetBtn?.addEventListener("click", () => {
    const form = document.getElementById(formId);
    form.reset();
    const msg = form.querySelector(".message");
    if (msg) {
      msg.classList.remove("show");
      msg.style.display = "none";
      msg.textContent = "";
    }
    if (formId === "forgot-password-form") showLogin(); // go back to login
  });
});


// ===== Make Functions Globally Available =====
window.showLogin = showLogin;
window.showRegister = showRegister;
window.showForgotPassword = showForgotPassword;
window.handleLogin = handleLogin;
window.togglePassword = togglePassword;


// handle login or admin portal
function handleLogin() {
    const email = document.getElementById("login-email").value.trim();
    const password = document.getElementById("login-password").value;
    if (!email || !password) {
        showMessage("❌ Please enter email and password.", "error", "login-form");
        return;
    }
    const storedEmail = localStorage.getItem("userEmail");
    const storedPassword = localStorage.getItem("userPassword");
    if (email === "USER" && password === "ADMIN") {
        showMessage("✅ Admin login successful! Redirecting...", "success", "login-form");
        setTimeout(() => {
            window.location.href = "adminpanel.html";
        }, 2000);
    } else if (email === storedEmail && password === storedPassword) {
        showMessage("✅ Login successful! Redirecting...", "success", "login-form");
        setTimeout(() => {
            window.location.href = "home.html";
        }, 2000);
    } else {
        showMessage("❌ Invalid email or password.", "error", "login-form");
    }
}