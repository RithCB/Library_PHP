<?php
include("Database.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        
        
        if ($_POST['password'] === $_POST['confirm_password']) {
            $password = $_POST['password'];
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            
            $sql = "INSERT INTO Client (username, email, password) VALUES ('$username', '$email', '$hash')"; 
            
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Sign Up Successful!'); window.location.href='Login.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match!');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Database Error: " . $e->getMessage();
    }
}
?>
<script>
    //redirect file
    $(document).ready(function () {
        $("#loginForm").submit(function (event) {
            event.preventDefault(); 

            $.ajax({
                type: "POST",
                url: "login.php", 
                data: $(this).serialize(), 
                success: function (response) {
                    if (response === "success") {
                        window.location.href = "index_for_member.php"; 
                    } else {
                        alert(response); // Show error message
                    }
                }
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
        
        <div class="logo-section">
        <img src="https://uc.edu.kh/images/uc.png" alt="Logo" style="width: 100px;">
            <h2>Handa Library</h2>
        </div>

        <h3>Create an Account</h3>
        <form id="signupForm" action="SignUP.php" method="post">
            <div class="input-group">
                <input type="text" id="name" name="username" placeholder="Full Name" required>
                <div class="error" id="nameError"></div>
            </div>
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <div class="error" id="emailError"></div>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <div class="error" id="passwordError"></div>
            </div>
            <div class="input-group">
                <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm Password" required>
                <div class="error" id="confirmPasswordError"></div>
            </div>
            <button type="submit" class="btn" name="submit">Sign Up</button>
        </form>
        <p class="login-link">Already have an account? <a href="Login.php">Login</a></p>
    </div>

    

</body>
</html>
<script>
        document.getElementById("signupForm").addEventListener("submit", function(event) {
            // event.preventDefault();
            let isValid = true;

            // Get input values
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;

            // Name validation
            if (name === "") {
                document.getElementById("nameError").innerText = "Full name is required";
                isValid = false;
            } else {
                document.getElementById("nameError").innerText = "";
            }

            // Email validation
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!email.match(emailPattern)) {
                document.getElementById("emailError").innerText = "Enter a valid email";
                isValid = false;
            } else {
                document.getElementById("emailError").innerText = "";
            }

            // Password validation
            if (password.length < 6) {
                document.getElementById("passwordError").innerText = "Password must be at least 6 characters";
                isValid = false;
            } else {
                document.getElementById("passwordError").innerText = "";
            }

            // Confirm password validation
            if (confirmPassword !== password) {
                document.getElementById("confirmPasswordError").innerText = "Passwords do not match";
                isValid = false;
            } else {
                document.getElementById("confirmPasswordError").innerText = "";
            }

           
        });
    </script>

<?php
// include("Database.php"); 

// if (isset($_POST['submit'])) {
//     try {
//         // Securely fetch form data
//         $username = mysqli_real_escape_string($conn, $_POST['username']);
//         $email = mysqli_real_escape_string($conn, $_POST['email']); 
        
//         // Check password confirmation
//         if ($_POST['password'] == $_POST['confirm_password']) {
//             $password = $_POST['password'];
//             $hash = password_hash($password, PASSWORD_DEFAULT);
            
//             // Correct SQL syntax
//             $sql = "INSERT INTO Client (username, email, password) VALUES ('$username', '$email', '$hash')"; 
            
//             // Execute Query
//             if (mysqli_query($conn, $sql)) {
//                 echo "Query OK! User registered successfully.";
//             } else {
//                 echo "Query not okay: " . mysqli_error($conn);
//             }
//         } else {
//             echo "Passwords do not match!";
//         }
//     } catch (mysqli_sql_exception $e) {
//         echo "Query not okay: " . $e->getMessage();
//     }
// }
?>






  <?php
    
    mysqli_close($conn); 
  ?>