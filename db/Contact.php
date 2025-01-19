<?php
class Contact {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addContact($user_id, $name, $email, $subject, $message, $submitted_at) {
        try {
            $sql = "INSERT INTO contacts (name, email, subject, message, submitted_at) 
                VALUES (:name, :email, :subject, :message, :submitted_at)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
            $stmt->bindValue(':message', $message, PDO::PARAM_STR);
            $stmt->bindValue(':submitted_at', $submitted_at, PDO::PARAM_STR);
    
            $stmt->execute();
    
            return ['status' => true, 'message' => 'Message submitted successfully'];
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
}
?>
