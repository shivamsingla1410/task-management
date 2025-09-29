# Task Management
Task Management Web Application using the LAMP stack (Linux, Apache, MySQL, PHP)

## Introduction
This project is a Task Management System built with Laravel 12.4.
It allows admins and users to manage tasks efficiently, with updates reflecting in real-time using AJAX long polling (can be swapped with WebSockets/Pusher).

## Tech Stack

- **Backend**: Laravel 12.4 (PHP 8.3)
- **Frontend**: Blade, JavaScript, TailwindCSS
- **Auth**: Laravel Breeze (login, registration, roles)
- **Database**: MySQL
- **Real-Time Updates**: AJAX Long Polling (option to switch to WebSockets/Pusher)

## Getting Started

### Setup Instructions
1. Clone this repository:
    ```bash
    https://github.com/shivamsingla1410/task-management.git
    ```
2. Configure environment variables by copying `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   # Update the .env file with your database connection details
   ```
3. Install dependencies:
    ```bash
    composer install
    npm install
    ```
4. Database Setup:
    ```bash
    php artisan migrate
    ```
5. Seed the database with initial data:
    ```bash
    php artisan db:seed --class=UserSeeder
    ```
6. Apply application encryption key:
    ```
    php artisan key:generate
    ```
7. Build your application for production ready:
    ```bash
    npm run build
    ```
8. Start the development server (applicable for local environment):
   ```bash
   php artisan serve
   ```

### Troubleshooting Database Issues
1. Check your database connection details.
2. Check if the dependencies have been installed properly.
3. Check if the application has been build for production ready.

### Default Users

The seeded database includes three users:

1. Admin User:
   - Email: admin@example.com
   - Password: password
   - Role: admin

2. Manager User:
   - Email: manager@example.com
   - Password: password
   - Role: manager

3. Normal User:
   - Email: user@example.com
   - Password: password
   - Role: user