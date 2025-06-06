<?php
// Start session and include database
session_start();
include("Database.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Admin check
        if ($email === 'admin@gmail.com' && $password === 'admin') {
            header("Location: admin_page.php");
            exit();
        }

        // Normal user check
        $sql = "SELECT * FROM Client WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];
                header("Location: index_for_member.php");
                exit();
            } else {
                header("Location: Login.php?error=Incorrect+password");
                exit();
            }
        } else {
            header("Location: Login.php?error=Email+not+found");
            exit();
        }
    } else {
        header("Location: Login.php?error=Please+fill+in+both+fields");
        exit();
    }
}

// Close connection at end
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #f4f4f9;
    }
    .container {
        background: rgba(255, 255, 255, 0.9);
        padding: 40px;
        width: 380px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .logo-section {
        margin-bottom: 30px;
    }
    .logo-section img {
        width: 80px;
        height: auto;
    }
    .logo-section h2 {
        color: #f59e0b;
        font-size: 22px;
        font-weight: 600;
        margin-top: 10px;
    }
    .input-group {
        position: relative;
        margin-bottom: 18px;
    }
    .input-group input {
        width: 100%;
        padding: 12px;
        border: 2px solid #f59e0b;
        outline: none;
        border-radius: 8px;
        font-size: 16px;
        background: rgba(255, 255, 255, 0.8);
        color: #333;
        transition: 0.3s ease;
    }
    .input-group input:focus {
        border-color: #fbbf24;
    }
    .input-group input::placeholder {
        color: #f59e0b;
    }
    .btn {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        background: #f59e0b;
        color: white;
        cursor: pointer;
        transition: 0.3s ease;
        font-weight: 500;
    }
    .btn:hover {
        background: #fbbf24;
    }
    .error {
        color: #e74c3c;
        font-size: 14px;
        margin: 10px 0;
    }
    .login-link {
        margin-top: 10px;
        color: #333;
        font-size: 14px;
    }
    .login-link a {
        color: #f59e0b;
        text-decoration: none;
        font-weight: 500;
    }
    .login-link a:hover {
        text-decoration: underline;
    }
    @media (max-width: 400px) {
        .container {
            width: 90%;
        }
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Logo Section -->
  <div class="logo-section">
    <img src="https://uc.edu.kh/images/uc.png" alt="Logo" style="width: 100px;">
    <h2>Handa Library</h2>
  </div>

  <h3>Log in Account</h3>

  <?php if (isset($_GET['error'])): ?>
    <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
  <?php endif; ?>

  <form action="Login.php" method="post">
    <div class="input-group">
      <input type="email" name="email" placeholder="Email" required>
    </div>
    <div class="input-group">
      <input type="password" name="password" placeholder="Password" required>
    </div>
    <button type="submit" class="btn">Log in</button>
  </form>

  <p class="login-link">Haven't signed in yet? <a href="SignUP.php">Sign UP</a></p>
</div>

</body>
</html>
