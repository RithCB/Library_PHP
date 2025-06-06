

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
        <form id="LoginForm"  action="Login.php" method="post">
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
$(document).ready(function () {
    $('#LoginForm').submit(function (event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'Login.php', // 🔁 changed
            data: $(this).serialize(),
            success: function (response) {
                const trimmedResponse = response.trim();

                if (trimmedResponse === "success") {
                    window.location.href = 'index_for_member.php';
                } else if (trimmedResponse === "admin") {
                    window.location.href = 'admin_page.php';
                } else {
                    alert(trimmedResponse);
                }
            },
            error: function () {
                alert("❌ Login request failed!");
            }
        });
    });
});
</script>


   

</body>
</html>
