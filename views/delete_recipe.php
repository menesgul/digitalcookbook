<?php
require_once '../server/config.php';
require_once '../db/Recipe.php';

header('Content-Type: application/json');

$recipe = new Recipe($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $idMeal = htmlspecialchars(trim($_POST['idMeal'] ?? ''));

        if (!$idMeal) {
            echo json_encode(['success' => false, 'error' => 'Recipe ID is missing']);
            exit();
        }

        $result = $recipe->deleteRecipe($idMeal);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Recipe deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete recipe']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
