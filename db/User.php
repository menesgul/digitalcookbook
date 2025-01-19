<?php
// db/User.php
class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }
    // Kullanıcı kayıt işlemi
    public function register($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table . " (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $username);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $hashedPassword);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return $stmt->errorInfo(); // Hata bilgilerini döndür
        }
    }
    // Kullanıcı girişi işlemi
    public function login($email, $password) {
        $query = "SELECT id, username, password FROM " . $this->table . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                return [
                    'status' => true,
                    'user_id' => $user['id'],
                    'username' => $user['username']
                ];
            } else {
                return ['status' => false, 'message' => 'Hatalı şifre.'];
            }
        } else {
            return ['status' => false, 'message' => 'Bu e-posta adresiyle kayıtlı kullanıcı bulunamadı.'];
        }   }}  
        ?>
