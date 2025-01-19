<?php
// logout.php
session_start();

// Tüm oturum değişkenlerini temizle
$_SESSION = [];

// Oturumu sonlandır
session_destroy();

// Kullanıcıyı login sayfasına yönlendir
header('Location: ../templates/login.html');
exit();
