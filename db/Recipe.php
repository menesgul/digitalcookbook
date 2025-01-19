<?php
// classes/Recipe.php

class Recipe {
    private $conn;
    private $table = 'meals';

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Tüm tarifleri listeleme
    public function getAllRecipes() {
        try {
            $query = "SELECT * FROM " . $this->table;
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch results as associative array
        } catch (PDOException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    // Tarif ekleme
    public function createRecipe($idMeal, $strMeal, $strCategory, $strArea, $strInstructions, $strYoutube, $strMealThumb, $ingredients) {
        try {
            $query = "INSERT INTO meals (
                idMeal, strMeal, strCategory, strArea, strInstructions, strYoutube, strMealThumb, 
                strIngredient1, strIngredient2, strIngredient3, strIngredient4, strIngredient5,
                strIngredient6, strIngredient7, strIngredient8, strIngredient9, strIngredient10,
                strIngredient11, strIngredient12, strIngredient13, strIngredient14, strIngredient15,
                strIngredient16, strIngredient17, strIngredient18, strIngredient19, strIngredient20,
                strMeasure1, strMeasure2, strMeasure3, strMeasure4, strMeasure5, strMeasure6,
                strMeasure7, strMeasure8, strMeasure9, strMeasure10, strMeasure11, strMeasure12,
                strMeasure13, strMeasure14, strMeasure15, strMeasure16, strMeasure17, strMeasure18,
                strMeasure19, strMeasure20, source
            ) VALUES (
                :idMeal, :strMeal, :strCategory, :strArea, :strInstructions, :strYoutube, :strMealThumb,
                :strIngredient1, :strIngredient2, :strIngredient3, :strIngredient4, :strIngredient5,
                :strIngredient6, :strIngredient7, :strIngredient8, :strIngredient9, :strIngredient10,
                :strIngredient11, :strIngredient12, :strIngredient13, :strIngredient14, :strIngredient15,
                :strIngredient16, :strIngredient17, :strIngredient18, :strIngredient19, :strIngredient20,
                :strMeasure1, :strMeasure2, :strMeasure3, :strMeasure4, :strMeasure5, :strMeasure6,
                :strMeasure7, :strMeasure8, :strMeasure9, :strMeasure10, :strMeasure11, :strMeasure12,
                :strMeasure13, :strMeasure14, :strMeasure15, :strMeasure16, :strMeasure17, :strMeasure18,
                :strMeasure19, :strMeasure20, :source
            )";

            $stmt = $this->conn->prepare($query);

            // Temel alanlar
            $stmt->bindValue(':idMeal', $idMeal, PDO::PARAM_STR);
            $stmt->bindValue(':strMeal', $strMeal, PDO::PARAM_STR);
            $stmt->bindValue(':strCategory', $strCategory, PDO::PARAM_STR);
            $stmt->bindValue(':strArea', $strArea, PDO::PARAM_STR);
            $stmt->bindValue(':strInstructions', $strInstructions, PDO::PARAM_STR);
            $stmt->bindValue(':strYoutube', $strYoutube, PDO::PARAM_STR);
            $stmt->bindValue(':strMealThumb', $strMealThumb, PDO::PARAM_LOB);

            // Malzemeler ve ölçüler
           // Malzemeler ve ölçüler
           for ($i = 1; $i <= 20; $i++) {
            $ingredientKey = "strIngredient$i";
            $measureKey = "strMeasure$i";
        
            $stmt->bindValue(":$ingredientKey", $ingredients[$ingredientKey] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(":$measureKey", $ingredients[$measureKey] ?? null, PDO::PARAM_STR);
        }
        
        
            // Kaynağı belirle
            $stmt->bindValue(':source', 'user', PDO::PARAM_STR);

            $stmt->execute();

            return ['status' => true];
        } catch (PDOException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
   // Recipe.php sınıfına eklenecek metod


   public function updateRecipe($idMeal, $strMeal, $strCategory, $strArea, $strInstructions, $strYoutube, $strImage, $ingredients) {
    try {
        $sql = "UPDATE $this->table SET 
                strMeal = :strMeal,
                strCategory = :strCategory,
                strArea = :strArea,
                strInstructions = :strInstructions,
                strYoutube = :strYoutube,
                strImage = :strImage,
                strIngredient1 = :strIngredient1,
                strMeasure1 = :strMeasure1,
                strIngredient2 = :strIngredient2,
                strMeasure2 = :strMeasure2,
                strIngredient3 = :strIngredient3,
                strMeasure3 = :strMeasure3,
                strIngredient4 = :strIngredient4,
                strMeasure4 = :strMeasure4,
                strIngredient5 = :strIngredient5,
                strMeasure5 = :strMeasure5
                WHERE idMeal = :idMeal";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(':idMeal', $idMeal);
        $stmt->bindValue(':strMeal', $strMeal);
        $stmt->bindValue(':strCategory', $strCategory);
        $stmt->bindValue(':strArea', $strArea);
        $stmt->bindValue(':strInstructions', $strInstructions);
        $stmt->bindValue(':strYoutube', $strYoutube);
        $stmt->bindValue(':strImage', $strImage, PDO::PARAM_LOB);

        // İlk 5 malzeme ve ölçü için binding
        for ($i = 1; $i <= 5; $i++) {
            $stmt->bindValue(":strIngredient$i", $ingredients["ingredient$i"] ?? null);
            $stmt->bindValue(":strMeasure$i", $ingredients["measure$i"] ?? null);
        }

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Recipe updated successfully'];
        }
        
        return ['success' => false, 'message' => implode(' ', $stmt->errorInfo())];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

public function getRecipeById($id) {
    $query = "SELECT * FROM " . $this->table . " WHERE idMeal = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // Tarif silme
    public function deleteRecipe($idMeal) {
        try {
            $query = "DELETE FROM meals WHERE idMeal = :idMeal";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':idMeal' => $idMeal]);
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    
}
?>
