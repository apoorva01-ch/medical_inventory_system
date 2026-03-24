<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: loginpg.php");
    exit();
}
$host = "localhost";
$uname = "root";
$pwd = "";
$dbname = "medical_inventory";

$conn = mysqli_connect($host, $uname, $pwd, $dbname);

if (!$conn) {
    die("Connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $supplier_name = $_POST["supplier_name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    $sql = "INSERT INTO supplier(supplier_name, phone, email)
            VALUES ('$supplier_name', '$phone', '$email')";

    if (mysqli_query($conn, $sql)) {
        header("Location: supplier.php");
        exit();
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Supplier Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* YOUR ENTIRE ORIGINAL CSS — unchanged */
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #e0f7f6, #f4f9f9);
}
.top-border {
    height: 6px;
    background: linear-gradient(to right, #2c5352, #497379, #6fb1a0);
}
.top-navbar {
    background: linear-gradient(to right, #2c5352, #497379);
    color: white;
    padding: 15px 25px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}
.top-navbar .brand {
    font-weight: 600;
    font-size: 20px;
}
.logout-btn {
    background: white;
    color: #2c5352;
    border-radius: 8px;
    border: none;
    padding: 6px 14px;
    font-weight: 500;
}
.sidebar {
height: 100vh;
background: linear-gradient(to bottom, #2c5352, #3f6f73);
padding-top: 20px;
}
.sidebar a {
    color: #e0f2f1;
    padding: 12px 20px;
    display: block;
    text-decoration: none;
}
.sidebar a:hover,
.sidebar a.active {
    background: rgba(255,255,255,0.18);
    color: white;
    border-left: 4px solid #a7ffeb;
}
.main-content {
    background-color: #f4f6f9;
    min-height: 100vh;
}
.supplier-card {
    border-radius: 10px;
    background: #fff;
}
.custom-input {
    height: 45px;
    padding-left: 40px;
    border-radius: 6px;
}
.input-icon {
    position: absolute;
    top: 38px;
    left: 12px;
    color: #9aa0a6;
}
</style>
</head>

<body>

<div class="top-border"></div>

<div class="top-navbar d-flex justify-content-between align-items-center">
    <div class="brand">
        <i class="bi bi-hospital"></i> Medical Inventory Management System
    </div>
    <div>
        Welcome, Admin
        <button class="logout-btn ms-3">
            <a href="loginpg.php" style="text-decoration:none;color:#2c5352;">Logout</a>
        </button>
    </div>
</div>

<div class="container-fluid">
<div class="row">

<div class="col-md-2 sidebar p-0">
    <a href="medicine.php"><i class="bi bi-capsule me-2"></i>Medicines</a>
    <a href="supplier.php" class="active"><i class="bi bi-truck me-2"></i>Suppliers</a>
    <a href="stockin.php"><i class="bi bi-box-arrow-in-down me-2"></i>Stock In</a>
    <a href="sales.php"><i class="bi bi-cart me-2"></i>Sales</a>
    <a href="viewstock.php"><i class="bi bi-box-seam me-2"></i>View Stock</a>
</div>

<div class="col-md-10 p-4 main-content">

<h3 class="mb-4 fw-semibold">Supplier Management</h3>

<div class="card shadow-sm p-4 supplier-card">
<h5 class="mb-4 fw-semibold">Add Supplier</h5>

<form method="POST">

<div class="mb-3 position-relative">
    <label class="form-label fw-semibold">Supplier Name</label>
    <i class="bi bi-person input-icon"></i>
    <input type="text" name="supplier_name" class="form-control custom-input" placeholder="Supplier Name" required>
</div>

<div class="mb-3 position-relative">
    <label class="form-label fw-semibold">Phone</label>
    <i class="bi bi-telephone input-icon"></i>
    <input type="text" name="phone" class="form-control custom-input" placeholder="Phone" required>
</div>

<div class="mb-4 position-relative">
    <label class="form-label fw-semibold">Email</label>
    <i class="bi bi-envelope input-icon"></i>
    <input type="email" name="email" class="form-control custom-input" placeholder="Email" required>
</div>

<button type="submit" class="btn px-4" style="background-color:#2c5352;color:white;">
    Save
</button>

</form>

</div>
</div>

</div>
</div>

</body>
</html>