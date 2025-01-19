# TasteBook

TasteBook is an online recipe-book platform where users can explore, search, and browse recipes by category.
The project also enables admins to perform CRUD operations (Create, Read, Update, Delete) to efficiently manage and curate recipe content. 
Additionally, it features user and admin authentication, a fully responsive design, and API integration. 

This project provided an excellent opportunity to enhance my skills in backend development using PHP, 
database management with MySQL, and creating dynamic and responsive web interfaces.
Through building TasteBook, I gained valuable experience in implementing authentication systems,
managing CRUD operations, and ensuring seamless user interaction across devices.

---

## Project Overview

### Features

- **User Features:**

  - Browse a diverse collection of recipes.
  - Filter recipes by categories (e.g., vegetarian, non-vegetarian, cuisines).
  - Search for recipes by name, ingredient, or category.
  - View detailed recipe pages with ingredients, instructions, and video links.
  - Use a responsive design optimized for mobile, tablet, and desktop.

- **Admin Features:**

  - Authentication and secure admin panel access.
  - Create, update, delete, and manage recipes.
  - Validate inputs to maintain data integrity.
  - Organize recipes with images and categories.

- **Technical Features:**

  - Integration with TheMealDB API for extended recipe data.
  - Secure login and registration with password encryption.
  - Responsive and user-friendly interface.

---

## Technology Stack

- **Frontend:**

  - HTML, CSS, JavaScript

- **Backend:**

  - PHP (server-side scripting)

- **Database:**

  - MySQL (recipe and user data management)

- **API:**

  - [TheMealDB API](https://www.themealdb.com/api.php)

- **Development Environment:**

  - Visual Studio Code
  - WAMP/XAMPP for local server testing

---

## Getting Started

### Prerequisites

- Local server environment (e.g., WAMP, XAMPP, or MAMP)
- PHP 7.4 or higher
- MySQL database

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/menesgul/digitalcookbook.git
   ```
2. Set up the database:
   - Create a new MySQL database named `digitalcookbook`.
   - Import the SQL scripts from the `/database` folder into your database.
3. Configure the database connection:
   - Update the `config.php` file with your database credentials.
4. Start your local server:
   - Place the project folder in your server’s root directory.
     - For XAMPP: `C:/xampp/htdocs/`
     - For WAMP: `C:/wamp/www/`
5. Run the application:
   - Open your browser and navigate to `http://localhost/digitalcookbook/`.

---

## Project Structure

- `/admin`: Contains admin dashboard pages for recipe management.
- `/assets`: Static assets such as images and stylesheets.
- `/includes`: Common PHP scripts for reusability.
- `/database`: SQL scripts for database setup.
- `/user`: User-facing pages, including home, recipes, and contact.
- `config.php`: Database connection settings.

---


## License

This project is licensed under the MIT License. See the LICENSE file for details.

---

## Demo

The live version of the project is available at [TasteBook](https://tastebook.site) (active until **23.01.2025**).



User credentials for testing:

- Email: `user@gmail.com`
- Password: `123456`

---

## Future Enhancements

- User profile management and favorite recipes.
- Recipe ratings and reviews.
- Integration with more APIs for expanded recipe options.
- Deployment on a scalable cloud platform.

---

For more details, check out the [GitHub Repository](https://github.com/menesgul/digitalcookbook).

