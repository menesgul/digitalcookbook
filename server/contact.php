<?php
require_once '../server/config.php';  // Veritabanı bağlantısı için gerekli dosya
require_once '../db/Contact.php';  // Contact sınıfını içeren dosya

// Contact sınıfını başlat
$contact = new Contact($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formdan gelen verileri al
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $submitted_at = $_POST['submitted_at'];

    // Contact sınıfı üzerinden kaydı ekle
    $result = $contact->addContact(null, $name, $email, $subject, $message, $submitted_at);
    
    if ($result['status']) {
        echo 'Message submitted successfully!';
    } else {
        echo 'Error: ' . $result['message'];
    }
}
?>