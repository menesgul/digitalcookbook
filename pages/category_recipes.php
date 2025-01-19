<?php
require_once '../classes/ApiHandler.php';

$api = new ApiHandler();
$category = isset($_GET['c']) ? $_GET['c'] : 'Seafood'; // Default olarak 'Seafood' kategorisi
$data = $api->fetchData("https://www.themealdb.com/api/json/v1/1/filter.php?c=" . urlencode($category));

if ($data) {
    foreach ($data['meals'] as $meal) {
        echo "<h3>" . htmlspecialchars($meal['strMeal']) . "</h3>";
        echo "<img src='" . htmlspecialchars($meal['strMealThumb']) . "' width='200'>";
        echo "<a href='recipe_details.php?id=" . urlencode($meal['idMeal']) . "'>Detaylar</a><br>";
    }
} else {
    echo "Bu kategoride tarif bulunamadı.";
}
?>
