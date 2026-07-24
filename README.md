# Product Inventory Management System

A simple inventory system for managing products, categories, suppliers, stock in/out, and related admin operations.

## Features

- Admin authentication and role-based access
- Product CRUD with image uploads
- Category and supplier management
- Stock in/out tracking
- Product detail modal with product information

## Requirements

- PHP 8.3+ with PDO MySQL enabled
- Apache / Laragon web server
- MySQL database named `inventory_db`

## Setup

1. Place the project in your local web root (for example, `C:\laragon\www\Team2_prodcts_inventory`).
2. Import the SQL schema from [database/inventory.sql](database/inventory.sql).
3. Verify the database credentials in [config/database.php](config/database.php).
4. Open the project in your browser at `http://localhost/Team2_prodcts_inventory/`.

## Notes

- The app expects the MySQL PDO extension to be available in PHP.
- Uploaded product images are stored in `assets/uploads/products/`.
