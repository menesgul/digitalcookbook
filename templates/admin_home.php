<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage - TasteBook</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Petit+Formal+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
</head>
<body>
    <!-- Navbar -->
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

    <!-- Admin Dashboard -->
    <main class="admin-dashboard">
        <section class="welcome">
            <h1>Welcome, Admin!</h1>
            <p>Manage your recipes efficiently from this dashboard.</p>
        </section>
      
        <section class="actions">
            <a href="create.php" class="action-card">
                <h3>Create New Recipe</h3>
                <p>Add fresh and exciting recipes to your collection.</p>
            </a>
            <a href="manage.html" class="action-card">
                <h3>Manage Existing Recipes</h3>
                <p>Remove outdated or duplicate recipes. <br>
                    &<br>
                   Update existing recipes.</p>
            </a>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p class="footer-text">TasteBook &copy; All rights reserved</p>
            <p class="footer-address">Beşyol, İnönü Cd. No:38, 34295 Küçükçekmece/İstanbul</p>
        </div>
    </footer>
</body>
</html>
