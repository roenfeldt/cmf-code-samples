# Products API Project

A minimal API project for imaginary products with CRUD operations, built on Laravel + Inertia + Vue starter kit (includes Tailwind CSS), featuring comprehensive API documentation, validation, error handling, and testing.

## Project Overview

This project implements a full-stack application for managing products. It includes:

- Product model with fields for name, description, price, stock, and active status
- RESTful API endpoints for CRUD operations (Create, Read, Update, Delete)
- Vue-driven frontend interface for product management
- Validation and error handling on both backend and frontend
- Sample data by using seeders
- Test script for API endpoints
- Comprehensive API and frontend documentation

## Setup Instructions

1. Clone the repository
2. Install dependencies:
   ```
   composer install
   npm install
   ```
3. Set up the environment:
   ```
   cp .env.example .env
   php artisan key:generate
   ```
4. Run migrations and seeders:
   ```
   php artisan migrate:fresh --seed
   ```
5. Start the development server:
   ```
   php artisan serve
   ```
   
6. Compile the frontend assets:
   ```
    npm run dev
    ```
   
7. Access the application at `http://localhost:8000`

8. For API access, use `http://localhost:8000/api/products`

9. For the Vue frontend, authenticate via the web interface with the default user credentials (email: `test@example.com`, password: `password`), or create a new user via the registration page. Once authenticated, you can access the product management pages at `/products`, where you can create, view, edit, and delete products.

## API Endpoints

The following API endpoints are available:

- `GET /api/products` - List all products
- `GET /api/products/{id}` - Get a specific product
- `POST /api/products` - Create a new product
- `PUT /api/products/{id}` - Update a product
- `DELETE /api/products/{id}` - Delete a product

For detailed information about request parameters and response formats, see the [API Documentation](API_DOCUMENTATION.md).

## Vue Frontend

The project includes a Vue-driven frontend for product management with the following pages:

- `/products` - List all products
- `/products/create` - Create a new product
- `/products/{id}` - View a specific product
- `/products/{id}/edit` - Edit a product

The frontend is built using Vue 3 with the Composition API and Inertia.js for seamless integration with Laravel.

For detailed information about the Vue implementation, see the [Product CRUD Documentation](PRODUCT_CRUD_DOCUMENTATION.md).

## Testing the API
To test the API endpoints, you can use tools like Postman. Below are examples of how to interact with the API:

### Automated Testing with Pest

The project includes automated feature tests using Pest:

1. Run the tests:
   ```
   php artisan test
   ```

The Pest tests cover all CRUD operations for the Products API:
- Listing all products
- Getting a single product
- Creating a product (including validation)
- Updating a product
- Deleting a product
- Error handling for non-existent products

## Project Structure

### Backend
- `app/Models/Product.php` - Product model
- `app/Http/Controllers/Api/ProductController.php` - Controller for product API endpoints
- `database/migrations/2025_07_18_065717_create_products_table.php` - Migration for products table
- `database/seeders/ProductSeeder.php` - Seeder for sample product data
- `routes/api.php` - API routes
- `tests/Feature/ProductApiTest.php` - Pest tests for API endpoints

### Frontend
- `resources/js/composables/useProducts.ts` - Composable for product API operations
- `resources/js/pages/Products/Index.vue` - Product list component
- `resources/js/pages/Products/Create.vue` - Product creation component
- `resources/js/pages/Products/Show.vue` - Product details component
- `resources/js/pages/Products/Edit.vue` - Product edit component
- `routes/web.php` - Web routes for Vue components

### Documentation
- `API_DOCUMENTATION.md` - Detailed API documentation
- `PRODUCT_CRUD_DOCUMENTATION.md` - Detailed Vue frontend implementation documentation
- `PRICE_FORMATTING_FIX.md` - Documentation for price formatting fix

## Features

- **Product Management**: Create, read, update, and delete products via API and Vue frontend
- **Vue-driven Frontend**: Interactive user interface built with Vue 3 and Composition API
- **Validation**: Input validation for product fields on both backend and frontend
- **Error Handling**: Proper error responses with meaningful messages on both backend and frontend
- **Sample Data**: Seeder for creating sample products
- **Testing**:
  - Automated tests using Pest for all CRUD operations
- **Documentation**: 
  - Comprehensive API documentation
  - Detailed Vue frontend implementation documentation