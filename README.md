<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>




# 🍴 Recipe Sharing Platform - Backend (Laravel 10)

Welcome to the backend for our Recipe Sharing Platform, built with Laravel 10 and PHP 8.1!

## 🌟 Features

- **API for Recipe Management**
  - Create, read, update, and delete recipes.
  - User authentication.
  - User profile management.
  - Search recipes by tags, ingredients, keywords, or categories.

## 🚀 Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

Make sure you have the following installed on your machine:

- Laravel Version: 10.x
- PHP Version: 8.1
- Web Server: Apache 2
- Database: MySQL (or any other supported by Laravel)
- Composer: Installed globally
### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/fidaahammoud/recipe_sharing_api.git

   cd recipe_sharing_api

2. **Install Composer dependencies:**

   ```bash
   composer install


3. **Configure your .env file:**

   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

4. **Run database migrations:**

   ```bash
    php artisan migrate


5. **Start the development server:**

   ```bash
    php artisan serve

🚧 Troubleshooting
If you encounter any issues during setup, please check the Laravel documentation or open an issue on GitHub.

Happy coding! 🎉