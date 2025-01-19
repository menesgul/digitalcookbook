<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/signup.css">
</head>
<body>
    <!-- Header Navigation Section -->
    <header>
        <nav class="navbar">
            <div class="logo">TasteBook</div>
            <div class="menu">
                <a href="login.html">Log In</a>
                <a href="signup.html">Sign Up</a>
            </div>
        </nav>
    </header>

    <!-- Sign Up Section -->
    <div class="signup-container">
        <div class="signup-box">
            <h1 class="signup-title">Sign Up</h1>
            <form id="signupForm" action="" method="POST">
                <input type="text" id="username" name="username" placeholder="Username" class="signup-input" required minlength="3">
                <small id="usernameError" class="error-message"></small>
                
                <input type="email" id="email" name="email" placeholder="Email" class="signup-input" required>
                <small id="emailError" class="error-message"></small>
                
                <input type="password" id="password" name="password" placeholder="Password" class="signup-input" required minlength="6">
                <small id="passwordError" class="error-message"></small>
                
                <button type="submit" class="signup-button">Sign Up</button>
            </form>
            
            <div class="login-prompt">
                Already have an account? <a href="login.html" class="signup-link">Log In</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p class="footer-text">TasteBook &copy; All rights reserved</p>
            <p class="footer-address">Beşyol, İnönü Cd. No:38, 34295 Küçükçekmece/İstanbul</p>
        </div>
    </footer>
    
    <script src="../assets/js/signup.js"></script>
</body>
</html>

<?php
require_once 'config.php';
require_once '../db/User.php';

// User sınıfını başlat
$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kullanıcı kaydını gerçekleştir ve sonucu kontrol et
    $result = $user->register($username, $email, $password);
    
   
    if ($result === true) {
        echo "Kayıt başarılı!";
    } else {
        // Hata mesajını ekrana yazdır
        echo "Kayıt sırasında bir hata oluştu: " . implode(", ", $result);
    }
} 
else {
    echo "POST isteği gelmedi.";
}

?>

<form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Kullanıcı Adı" required>
    <input type="email" name="email" placeholder="E-posta" required>
    <input type="password" name="password" placeholder="Şifre" required>
    <button type="submit">Kayıt Ol</button>
</form>
