<?php
// classes/Recipe.php

class Recipe {
    private $conn;
    private $table = 'meals';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Tarif ekleme
    public function createRecipe($idMeal, $strMeal, $strMealThumb, $instructions, $category) {
        $query = "INSERT INTO " . $this->table . " (idMeal, strMeal, strMealThumb, strInstructions, strCategory) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $idMeal, $strMeal, $strMealThumb, $instructions, $category);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Tüm tarifleri görüntüleme
    public function getAllRecipes() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result;
    }

    // Belirli bir tarifi görüntüleme
    public function getRecipeById($idMeal) {
        $query = "SELECT * FROM " . $this->table . " WHERE idMeal = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $idMeal);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Tarif düzenleme
    public function updateRecipe($idMeal, $strMeal, $strMealThumb, $instructions, $category) {
        $query = "UPDATE " . $this->table . " SET strMeal = ?, strMealThumb = ?, strInstructions = ?, strCategory = ? WHERE idMeal = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $strMeal, $strMealThumb, $instructions, $category, $idMeal);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Tarif silme
    public function deleteRecipe($idMeal) {
        $query = "DELETE FROM " . $this->table . " WHERE idMeal = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $idMeal);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

?>
