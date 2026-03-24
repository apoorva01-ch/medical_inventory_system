<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:loginpg.php");
    exit();
}
$host = "localhost";
$uname = "root";
$pwd = "";
$db = "medical_inventory";

$conn = mysqli_connect($host, $uname, $pwd, $db);

if (!$conn) {
    die("Connection failed");
}

/* Total Purchases */
$countQuery = "SELECT COUNT(*) AS total_purchase FROM stockin";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalPurchase = $countRow['total_purchase'];

/* Total Amount */
$sumQuery = "SELECT SUM(quantity * purchase_price) AS total_amount FROM stockin";
$sumResult = mysqli_query($conn, $sumQuery);
$sumRow = mysqli_fetch_assoc($sumResult);
$totalAmount = $sumRow['total_amount'];

/* Table Data */
$tableQuery = "SELECT * FROM stockin ORDER BY id DESC";
$data = mysqli_query($conn, $tableQuery);

if (!$data) {
    die("Table Query Failed: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Purchase History</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #e0f7f6, #f4f9f9);
}

/* Navbar */
.top-navbar {
    background: linear-gradient(to right, #2c5352, #497379);
    color: white;
    padding: 15px 25px;
}


.logout-btn {
    background: white;
    color: #2c5352;
    border-radius: 8px;
    border: none;
    padding: 6px 14px;
    font-weight: 500;
    text-decoration: none;
}

.logout-btn:hover {
    background: #e6f2f1;
}

/* Sidebar */
.sidebar {
    height: 100vh;
    background: linear-gradient(to bottom, #2c5352, #3f6f73);
    padding-top: 20px;
     flex: 0 0 220px;   /* fixed width */
    position: sticky;
    top: 0;
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
    border-left: 4px solid #a7ffeb;
}

/* Content */
.content-area {
    padding: 30px;
        flex: 1;
    padding: 30px;
    overflow-x: auto;  /* horizontal scroll if table too wide */

}

.custom-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

/* Summary cards */
.summary-card {
    border-radius: 14px;
    padding: 20px;
    background: #ffffff;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
}

.summary-card h5 {
    font-size: 14px;
    color: #666;
}

.summary-card h3 {
    margin: 0;
    font-weight: 600;
}

.paid { color: #dc3545; }
.blue-text {
    color: #28a745;
}


/* Status badges */
.badge-paid { background: #28a745; }
.badge-pending { background: #f39c12; }
.badge-partial { background: #0d6efd; }

/* Table */
.table th {
    background: #f1f5f4;
}

.btn-primary {
    background: linear-gradient(to right, #2c5352, #497379);
    border: none;
}

.page-link {
    color: #2c5352;
}
</style>
</head>

<body>

<!-- Navbar -->
<div class="top-navbar d-flex justify-content-between align-items-center">
    <div>
        <i class="bi bi-hospital"></i> Medical Inventory Management System
    </div>
    <div>
        Welcome, Admin
        <a href="loginpg.php" class="logout-btn ms-3">Logout</a>
    </div>
</div>

<div class="container-fluid">
<div class="row">

<!-- Sidebar -->
<div class="col-md-2 sidebar">
            <a href="medicine.php" class="active"><i class="bi bi-capsule me-2"></i> Medicines</a>
            <a href="supplier.php"><i class="bi bi-truck me-2"></i>Suppliers</a> 
            <a href="stockin.php"><i class="bi bi-box-arrow-in-down me-2"></i> Stock In</a>
            <a href="sales.php"><i class="bi bi-cart me-2"></i> Sales</a>
            <a href="viewstock.php"><i class="bi bi-box-seam me-2"></i> View Stock</a>
</div>

<!-- Content -->
<div class="col-md-10 content-area">

<h3 class="mb-4">Purchase History Page</h3>

<!-- Summary Row -->
<div class="row mb-4">

    <div class="col-md-6">
        <div class="summary-card">
            <h5>Total Purchases</h5>
            <h3 class="blue-text"><?php echo $totalPurchase; ?></h3>
        </div>
    </div>

    <div class="col-md-6">
        <div class="summary-card">
            <h5>Total Purchase Amount</h5>
            <h3 class="paid">₹ <?php echo $totalAmount ? $totalAmount : 0; ?></h3>
        </div>
    </div>

</div>

<div class="custom-card">

<div class="d-flex justify-content-between mb-3">
    <h5>Purchase History</h5>
    <div class="d-flex">
        <input type="text" class="form-control me-2" placeholder="Invoice Number">
        <button class="btn btn-primary">Search</button>
    </div>
</div>

<div class="table-responsive">
<table class="table table-bordered align-middle">
<thead>
<tr>
    <th>ID</th>
    <th>Medicine</th>
    <th>Supplier</th>
    <th>Batch No</th>
    <th>Expiry Date</th>
    <th>Quantity</th>
    <th>Purchase Price</th>
    <th>Total Amount</th>
</tr>
</thead>

<tbody>
<?php
if(mysqli_num_rows($data) > 0){
    while($row = mysqli_fetch_assoc($data)){
        $total = $row['quantity'] * $row['purchase_price'];
?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['medicine_name']; ?></td>
    <td><?php echo $row['supplier']; ?></td>
    <td><?php echo $row['batch_number']; ?></td>
    <td><?php echo $row['expiry_date']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td>₹ <?php echo $row['purchase_price']; ?></td>
    <td><strong>₹ <?php echo $total; ?></strong></td>
</tr>
<?php
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No Purchase Found</td></tr>";
}
?>
</tbody>
</table>
</div>


<!-- Back Button -->
<div class="text-end mt-3">
    <a href="stockin.php" class="btn btn-secondary" style="background-color: #3f6f73;">
        <i class="bi bi-arrow-left"></i> Back to Table
    </a>
</div>
</div>

</div>
</div>
</div>

</body>
</html>