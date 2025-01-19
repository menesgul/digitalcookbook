<?php
require_once '../classes/ApiHandler.php';

$api = new ApiHandler();
$data = $api->fetchData('https://www.themealdb.com/api/json/v1/1/categories.php');

if ($data) {
    foreach ($data['categories'] as $category) {
        echo "<h3>" . htmlspecialchars($category['strCategory']) . "</h3>";
        echo "<img src='" . htmlspecialchars($category['strCategoryThumb']) . "' width='200'>";
        echo "<p>" . htmlspecialchars($category['strCategoryDescription']) . "</p>";
    }
} else {
    echo "Kategoriler bulunamadı.";
}
?>
