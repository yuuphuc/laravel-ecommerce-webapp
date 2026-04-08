<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel E-Commerce Web Application
## Overview

This project is a full-stack e-commerce web application built using Laravel.
It includes both Admin Panel for management and Client Side for customers to browse and purchase products.

The system simulates a real-world online store with product management, shopping cart, and order processing features.

## Tech Stack
Backend: PHP (Laravel 12)
Frontend: Blade Template, Bootstrap 5
Database: MySQL
Tools: Vite, DataTables
Architecture: MVC (Model - View - Controller)
# Key Features
# Admin Panel
Manage Categories, Brands, Products
Manage Customers & Orders
Upload multiple product images
Role-based authorization (Admin/User)
Dashboard overview
## Client Side
Browse products by category/brand
Product search & detail view
Add to cart / update / delete items
Checkout and create orders
# What I Learned
Applied MVC architecture in real project
Built CRUD system with Laravel
Implemented authentication & authorization
Designed relational database (products, orders, users)
Worked with session-based cart logic
Improved debugging & problem-solving skills
⚙️ Installation & Setup
# Clone project
git clone https://github.com/yuuphuc/laravel-ecommerce-webapp.git

# Move into project
cd laravel-ecommerce-webapp

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate --seed

# Run project
php artisan serve
npm run dev

- Open: http://127.0.0.1:8000

🔐 Demo Account

Admin Account

Username: user1
Password: 123456
# Project Structure
laravel-ecommerce-webapp/

 ├── app/

 │ ├── Models/ (Product, Order, User...)

 │ ├── Http/
 │ │ └── Controllers/ # Admin & Client controllers
 
 ├── routes/
 │ └── web.php # Web routes
 
 ├── resources/
 │ └── views/
 │ ├── admin/ (Admin UI)
 │ └── client/ (Client UI)
 
 ├── database/
 │ ├── migrations/ (Database schema)
 │ └── seeders/ (Sample data)
 
 ├── public/ - Assets (CSS, JS)
 └── .env (Environment config)
 
# Future Improvements
Customer authentication (login/register)
Order history for users
API integration (RESTful)
UI/UX improvements
# AI Support
Used tools like ChatGPT & Claude to:
Debug errors
Improve UI components
Suggest implementation ideas
Ensured understanding of logic before applying AI-generated code
