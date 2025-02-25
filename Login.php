
<?php 

include("Database.php"); // Ensure $conn is properly included
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Query to get user by email
        $sql = "SELECT * FROM Client WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verify the password
            if (password_verify($password, $row['password'])) {
                echo "success"; 
                exit;
            } else {
                echo "❌ Incorrect password!";
            }
        } else {
            echo "❌ Email not found!";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "❌ Please fill in both email and password!";
    }

    

}

mysqli_close($conn);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#LoginForm').submit(function (event) {
            event.preventDefault(); 

            $.ajax({
                type: 'POST',
                url: 'Login.php', 
                data: $(this).serialize(), 
                success: function (response) {
                    if (response.trim() === "success") {
                        window.location.href = 'index_for_member.php'; 
                    } else {
                        alert(response); 
                }}
            });
        });
    });
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        /* Google Font */
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

        /* Logo Section */
        .logo-section {
            margin-bottom: 30px;
        }

        .logo-section img {
            width: 80px; /* Adjust logo size */
            height: auto;
        }

        .logo-section h2 {
            color: #f59e0b; /* Yellow for logo text */
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
            margin-top: 5px;
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

        /* Responsive */
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
        <form id="LoginForm" action="Login.php" method="post">
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <div class="error" id="emailError"></div>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <div class="error" id="passwordError"></div>
            </div>
            <button type="submit" name="submit"class="btn" 
            >Log in</button>
            
        </form>
        <p class="login-link">Haven't sign in yet?<a href="SignUP.php">Sign UP</a></p>
    </div>

    <script>
        // document.getElementById("signupForm").addEventListener("submit", function(event) {
        //     event.preventDefault();
        //     let isValid = true;

            // Get input values
            // const name = document.getElementById("name").value.trim();
            // const email = document.getElementById("email").value.trim();
            // const password = document.getElementById("password").value;
            // const confirmPassword = document.getElementById("confirmPassword").value;

            // Name validation
        //     if (name === "") {
        //         document.getElementById("nameError").innerText = "Full name is required";
        //         isValid = false;
        //     } else {
        //         document.getElementById("nameError").innerText = "";
        //     }

        //     // Email validation
        //     const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        //     if (!email.match(emailPattern)) {
        //         document.getElementById("emailError").innerText = "Enter a valid email";
        //         isValid = false;
        //     } else {
        //         document.getElementById("emailError").innerText = "";
        //     }

        //     // Password validation
        //     if (password.length < 6) {
        //         document.getElementById("passwordError").innerText = "Password must be at least 6 characters";
        //         isValid = false;
        //     } else {
        //         document.getElementById("passwordError").innerText = "";
        //     }

        //     // Confirm password validation
        //     if (confirmPassword !== password) {
        //         document.getElementById("confirmPasswordError").innerText = "Passwords do not match";
        //         isValid = false;
        //     } else {
        //         document.getElementById("confirmPasswordError").innerText = "";
        //     }

        //     // If everything is valid, submit form
        //     // if (isValid) {
        //     //     alert("Sign Up Successful!");
        //     //     document.getElementById("signupForm").reset();
        //     // }
        // });
    </script>

</body>
</html>






  <?php
    include("Database.php"); 
    
    mysqli_close($conn); 
  ?>