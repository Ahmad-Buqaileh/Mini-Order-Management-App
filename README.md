# Mini-Order-Management-App

A lightweight mini ordering application built using Symfony, PHP, and Angular.
The system provides essential functionality for authentication, product browsing, cart management, and order processing. 
This project includes a Symfony backend and an Angular frontend client.

## Features

- User authentication with email and password
- JWT-based authorization
- Product listing and search by query/category
- Shopping cart management
- Order creation and order history
- Structured and maintainable Symfony architecture
- REST-style API endpoints
- Angular frontend for user interaction

# Requirements

### Backend (Symfony)
- PHP 8+
- Composer
- Symfony CLI
- MySQL database

### Frontend (Angular)
- Node.js 
- NPM
- Angular CLI 

# Setup Instructions

## 1. Backend (Symfony)

### 1. Clone the repository
```
git clone 'https://github.com/Ahmad-Buqaileh/Mini-Order-Management-App.git'
```
### 2. Install backend dependencies
```
composer install
```
### 3. Configure environment variables
inside of the .env add
```
JWT_SECRET= add_secret_here  (run openssl rand -base64 48 in your terminal)
JWT_ACCESS_TTL=add_ttl_here
JWT_REFRESH_TTL=add_ttl_here
JWT_REFRESH_COOKIE_NAME=add_name_here
JWT_ISSUER=add_issuer_here -> (http://localhost:3000)
```

### 4. Run database migrations
```
php bin/console doctrine:migrations:migrate
```
### 5. Start the backend development server
```
php -S localhost:8000 -t public
```
The backend API is now available at:
http://localhost:8000

---

## 2. Frontend (Angular)

### 1. Navigate to the Angular project folder
```
cd front-end
```
### 2. Install dependencies
```
npm install
```
### 3. Start the Angular development server
```
ng serve
```

The Angular frontend will be available at:
http://localhost:3000

---

## To-Do

- Complete api logic in the front-end (auth/update cart items)
- Add Docker configuration for backend and frontend containers
- Implement toast notification
- Add pagination for product listing
