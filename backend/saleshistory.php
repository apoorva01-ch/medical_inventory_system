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

// Fetch grouped invoice data
$query = "SELECT 
            invoice_no,
            customer_name,
            sale_date,
            payment_status,
            SUM(total) as grandtotal
          FROM addsale
          GROUP BY invoice_no
    ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>
    
    

    
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales History</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

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
    min-height: 100vh;
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
    background: rgba(255, 255, 255, 0.92);
    border-radius: 16px;
    padding: 28px;
    border: 1px solid rgba(44, 83, 82, 0.25);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
}

.table {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(44, 83, 82, 0.25);
}

.table thead {
    background: linear-gradient(to right, #e3f3f2, #f1fafa);
}

.head {
    color: #2c5352;
}

.sales-search-box {
    background: #f1f1f1;
    padding: 16px;
    margin-bottom: 20px;
    border-radius: 6px;
}

.sales-search-row {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.sales-input {
    height: 45px;
    border: 1px solid #cfcfcf;
    padding: 0 12px;
    font-size: 14px;
    background: #fff;
    border-radius: 4px;
}

.sales-input.small { flex: 1; }
.sales-input.large { flex: 1.5; }

.sales-search-btn {
    height: 45px;
    padding: 0 30px;
    background: #2c5352;
    color: #fff;
    border: none;
    border-radius: 6px;
}

/* Status Colors */
.status-paid {
    background: #198754;
    color: white;
}

.status-pending {
    background: #ffc107;
}

.status-partial {
    background: #0dcaf0;
    color: white;
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
        <button class="logout-btn ms-3"><a href="loginpg.php" style="text-decoration: none;">Logout</a></button>
    </div>
</div>

<div class="container-fluid">
<div class="row">

<!-- Sidebar -->
<div class="col-md-2 sidebar p-0">
    
            <a href="medicine.php" class="active"><i class="bi bi-capsule me-2"></i> Medicines</a>
            <a href="supplier.php"><i class="bi bi-truck me-2"></i>Suppliers</a> 
            <a href="stockin.php"><i class="bi bi-box-arrow-in-down me-2"></i> Stock In</a>
            <a href="sales.php"><i class="bi bi-cart me-2"></i> Sales</a>
            <a href="Viewstock.php"><i class="bi bi-box-seam me-2"></i> View Stock</a>
</div>

<!-- Content -->
<div class="col-md-10 content-area">

<h3 class="head">Sales History</h3>

<div class="custom-card">

<h4 class="mb-3 head">Sales History List</h4>

<!-- Filters -->
<div class="sales-search-box">
<div class="sales-search-row">
    <input type="date" class="sales-input small">
    <input type="date" class="sales-input small">
    <input type="text" class="sales-input large" placeholder="Invoice Number">
    <input type="text" class="sales-input large" placeholder="Customer">
    <button class="sales-search-btn">Search</button>
</div>
</div>

<!-- Table -->
<div class="table-responsive">
<table class="table table-bordered align-middle">

<thead>
<tr>
    <th>Sale ID</th>
    <th>Invoice NO</th>
    <th>Customer</th>
    <th>Date</th>
    <th>Total Amount</th>
    <th>Payment Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php
if(mysqli_num_rows($result) > 0){
    $sale_id = 1;
    while($row = mysqli_fetch_assoc($result)){
?>

<tr>
    <td><?php echo $sale_id++; ?></td>
    <td><?php echo $row['invoice_no']; ?></td>
    <td><?php echo $row['customer_name']; ?></td>
    <td><?php echo date("d-m-Y", strtotime($row['sale_date'])); ?></td>
    <td>₹<?php echo $row['grandtotal']; ?></td>

    <td>
        <?php
        if($row['payment_status'] == "Paid"){
            echo '<button class="btn btn-sm status-paid">Paid</button>';
        }
        elseif($row['payment_status'] == "Pending"){
            echo '<button class="btn btn-sm status-pending">Pending</button>';
        }
        else{
            echo '<button class="btn btn-sm status-partial">Partial</button>';
        }
        ?>
    </td>

    <td>
        <a href="invoice.php?invoice=<?php echo $row['invoice_no']; ?>" 
   class="btn btn-sm btn-primary">View</a>
    </td>
</tr>

<?php
    }
}else{
    echo "<tr><td colspan='7' class='text-center'>No Sales Found</td></tr>";
}
?>

</tbody>
</table>
</div>

</div>
</div>
</div>
</div>

</body>
</html>