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
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $medicine_name = $_POST["medicine_name"];
    $category = $_POST["category"];
    $purchase_price = $_POST["purchase_price"];
    $selling_price = $_POST["selling_price"];
    $quantity = $_POST["quantity"];
    $expiry_date = $_POST["expiry_date"];

    $sql = "INSERT INTO medicine 
            (medicine_name, category, purchase_price, selling_price, quantity, expiry_date)
            VALUES 
            ('$medicine_name','$category','$purchase_price','$selling_price','$quantity','$expiry_date')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: medicine.php"); // redirect to dashboard
        exit();
    } else {
        echo "Insert Failed: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine - Medical Inventory</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
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
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
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

        .logout-btn:hover {
            background: #e6f2f1;
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
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.18);
            color: white;
            border-left: 4px solid #a7ffeb;
        }

        .content-area {
            padding: 30px;
        }

        .custom-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 30px;
            border: 1px solid rgba(44, 83, 82, 0.25);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
        }

        .btn-primary {
            background: linear-gradient(to right, #2c5352, #497379);
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #1f3f3e, #355d60);
        }

        .btn-secondary {
            border-radius: 8px;
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
            <b>Welcome, Admin</b>
            <button class="logout-btn ms-3">
                <a href="loginpg.php" style="text-decoration:none;color:#2c5352;">Logout</a>
            </button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <a href="medicine.php"><i class="bi bi-capsule me-2"></i> Medicines</a>
                <a href="supplier.php"><i class="bi bi-truck me-2"></i> Suppliers</a>
                <a href="stockin.php"><i class="bi bi-box-arrow-in-down me-2"></i> Stock In</a>
                <a href="sales.php"><i class="bi bi-cart me-2"></i> Sales</a>
                <a href="viewstock.php"><i class="bi bi-box-seam me-2"></i> View Stock</a>
            </div>

            <!-- Content -->
            <div class="col-md-10 content-area">

                <div class="custom-card">
                    <h4 class="mb-4"><i class="bi bi-plus-circle me-2"></i>Add New Medicine</h4>

                    <form action="addmedicine.php" method="POST">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Medicine Name</label>
                                <input type="text" class="form-control" name="medicine_name" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category" required>
                                    <option value="">Select Category</option>
                                    <option>Tablet</option>
                                    <option>Capsule</option>
                                    <option>Syrup</option>
                                    <option>Injection</option>
                                    <option>Others</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Purchase Price (₹)</label>
                                <input type="number" class="form-control" name="purchase_price" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Selling Price (₹)</label>
                                <input type="number" class="form-control" name="selling_price" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expiry Date</label>
                                <input type="date" class="form-control" name="expiry_date" required>
                            </div>
                        </div>

                        <div class="mt-4">
                           <button type="submit" name="submit" class="btn btn-primary">
    <i class="bi bi-save me-1"></i> Save Medicine
</button>
                            <a href="medicine.php" class="btn btn-secondary ms-2">Cancel</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

</html>