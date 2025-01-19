<?php
require_once '../classes/ApiHandler.php';

$api = new ApiHandler();
$data = $api->fetchData('https://www.themealdb.com/api/json/v1/1/random.php');

if ($data) {
    $meal = $data['meals'][0];
    echo "<h2>" . htmlspecialchars($meal['strMeal']) . "</h2>";
    echo "<img src='" . htmlspecialchars($meal['strMealThumb']) . "' width='300'>";
    echo "<p>" . htmlspecialchars($meal['strInstructions']) . "</p>";
} else {
    echo "Rastgele tarif bulunamadı.";
}
?>
