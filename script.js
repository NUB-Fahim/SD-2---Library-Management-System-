document.addEventListener("DOMContentLoaded", () => {
  const page = document.body.dataset.page;

  if (page === "index") {
    const loginBox = document.getElementById("login-box");
    const signupBox = document.getElementById("signup-box");
    const roleSelect = document.getElementById("roleSelect");
    const adminPinInput = document.getElementById("adminPin");

    // Toggle between login and signup forms
    window.toggleForms = function () {
      if (loginBox.style.display === "none") {
        loginBox.style.display = "block";
        signupBox.style.display = "none";
      } else {
        loginBox.style.display = "none";
        signupBox.style.display = "block";
      }
    };

    // Show/hide admin pin input based on role selection
    roleSelect.addEventListener("change", () => {
      if (roleSelect.value === "admin") {
        adminPinInput.style.display = "block";
        adminPinInput.required = true;
      } else {
        adminPinInput.style.display = "none";
        adminPinInput.required = false;
        adminPinInput.value = "";
      }
    });

    // Login form submission
    const loginForm = document.getElementById("loginForm");
    loginForm.addEventListener("submit", e => {
      e.preventDefault();

      const formData = new FormData(loginForm);

      fetch("login.php", {
        method: "POST",
        body: formData,
      })
        .then(res => res.text())
        .then(data => {
          if (data.trim() === "admin") {
            window.location.href = "admin_dashboard.php";
          } else if (data.trim() === "user") {
            window.location.href = "user_dashboard.php";
          } else {
            alert(data); // Error message
          }
        })
        .catch(err => {
          alert("Login failed. Please try again.");
          console.error(err);
        });
    });

    // Signup form submission
    const signupForm = document.getElementById("signupForm");
    signupForm.addEventListener("submit", e => {
      e.preventDefault();

      if (roleSelect.value === "admin" && adminPinInput.value.trim() !== "1234") {
        alert("Invalid Admin Security PIN");
        adminPinInput.focus();
        return;
      }

      const formData = new FormData(signupForm);

      fetch("signup.php", {
        method: "POST",
        body: formData,
      })
        .then(res => res.text())
        .then(data => {
          if (data.trim() === "success") {
            alert("Account created successfully!");
            toggleForms(); // Switch to login
            signupForm.reset();
          } else {
            alert(data); // Error message from PHP
          }
        })
        .catch(err => {
          alert("Signup failed. Please try again.");
          console.error(err);
        });
    });
  }
});