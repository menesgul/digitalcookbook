<?php
session_start();
if (!isset($_SESSION['role'])) {
    header('Location: login.html'); // Kullanıcı giriş yapmadıysa login sayfasına yönlendirilir
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TasteBook - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Petit+Formal+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">


</head>
<body>
    <nav class="navbar">
        <a href="home.php" style="text-decoration: none; color: inherit;">
            <div class="logo">TasteBook</div></a>
        <div class="menu">
            <a href="home.php">Home </a>
            <a href="recipes.php">Recipes</a>
            <?php if ($_SESSION['role'] === 'admin') : ?>
            <a href="create.php">Create New Recipe</a>
            <?php endif; ?>

            <a href="categories.html">Categories</a>
            <a href="contact.html">Contact Us</a>
            <a href="../server/logout.php">Logout</a>

        </div>
    </nav>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Learn. Cook. Share.</h1>
                <h2>Cooking Made Easy.</h2>
                <p>Say good bye to long and frustrating food blogs and recipe videos. Access our recipe cards to prepare any dish in minutes.</p>
                <button class="browse-btn" onclick="scrollToRecipes()">Browse Dish</button>
            </div>
            <div class="hero-image">
                <img id="hero-img" src="../assets/images/hero-image.png" alt="Delicious dish">
            </div>
        </section>

        <section class="search-section">
            <h2>Search Your Favorite Dish</h2>
            <div class="search-container">
                <input type="text" placeholder="What are you looking for?" class="search-input">
                <button class="search-btn">
                    <i class="fa-solid fa-magnifying-glass" alt="Search"></i>
                </button>
            </div>
        </section>

        <section class="recipe-grid" id="recipeGrid">
            <!-- Recipe cards will be dynamically inserted here -->
        </section>
    </main>

    <!-- Modal to show recipe details -->
<div id="recipeModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle"></h2>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body">
            <img id="modalImage" alt="Recipe Image">
            <h3>Ingredients</h3>
            <ul id="modalIngredients"></ul>
            <h3>Instructions</h3>
            <p id="modalInstructions"></p>
            <a id="modalVideo" href="#" target="_blank">Watch Recipe Video</a>
        </div>
    </div>
</div>


    <footer class="footer">
        <div class="footer-content">
            <p class="footer-text">TasteBook &copy; All rights reserved</p>
            <p class="footer-address">Beşyol, İnönü Cd. No:38, 34295 Küçükçekmece/İstanbul</p>
        </div>
    </footer>

    <script>
        // Function to scroll to recipe section
        function scrollToRecipes() {
            const recipeSection = document.querySelector('.recipe-grid');
            recipeSection.scrollIntoView({ behavior: 'smooth' });
        }

        async function fetchRandomRecipes() {
            const recipeGrid = document.getElementById('recipeGrid');
            recipeGrid.innerHTML = '';

            for (let i = 0; i < 4; i++) {
                try {
                    const response = await fetch('https://www.themealdb.com/api/json/v1/1/random.php');
                    const data = await response.json();
                    const meal = data.meals[0];

                    const recipeCard = document.createElement('div');
                    recipeCard.className = 'recipe-card';
                    recipeCard.innerHTML = `
                        <img src="${meal.strMealThumb}" alt="${meal.strMeal}">
                        <h3>${meal.strMeal}</h3>
                        <p class="ingredients">${getMainIngredients(meal)}</p>
                        <span class="cuisine-tag">${meal.strArea}</span>
                    `;
                    recipeGrid.appendChild(recipeCard);
                } catch (error) {
                    console.error('Error fetching recipe:', error);
                }
            }
        }

        function getMainIngredients(meal) {
            const ingredients = [];
            for (let i = 1; i <= 4; i++) {
                if (meal[`strIngredient${i}`]) {
                    ingredients.push(meal[`strIngredient${i}`]);
                }
            }
            return ingredients.join(', ');
        }

        // Load recipes when page loads
        document.addEventListener('DOMContentLoaded', fetchRandomRecipes);


        // Function to open the modal with recipe details
function openRecipeModal(mealId) {
    fetch(`https://www.themealdb.com/api/json/v1/1/lookup.php?i=${mealId}`)
        .then(response => response.json())
        .then(data => {
            const meal = data.meals[0];
            document.getElementById('modalTitle').textContent = meal.strMeal;
            document.getElementById('modalImage').src = meal.strMealThumb;
            document.getElementById('modalInstructions').textContent = meal.strInstructions;
            
            // Populate ingredients
            const ingredientsList = document.getElementById('modalIngredients');
            ingredientsList.innerHTML = '';
            for (let i = 1; i <= 20; i++) {
                if (meal[`strIngredient${i}`]) {
                    const li = document.createElement('li');
                    li.textContent = `${meal[`strIngredient${i}`]} - ${meal[`strMeasure${i}`]}`;
                    ingredientsList.appendChild(li);
                }
            }

            // Set the video link
            const videoLink = document.getElementById('modalVideo');
            videoLink.href = meal.strYoutube || '#';
            
            // Show the modal
            document.getElementById('recipeModal').style.display = 'flex';
        })
        .catch(error => console.error('Error fetching recipe details:', error));
}

// Function to close the modal
function closeModal() {
    document.getElementById('recipeModal').style.display = 'none';
}

// Modify the fetchRandomRecipes function to make cards clickable
async function fetchRandomRecipes() {
    const recipeGrid = document.getElementById('recipeGrid');
    recipeGrid.innerHTML = '';

    for (let i = 0; i < 4; i++) {
        try {
            const response = await fetch('https://www.themealdb.com/api/json/v1/1/random.php');
            const data = await response.json();
            const meal = data.meals[0];

            const recipeCard = document.createElement('div');
            recipeCard.className = 'recipe-card';
            recipeCard.innerHTML = `
                <img src="${meal.strMealThumb}" alt="${meal.strMeal}">
                <h3>${meal.strMeal}</h3>
                <p class="ingredients">${getMainIngredients(meal)}</p>
                <span class="cuisine-tag">${meal.strArea}</span>
            `;
            recipeCard.onclick = () => openRecipeModal(meal.idMeal); // Add click handler
            recipeGrid.appendChild(recipeCard);
        } catch (error) {
            console.error('Error fetching recipe:', error);
        }
    }
}


// Enhanced search functionality
const searchInput = document.querySelector('.search-input');
const searchBtn = document.querySelector('.search-btn');

async function searchRecipes(query) {
    const recipeGrid = document.getElementById('recipeGrid');
    recipeGrid.classList.add('loading');
    
    try {
        const response = await fetch(`https://www.themealdb.com/api/json/v1/1/search.php?s=${query}`);
        const data = await response.json();
        
        recipeGrid.innerHTML = '';
        
        if (data.meals) {
            data.meals.forEach(meal => {
                const recipeCard = document.createElement('div');
                recipeCard.className = 'recipe-card';
                recipeCard.innerHTML = `
                    <img src="${meal.strMealThumb}" alt="${meal.strMeal}">
                    <h3>${meal.strMeal}</h3>
                    <p class="ingredients">${getMainIngredients(meal)}</p>
                    <span class="cuisine-tag">${meal.strArea}</span>
                `;
                recipeCard.onclick = () => openRecipeModal(meal.idMeal);
                recipeGrid.appendChild(recipeCard);
            });
        } else {
            recipeGrid.innerHTML = '<p class="no-results">No recipes found. Try another search term.</p>';
        }
    } catch (error) {
        console.error('Error searching recipes:', error);
        recipeGrid.innerHTML = '<p class="no-results">Error searching recipes. Please try again.</p>';
    } finally {
        recipeGrid.classList.remove('loading');
    }
}

searchBtn.addEventListener('click', () => {
    const query = searchInput.value.trim();
    if (query) {
        searchRecipes(query);
    }
});

searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        const query = searchInput.value.trim();
        if (query) {
            searchRecipes(query);
        }
    }
});

// Enhanced modal handling
window.addEventListener('click', (e) => {
    const modal = document.getElementById('recipeModal');
    if (e.target === modal) {
        closeModal();
    }
});

    </script>
</body>
</html>