<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:loginpg.php");
    exit();
}
$host = "localhost";
$username = "root";
$password = "";
$database = "medical_inventory";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Inventory Dashboard</title>


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

.logout-btn:hover {
    background: #e6f2f1;
}

/* Sidebar */
.sidebar {
height: 100vh;
 background: linear-gradient(to bottom, #2c5352, #3f6f73);
position: relative;
 padding-top: 20px;
}

.sidebar::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 2px;
    height: 100%;
    background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.4), transparent);
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
    background: rgba(255,255,255,0.18);
    color: white;
    border-left: 4px solid #a7ffeb;
}

.content-area {
    padding: 30px;
}

.custom-card {
    background: rgba(255, 255, 255, 0.92);
    border-radius: 16px;
    padding: 28px;
    border: 1px solid rgba(44, 83, 82, 0.25);
    box-shadow:
        0 12px 30px rgba(0,0,0,0.08),
        inset 0 1px 0 rgba(255,255,255,0.6);
    backdrop-filter: blur(8px);
}

/* Table */
.table {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(44, 83, 82, 0.25);
}

.table thead {
    background: linear-gradient(to right, #e3f3f2, #f1fafa);
}

.table th,
.table td {
    border-color: rgba(44, 83, 82, 0.15);
}

/* Buttons */
.btn {
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);
}

.btn-primary {
    background: linear-gradient(to right, #2c5352, #497379);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(to right, #1f3f3e, #355d60);
}

.btn-danger {
    background-color: #b02a37;
}

.btn-danger:hover {
    background-color: #842029;
}

/* Pagination */
.page-link {
    border-radius: 8px;
    margin: 0 4px;
    color: #2c5352;
    border: 1px solid rgba(44, 83, 82, 0.3);
}

.page-item.active .page-link {
    background-color: #2c5352;
    border-color: #2c5352;
    box-shadow: 0 6px 12px rgba(44,83,82,0.35);
}
a{
    color: #2c5352;
    text-decoration: none;
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
            <button class="logout-btn ms-3"> <a href="loginpg.php">Logout</a></button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-2 sidebar p-0">
                 <a href="medicine.php" class="active"><i class="bi bi-capsule me-2"></i>Medicines</a>
                <a href="supplier.php"><i class="bi bi-truck me-2"></i>Suppliers</a>
                <a href="stockin.php"><i class="bi bi-box-arrow-in-down me-2"></i>Stock In</a>
                <a href="sales.php"><i class="bi bi-cart me-2"></i>Sales</a>
                <a href="viewstock.php"><i class="bi bi-box-seam me-2"></i>View Stock</a>
            </div>

            <div class="col-md-10 content-area">

                <button class=" btn btn-primary mb-3">
                    <i class="bi bi-plus-lg"></i><a href="addsupplier.php" style="color: white;"> Add Supplier</a>
                </button>

                <div class="custom-card">
                    <h4 class="mb-4"> Supplier List</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th> Supplier Name</th>
                                    <th> Phone</th>
                                    <th> Email</th>
                                    <th> Edit</th>
                                    <th> Delete</th>
                                </tr>
                            </thead>
                            <tbody>

<?php
$sql = "SELECT * FROM supplier ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td><?php echo $row['supplier_name']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td>
        <a href="supplieredit.php?id=<?php echo $row['id']; ?>" 
           class="btn btn-sm btn-primary">Edit</a>
    </td>
    <td>
        <a href="supplierdelete.php?id=<?php echo $row['id']; ?>" 
           class="btn btn-sm btn-danger">Delete</a>
    </td>
</tr>

<?php } ?>

</tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>