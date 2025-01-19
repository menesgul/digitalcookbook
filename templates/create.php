<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TasteBook - Create New Recipe</title>
    <link rel="stylesheet" href="../assets/css/create.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Petit+Formal+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
</head>
<body>
<nav class="navbar">
        <a href="/admin_home.php" style="text-decoration: none; color: inherit;">
            <div class="logo">TasteBook Admin</div>
          </a>          
        <div class="menu">
            <a href="admin_home.php">Home</a>
            <a href="create.php">Create New Recipe</a>
            <a href="manage.html">Manage Recipes</a>
            <a href="../server/logout.php">Logout</a>
        </div>
    </nav>
    <main>
        <form class="create-recipe-form" action="../views/create_recipe.php" method="POST" enctype="multipart/form-data">
            <div class="form-header">
                <h1>Create New Recipe</h1>
            </div>

            <div class="form-group">
                <label for="mealName">Recipe Name*</label>
                <input type="text" id="mealName" name="strMeal" class="form-control" placeholder="Recipe Name" required>
            </div>

            <div class="form-group">
                <label for="category">Category*</label>
                <select id="category" name="strCategory" class="form-control" required>
                    <option value="">Select a category</option>
                    <option value="Beef">Beef</option>
                    <option value="Chicken">Chicken</option>
                    <option value="Dessert">Dessert</option>
                    <option value="Lamb">Lamb</option>
                    <option value="Pasta">Pasta</option>
                    <option value="Seafood">Seafood</option>
                    <option value="Side">Side</option>
                    <option value="Starter">Starter</option>
                    <option value="Vegetarian">Vegetarian</option>
                </select>
            </div>

            <div class="form-group">
                <label for="area">Cuisine Area*</label>
                <select id="area" name="strArea" class="form-control" required>
                    <option value="">Select a cuisine</option>
                    <option value="American">American</option>
                    <option value="British">British</option>
                    <option value="Chinese">Chinese</option>
                    <option value="French">French</option>
                    <option value="Indian">Indian</option>
                    <option value="Italian">Italian</option>
                    <option value="Japanese">Japanese</option>
                    <option value="Mediterranean">Mediterranean</option>
                    <option value="Mexican">Mexican</option>
                    <option value="Thai">Thai</option>
                    <option value="Turkish">Turkish</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Recipe Image*</label>
                <input type="file" id="image" name="strImage" class="form-control" accept="image/*" required>
                <img id="imagePreview" class="preview-image" alt="Recipe preview">
            </div>

            <div class="form-group">
                <label for="instructions">Instructions*</label>
                <textarea id="instructions" name="strInstructions" class="form-control" placeholder="Write instructions here..." required></textarea>
            </div>

            <div class="form-group">
                <label for="youtube">YouTube Tutorial Link (optional)</label>
                <input type="url" id="youtube" name="strYoutube" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
            </div>

            <div class="ingredients-container">
                <label>Ingredients and Measurements*</label>
                <div id="ingredientsList">
                    <div class="ingredient-row">
                        <input type="text" name="strIngredient[]" class="form-control" placeholder="Ingredient" required>
                        <input type="text" name="strMeasure[]" class="form-control" placeholder="Measurement" required>
                        <button type="button" class="remove-ingredient" onclick="removeIngredient(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="add-ingredient" onclick="addIngredient()">
                    <i class="fas fa-plus"></i> Add Ingredient
                </button>
                
            </div>

            <button type="submit" class="submit-btn">Create Recipe</button>
        </form>
    </main>
  
    <footer class="footer">
        <div class="footer-content">
            <p class="footer-text">TasteBook &copy; All rights reserved</p>
            <p class="footer-address">Beşyol, İnönü Cd. No:38, 34295 Küçükçekmece/İstanbul</p>
        </div>
    </footer>
 
    <script>
        // Function to add new ingredient row
function addIngredient() {
    const ingredientsList = document.getElementById('ingredientsList');
    const newRow = document.createElement('div');
    newRow.className = 'ingredient-row';
    newRow.innerHTML = `
        <input type="text" name="strIngredient[]" class="form-control" placeholder="Ingredient" required>
        <input type="text" name="strMeasure[]" class="form-control" placeholder="Measurement" required>
        <button type="button" class="remove-ingredient" onclick="removeIngredient(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;
    ingredientsList.appendChild(newRow);
}

// Function to remove ingredient row
function removeIngredient(button) {
    const row = button.parentElement;
    const ingredientsList = document.getElementById('ingredientsList');
    if (ingredientsList.children.length > 1) {
        row.remove();
    }
}


        // Function to preview image
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Form submission handler
        document.getElementById('recipeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Collect ingredients
            const ingredientRows = document.querySelectorAll('.ingredient-row');
            const ingredients = [];
            const measurements = [];
            
            ingredientRows.forEach(row => {
                const inputs = row.querySelectorAll('input');
                ingredients.push(inputs[0].value);
                measurements.push(inputs[1].value);
            });

            const recipe = {
                strMeal: document.getElementById('mealName').value,
                strCategory: document.getElementById('category').value,
                strArea: document.getElementById('area').value,
                strInstructions: document.getElementById('instructions').value,
                strYoutube: document.getElementById('youtube').value,
                ...ingredients.reduce((acc, ing, i) => {
                    acc[`strIngredient${i+1}`] = ing;
                    acc[`strMeasure${i+1}`] = measurements[i];
                    return acc;
                }, {})
            };
             document.getElementById('imagePreview').style.display = 'none';
            
            
             // Show success popup
             const popup = document.getElementById('successPopup');
            popup.style.display = 'block';
    
            // Hide popup after 3 seconds
            setTimeout(() => {
                popup.style.display = 'none';
            }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
        });

        
    </script>

</body>
</html>
