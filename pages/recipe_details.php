<?php
require_once '../classes/ApiHandler.php';

$api = new ApiHandler();
$id = isset($_GET['id']) ? $_GET['id'] : '52772'; // Default ID

$data = $api->fetchData("https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . urlencode($id));

if ($data) {
    $meal = $data['meals'][0];
    echo "<h2>" . htmlspecialchars($meal['strMeal']) . "</h2>";
    echo "<img src='" . htmlspecialchars($meal['strMealThumb']) . "' width='300'>";
    echo "<p>" . htmlspecialchars($meal['strInstructions']) . "</p>";
} else {
    echo "Yemek detayları bulunamadı.";
}
?>
