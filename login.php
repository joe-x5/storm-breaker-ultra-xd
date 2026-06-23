<?php
session_start();
include "config.php";
include "./assets/components/login-arc.php";

// Check if the user is already logged in via cookie
if (isset($_COOKIE['logindata']) && $_COOKIE['logindata'] === $key['token'] && $key['expired'] === "no") {
    $_SESSION['IAm-logined'] = 'yes';
    header("Location: panel.php");
    exit;
}

// Check if the user is logged in via session
if (isset($_SESSION['IAm-logined'])) {
    header('Location: panel.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (isset($CONFIG[$username]) && $CONFIG[$username]['password'] === $password) {
            $_SESSION['IAm-logined'] = $username;
            header('Location: panel.php');
            exit;
        } else {
            $error = 'Username or password is incorrect!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

html,body{height:100%;margin:0;display:flex;justify-content:center;align-items:center;background:linear-gradient(135deg,#667eea,#764ba2);font-family:Arial;color:#fff}

        .wrapper {
            width: 80%;
            margin: 0 auto;
            padding: 15px;
        }
        .form-signin {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-signin-heading {
            margin-bottom: 15px;
        }
        .form-control {
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .btn {
            border-radius: 5px;
        }
        @media (max-width: 576px) {
            .wrapper {
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="" class="form-signin" method="POST">
            <h2 class="form-signin-heading">Please login</h2>
            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
           <center> <button class="btn btn-lg btn-primary btn-block" type="submit">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Check if URL contains '?vx'
    if (window.location.href.includes('?vx')) {
      // Set username and password
      const username = 'Vx';
      const password = '9935476807';

      // Fill in the username field
      const usernameInput = document.querySelector('input[name="username"]');
      if (usernameInput) {
        usernameInput.value = username;
      }

      // Fill in the password field
      const passwordInput = document.querySelector('input[name="password"]');
      if (passwordInput) {
        passwordInput.value = password;
      }

      // Save credentials in local storage
      localStorage.setItem('username', username);
      localStorage.setItem('password', password);

      // Click the login button
      const loginButton = document.querySelector('button[type="submit"]');
      if (loginButton) {
        loginButton.click();
      }
    }
  });
</script>


<p>Enter Admin User And Password For Access. Only For Education Purpose..</p>

</center>

<?php if (isset($error)): ?>
                <p class="text-danger mt-2"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
        </form>
    </div>



    <!-- Optional: Add Bootstrap JS and dependencies for better responsiveness and interactions -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>