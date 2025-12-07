<?php
    include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - GYM SHARK</title>
    <link rel="stylesheet" href="./css/register.css">
    <script>
        function form() {
            let isValid = true;

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const gender = document.getElementById('gender').value;
            const country = document.getElementById('country').value.trim();

            // Clear previous error messages
            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            // Full name validation
            const namePattern = /^[a-zA-Z ]+$/;
            if (fullName === '') {
                document.getElementById('fullNameError').textContent = "Please enter your full name";
                isValid = false;
            } else if (!namePattern.test(fullName)) {
                document.getElementById('fullNameError').textContent = "Only alphabets allowed";
                isValid = false;
            }

            // Email validation
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
            if (email === '') {
                document.getElementById('emailError').textContent = "Please enter your email";
                isValid = false;
            } else if (!emailPattern.test(email)) {
                document.getElementById('emailError').textContent = "Invalid email format";
                isValid = false;
            }

            // Password validation
            if (password === '') {
                document.getElementById('passwordError').textContent = "Please enter password";
                isValid = false;
            } else if (password.length < 6) {
                document.getElementById('passwordError').textContent = "Password must be at least 6 characters";
                isValid = false;
            }

            // Confirm password validation
            if (confirmPassword === '') {
                document.getElementById('confirmPasswordError').textContent = "Please confirm your password";
                isValid = false;
            } else if (password !== confirmPassword) {
                document.getElementById('confirmPasswordError').textContent = "Passwords do not match";
                isValid = false;
            }

            // Gender validation
            if (gender === '') {
                document.getElementById('genderError').textContent = "Please select your gender";
                isValid = false;
            }

            // Country validation
            if (country === '') {
                document.getElementById('countryError').textContent = "Please enter your country";
                isValid = false;
            }

            return isValid;
        }
    </script>
</head>
<body>

<!-- Header -->
<header>
    <div class="logo">GYM SHARK</div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
        </ul>
    </nav>
</header>

<!-- Main Registration Form -->
<section class="form-section">
    <form class="form-container" action="" method="POST" onsubmit="return form()">
        <h2>Create Your Account</h2>

        <input type="text" id="fullName" name="FullName" placeholder="Full Name">
        <span id="fullNameError" class="error"></span>

        <input type="email" id="email" name="email" placeholder="Email">
        <span id="emailError" class="error"></span>

        <input type="password" id="password" name="password" placeholder="Password">
        <span id="passwordError" class="error"></span>

        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
        <span id="confirmPasswordError" class="error"></span>

        <select id="gender" name="gender">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <span id="genderError" class="error"></span>

        <input type="text" id="country" name="country" placeholder="Country" value="India" readonly>
        <span id="countryError" class="error"></span>

        <button type="submit" name="btnsubmit">Register</button>

        <p class="switch-page">Already have an account? <a href="login.php">Login here</a></p>
    </form>

    <?php 
    if (isset($_POST['btnsubmit'])) {
        $fullName   = mysqli_real_escape_string($conn, trim($_POST['FullName']));
        $email      = mysqli_real_escape_string($conn, trim($_POST['email']));
        $password   = trim($_POST['password']);
        $confirm    = trim($_POST['confirm_password']);
        $gender     = mysqli_real_escape_string($conn, $_POST['gender']);
        $country    = mysqli_real_escape_string($conn, $_POST['country']);

        if ($password !== $confirm) {
            echo "<script>alert('Passwords do not match!');</script>";
        } else {
            $select = "SELECT email FROM registration WHERE email='$email'";
            $result = mysqli_query($conn, $select);

            if (mysqli_num_rows($result) > 0) {
                echo "<script>alert('Email already exists. Please use another email.'); window.location.href='login.php';</script>";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $sql = "INSERT INTO registration (full_name, email, password, gender, country) 
                        VALUES ('$fullName', '$email', '$hashedPassword', '$gender', '$country')";

                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }
    }
    ?>
</section>

<!-- Footer -->
<footer>
    <p>&copy; 2025 FitPro. All rights reserved.</p>
</footer>

</body>
</html>
