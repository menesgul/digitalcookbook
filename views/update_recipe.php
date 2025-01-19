<?php
header('Content-Type: application/json');
require_once '../server/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    // Start building the base query
    $sql = "UPDATE meals SET 
            strMeal = :mealName,
            strCategory = :category,
            strArea = :area,
            strInstructions = :instructions,
            strYoutube = :youtube";
    
    $params = [
        ':mealName' => $_POST['mealName'],
        ':category' => $_POST['category'],
        ':area' => $_POST['area'],
        ':instructions' => $_POST['instructions'],
        ':youtube' => $_POST['youtube'],
        ':idMeal' => $_POST['idMeal']
    ];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $fileName = time() . '_' . basename($_FILES['image']['name']); // Zaman damgası ekleyerek benzersiz isim
        $uploadPath = $uploadDir . $fileName;
        
        // Dosya uzantısını kontrol et
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExtension, $allowedTypes)) {
            throw new Exception('Invalid file type. Only JPG, JPEG, PNG and GIF are allowed.');
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $sql .= ", strMealThumb = :image";
            $params[':image'] = '../uploads/' . $fileName; // URL yolunu kaydet
        } else {
            throw new Exception('Failed to move uploaded file.');
        }
    }

    // Handle ingredients
    if (isset($_POST['ingredients']) && isset($_POST['measurements'])) {
        for ($i = 0; $i < min(count($_POST['ingredients']), 20); $i++) {
            $idx = $i + 1;
            if (!empty($_POST['ingredients'][$i])) {
                $sql .= ", strIngredient{$idx} = :ingredient{$idx}";
                $sql .= ", strMeasure{$idx} = :measure{$idx}";
                $params[":ingredient{$idx}"] = $_POST['ingredients'][$i];
                $params[":measure{$idx}"] = $_POST['measurements'][$i];
            } else {
                $sql .= ", strIngredient{$idx} = NULL";
                $sql .= ", strMeasure{$idx} = NULL";
            }
        }
        
        // Kalan ingredient alanlarını NULL yap
        for ($i = count($_POST['ingredients']) + 1; $i <= 20; $i++) {
            $sql .= ", strIngredient{$i} = NULL";
            $sql .= ", strMeasure{$i} = NULL";
        }
    }

    // WHERE clause ekle
    $sql .= " WHERE idMeal = :idMeal";

    // Execute query
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute($params);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Recipe updated successfully',
            'recipeId' => $_POST['idMeal']
        ]);
    } else {
        throw new Exception(implode(" ", $stmt->errorInfo()));
    }

} catch (Exception $e) {
    error_log("Error in update_recipe.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error updating recipe: ' . $e->getMessage()
    ]);
}
?>