<?php
require_once '../server/config.php';
require_once '../db/Recipe.php';

$recipe = new Recipe($conn);

session_start();
if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Proceed with recipe creation


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMeal = uniqid(); // Benzersiz bir idMeal oluştur
    $strMeal = htmlspecialchars(trim($_POST['strMeal'] ?? ''));
    $strCategory = htmlspecialchars(trim($_POST['strCategory'] ?? ''));
    $strArea = htmlspecialchars(trim($_POST['strArea'] ?? ''));
    $strInstructions = htmlspecialchars(trim($_POST['strInstructions'] ?? ''));
    $strYoutube = htmlspecialchars(trim($_POST['strYoutube'] ?? ''));
    $strMealThumb = ''; // Başlangıçta boş bırakılıyor
    if (isset($_FILES['strImage']) && $_FILES['strImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['strImage']['tmp_name'];
        $fileName = uniqid() . '-' . $_FILES['strImage']['name']; // Benzersiz dosya adı
        $uploadFileDir = '../uploads/'; // Görsellerin kaydedileceği klasör
        $destPath = $uploadFileDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $strMealThumb = '../uploads/' . $fileName; // Bu yolu veritabanına kaydediyoruz
        } else {
            die('Görsel yüklenirken bir hata oluştu.');
        }
    }
    
    $ingredients = [];
    $ingredients = [];
    for ($i = 0; $i < count($_POST['strIngredient']); $i++) {

        $ingredients["strIngredient" . ($i + 1)] = htmlspecialchars(trim($_POST['strIngredient'][$i] ?? ''));
        $ingredients["strMeasure" . ($i + 1)] = htmlspecialchars(trim($_POST['strMeasure'][$i] ?? ''));
    }
  
    
    if ( $idMeal &&  $strMeal && $strCategory && $strArea && $strInstructions) {
        $result = $recipe->createRecipe( $idMeal,$strMeal, $strCategory, $strArea, $strInstructions, $strYoutube, $strMealThumb, $ingredients);
        
        if ($result['status']) {
            echo "Tarif başarıyla eklendi!";
        } else {
            echo "Tarif eklenirken bir hata oluştu: " . $result['message'];
        }
    } else {
        echo "Lütfen tüm gerekli alanları doldurunuz.";
    }


}
?>
