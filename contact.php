<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="./css/contect.css">
    <header>
        <div class="logo">GYM SHARK</div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="workout.php">Workouts</a></li>
                <li><a href="supplements.php">Protein Powders</a></li>
                <!-- <li><a href="contact.php">Contact</a></li> -->
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>
</head>
<body>
    <div class="contact-container">
        <h1>Contact Us</h1>
        <p class="subtitle">We'd love to hear from you! Please fill out the form below and we'll get in touch as soon as possible.</p>
        <div class="contact-content">
            <form class="contact-form" action="contact_process.php" method="post">
                <label for="name">Full Name <span>*</span></label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email Address <span>*</span></label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Subject <span>*</span></label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message <span>*</span></label>
                <textarea id="message" name="message" rows="6" required></textarea>

                <button type="submit">Send Message</button>
            </form>
            <div class="contact-info">
                <h2>Our Contact Information</h2>
                <p><strong>Address:</strong><br>
                    123 Main Street,<br>
                    City, State 12345,<br>
                    Country
                </p>
                <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                <p><strong>Email:</strong> info@example.com</p>
                <div class="contact-social">
                    <h3>Follow Us</h3>
                    <a href="#" title="Facebook" class="social-icon">🌐</a>
                    <a href="#" title="Twitter" class="social-icon">🐦</a>
                    <a href="#" title="LinkedIn" class="social-icon">🔗</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>