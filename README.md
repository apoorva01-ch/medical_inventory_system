# Medical Inventory System

A full-stack web-based Medical Inventory Management System built with PHP and MySQL.
The system supports two user roles — Admin and Pharmacist/Staff — and provides complete 
control over medicines, suppliers, stock, orders, and sales records.


## Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [User Roles](#user-roles)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [How to Run Locally](#how-to-run-locally)
- [Admin Panel](#admin-panel)
- [Future Improvements](#future-improvements)
- [Author](#author)


## Project Overview

This Medical Inventory System was built to digitally manage a medical store's day-to-day 
operations. The system eliminates manual record-keeping by providing a structured platform 
to track medicines, manage suppliers, monitor stock levels, and handle orders and sales — 
all from a single web-based interface.

The project has two login portals — one for the Admin who has full control over the system, 
and one for the Pharmacist/Staff who can handle day-to-day inventory and sales tasks. 
It demonstrates practical skills in full-stack web development using PHP and MySQL with 
a responsive frontend built using HTML, CSS, JavaScript and Bootstrap.


## Features

### Admin Side

- Secure admin login and authentication
- Dashboard with overall inventory and sales statistics
- Add, edit, and delete medicines
- Manage supplier details and records
- Track stock availability and stock-in history
- Manage and view all orders and sales
- Full CRUD operations with MySQL database
- Responsive interface across desktop and mobile

### Pharmacist / Staff Side

- Secure staff login and authentication
- View available medicines and current stock levels
- Manage day-to-day stock and sales operations
- Access relevant inventory records


## User Roles

| Role              | Access                                                        |
|-------------------|---------------------------------------------------------------|
| Admin             | Full control — medicines, suppliers, stock, orders, sales     |
| Pharmacist / Staff| Day-to-day inventory management and sales operations          |


## Tech Stack

| Layer      | Technology                        |
|------------|-----------------------------------|
| Frontend   | HTML, CSS, JavaScript, Bootstrap  |
| Backend    | PHP                               |
| Database   | MySQL                             |
| Server     | XAMPP                             |


## Project Structure

medical_inventory/
│
├── frontend/                  # UI pages and styling
│   ├── index.php              # Homepage / Login page
│   ├── dashboard.php          # Admin dashboard
│   ├── medicines.php          # Medicine listing page
│   ├── add_medicine.php       # Add new medicine
│   ├── edit_medicine.php      # Edit medicine details
│   ├── suppliers.php          # Supplier management page
│   ├── stock.php              # Stock tracking page
│   ├── orders.php             # Orders and sales page
│   └── staff_dashboard.php    # Pharmacist/Staff dashboard
│
├── backend/                   # PHP logic and database operations
│   ├── config.php             # Database connection
│   ├── medicines.php          # Medicine CRUD logic
│   ├── suppliers.php          # Supplier management logic
│   ├── stock.php              # Stock management logic
│   ├── orders.php             # Orders and sales logic
│   └── auth.php               # Login and authentication logic
│
└── README.md

## Admin Panel

| Section     | Functionality                                              |
|-------------|------------------------------------------------------------|
| Dashboard   | Overview of total medicines, stock levels and sales        |
| Medicines   | Add, edit, and delete medicine records                     |
| Suppliers   | Add and manage supplier details                            |
| Stock       | Track stock availability and monitor stock-in history      |
| Orders      | View and manage all orders and sales records               |


## Future Improvements

- Low stock alerts and notifications
- Sales and revenue reports with charts
- Search and filter functionality for medicines
- Email notifications for low stock and orders
- Patient/customer login portal
- Live server deployment


## Author

Apoorva
BCA Student | Full Stack Developer

GitHub: [apoorva01-ch](https://github.com/apoorva01-ch)
