<?php
require_once 'config.php'; // Veritabanı bağlantısı
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formdan gelen verileri kontrol et
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo "Email ve şifre alanları doldurulmalıdır.";
        exit();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Kullanıcıyı email ile veritabanında arayın
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Şifre kontrolü (şifreler hashlenmişse)
            if (password_verify($password, $user['password'])) {
                $_SESSION['role'] = $user['role'];
                $_SESSION['user'] = $user; // Kullanıcı bilgilerini oturuma kaydet

                // Role göre yönlendirme
                if ($user['role'] === 'admin') {
                    header('Location: ../templates/admin_home.php'); // Admin için
                } else {
                    header('Location: ../templates/home.php'); // Normal kullanıcı için
                }
                exit();
            } else {
                echo "Geçersiz şifre.";
            }
        } else {
            echo "Bu e-posta adresiyle kayıtlı kullanıcı bulunamadı.";
        }
    } catch (PDOException $e) {
        // Hata durumunda mesajı loglayabilirsiniz
        echo "Bir hata oluştu: " . $e->getMessage();
    }
}
?>
