<?php
require_once '../server/config.php';
ini_set('log_errors', 1); // Hataları logla
ini_set('error_log', '/path/to/error.log'); // Log dosyası yolu

try {
    // GET parametrelerinden ID ve harfi alın
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $letter = isset($_GET['letter']) ? $_GET['letter'] : null;

    if ($id) {
        // Belirli ID'ye göre tarif bilgilerini al
        $query = "SELECT * FROM meals WHERE idMeal = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $id]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($recipe) {
            header('Content-Type: application/json');
            echo json_encode($recipe);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Recipe not found']);
        }
    } elseif ($letter) {
        // Belirli bir harfle başlayan tarifleri al
        $query = "SELECT * FROM meals WHERE strMeal LIKE :letter ORDER BY strMeal ASC";
        $stmt = $conn->prepare($query);
        $stmt->execute([':letter' => $letter . '%']);
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($recipes);
    } else {
        // Tüm tarifleri sıralı olarak al
        $query = "SELECT * FROM meals ORDER BY strMeal ASC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($recipes);
    }
} catch (PDOException $e) {
    // Hata durumunda JSON formatında hata döndür
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
