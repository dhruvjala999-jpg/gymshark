<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workout Page - Select Body Part</title>
    <link rel="stylesheet" href="./css/workout.css">
    <style>
        /* Header styles */
        header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(0, 0, 0, 0.8);
    padding: 20px 40px;
    position: fixed;
    width: 100%;
    top: 0;
}

.logo {
    font-size: 1.8rem;
    font-weight: bold;
    color: #FFD333;
}

nav ul {
    list-style: none;
    display: flex;
    gap: 22px;
    margin-block-end: 17px;
    padding-inline-end: 56px;
}

nav a {
    color: white;
    text-decoration: none;
    font-weight: 600;
}

nav a.active, nav a:hover {
    color: #020202;
}
.login-btn {
    background-color: #FFD333;
    color: black;
    padding: 5px 10px;
    border-radius: 4px;
}
        /* Offset for fixed header */
        .container {
            padding-top: 120px; /* Adjust if header height changes */
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">GYM SHARK</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="workout.php">Workouts</a></li>
                <li><a href="supplements.php">Protein Powders</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="container">
        <h1>Select a Body Part for Workout Videos</h1>
        <div class="body-parts">
            <div class="body-part" data-video="https://www.youtube.com/embed/U0bhE67HuDY">
                <img src="https://i.pinimg.com/736x/75/49/a3/7549a308773cb79b7799b7c4c62caec6.jpg" alt="Chest">
                <span>Chest</span>
            </div>
            <div class="body-part" data-video="https://www.youtube.com/embed/2pLT-olgUJs">
                <img src="https://i.pinimg.com/736x/6b/b3/e1/6bb3e17ed531423f1ce78b27eb6a4bcd.jpg" alt="Back">
                <span>Back</span>
            </div>
            <div class="body-part" data-video="https://www.youtube.com/embed/d_DI6wP8PSc">
                <img src="https://i.pinimg.com/736x/e3/eb/47/e3eb47d410082cda7eccfdc0ef64cac0.jpg" alt="Legs">
                <span>Legs</span>
            </div>
            <div class="body-part" data-video="https://www.youtube.com/embed/6kALZikXxLc">
                <img src="https://i.pinimg.com/736x/8b/98/f1/8b98f1411bbba575fb67039fc3af94bb.jpg" alt="Shoulders">
                <span>Shoulders</span>
            </div>
            <div class="body-part" data-video="https://www.youtube.com/embed/0JfYxMRsUCQ">
                <img src="https://i.pinimg.com/1200x/4f/d1/90/4fd1904639ef5df7178aa00f167a7a1f.jpg" alt="Arms">
                <span>Arms</span>
            </div>
            <div class="body-part" data-video="https://www.youtube.com/embed/8QgSAFdZQjk">
                <img src="https://i.pinimg.com/736x/0b/76/2c/0b762c6044fbfd6bdccc65e6ef2ff78d.jpg" alt="Abs">
                <span>Abs</span>
            </div>
        </div>

        <div id="video-modal" class="modal">
            <span class="close">&times;</span>
            <div class="video-container">
                <iframe id="youtube-video" width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="./js/workout.js"></script>
</body>
</html>
