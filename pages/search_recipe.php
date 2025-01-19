<?php
require_once '../classes/ApiHandler.php';

$api = new ApiHandler();
$search = isset($_GET['s']) ? $_GET['s'] : 'Arrabiata'; // Default arama kelimesi
$data = $api->fetchData("https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($search));

if ($data) {
    foreach ($data['meals'] as $meal) {
        echo "<h3>" . htmlspecialchars($meal['strMeal']) . "</h3>";
        echo "<img src='" . htmlspecialchars($meal['strMealThumb']) . "' width='200'>";
        echo "<a href='recipe_details.php?id=" . urlencode($meal['idMeal']) . "'>Detaylar</a><br>";
    }
} else {
    echo "Aradığınız tarif bulunamadı.";
}
?>
