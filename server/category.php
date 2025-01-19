<?php
// classes/Category.php

class Category {
    private $conn;
    private $table = 'categories';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Tüm kategorileri listeleme
    public function getAllCategories() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result;
    }

    // Yeni kategori ekleme
    public function addCategory($idCategory, $strCategory, $strCategoryThumb, $strCategoryDescription) {
        $query = "INSERT INTO " . $this->table . " (idCategory, strCategory, strCategoryThumb, strCategoryDescription) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $idCategory, $strCategory, $strCategoryThumb, $strCategoryDescription);
        
        return $stmt->execute();
    }

    // Belirli bir kategoriyi silme
    public function deleteCategory($idCategory) {
        $query = "DELETE FROM " . $this->table . " WHERE idCategory = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $idCategory);
        
        return $stmt->execute();
    }
}

?>
