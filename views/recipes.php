<?php
require_once '../server/config.php';
require_once '../db/Recipe.php'; // Doğru yolu kontrol edin

$recipe = new Recipe($conn);
$recipes = $recipe->getAllRecipes();

echo "<h2>Tarifler</h2>";
echo "<ul>";
while ($row = $recipes->fetch_assoc()) {
    echo "<li>";
    echo "<strong>" . htmlspecialchars($row['strMeal']) . "</strong>";
    echo " - <a href='update_recipe.php?id=" . urlencode($row['idMeal']) . "'>Düzenle</a>";
    echo " | <a href='delete_recipe.php?id=" . urlencode($row['idMeal']) . "' onclick=\"return confirm('Silmek istediğinize emin misiniz?');\">Sil</a>";
    echo "</li>";
}
echo "</ul>";
?>
