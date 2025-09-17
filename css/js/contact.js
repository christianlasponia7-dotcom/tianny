const successModal = document.getElementById('successModal');
const closeSuccess = document.getElementById('closeSuccess');

contactForm.addEventListener('submit', function(event) {
  event.preventDefault();
  
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const message = document.getElementById('message').value.trim();

  if (!name || !email || !message) {
    alert("Please fill in all fields before sending your message.");
    return;
  }

  // Show modal
  successModal.classList.add('show');

  // Reset form
  contactForm.reset();
});

closeSuccess.addEventListener('click', () => {
  successModal.classList.remove('show');
});

// Optional: Close modal by clicking outside content
window.addEventListener('click', (e) => {
  if (e.target === successModal) {
    successModal.classList.remove('show');
  }
});

// Form submission without required validation
document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    // You can still get values if needed
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    // Optional: log values (even if empty)
    console.log({ name, email, message });

    // Alert user
    alert('Thank you for your cooperation. We will update you.');

    // Reset form
    this.reset();
});
