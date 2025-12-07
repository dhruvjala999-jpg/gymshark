<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - GYM SHARK</title>
    <link rel="stylesheet" href="./css/login_css.css">
    <script>
        function form() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            // Clear previous errors
            emailError.innerText = "";
            passwordError.innerText = "";

            let isValid = true;

            // Email validation
            if (email === "") {
                emailError.innerText = "Email is required.";
                isValid = false;
            } else if (!validateEmail(email)) {
                emailError.innerText = "Enter a valid email address.";
                isValid = false;
            }

            // Password validation
            if (password === "") {
                passwordError.innerText = "Password is required.";
                isValid = false;
            }

            return isValid;
        }

        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
    </script>
</head>
<body>

    <header>
        <div class="logo">GYM SHARK</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
    </header>

    <div class="login-container">
        <form name="loginForm" class="login-form" method="POST" onsubmit="return form()">
            <h2>Login to GYM SHARK</h2>

            <input type="text" id="email" name="email" placeholder="Email">
            <span id="emailError" class="error"></span>

            <input type="password" id="password" name="password" placeholder="Password">
            <span id="passwordError" class="error"></span>

            <label class="remember-me">
                <input type="checkbox" name="remember"> Remember Me
            </label>

            <button type="submit" name="btnsubmit">Login</button>

            <div class="login-links">
                <a href="forgot-password.php">Forgot Password?</a> |
                <a href="register.php">Register</a>
            </div>
        </form>
    </div>

    <!-- Footer -->
<footer>
    <p>&copy; 2025 FitPro. All rights reserved.</p>
</footer>

</body>
</html>

<?php

include("connection.php");

// Check if the form is submitted
if (isset($_POST['btnsubmit'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    // Check if email exists
    $sql = "SELECT * FROM registration WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];

            echo '<script>window.location.href = "supplements.php";</script>';
            exit();
        } else {
            echo '<script>alert("Invalid password. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Email not found. Please register first.");</script>';
    }
}
?>
