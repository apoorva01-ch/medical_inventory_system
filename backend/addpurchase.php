<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: loginpg.php");
    exit();
}
$host = "localhost";
$uname = "root";
$pwd   = "";
$dbname = "medical_inventory";

$conn = mysqli_connect("localhost","root","","medical_inventory");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* AUTO GENERATE PURCHASE ID */
$result = mysqli_query($conn, "SELECT id FROM stockin ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);

$next_id = $row ? $row['id'] + 1 : 1;
$purchase_id = "PUR-" . str_pad($next_id, 4, "0", STR_PAD_LEFT);

/* AUTO GENERATE BATCH NUMBER */
$batch_number = "BATCH". "-" . rand(1000, 9999);

/* INSERT DATA */
if(isset($_POST['submit'])){

    $medicine_name = $_POST['medicine_name'];
    $supplier = $_POST['supplier'];
    $expiry_date = $_POST['expiry_date'];
    $quantity = $_POST['quantity'];
    $purchase_price = $_POST['purchase_price'];

    $insert = "INSERT INTO stockin
    (purchase_id, medicine_name, supplier, batch_number, expiry_date, quantity, purchase_price)
    VALUES
    ('$purchase_id','$medicine_name','$supplier','$batch_number','$expiry_date','$quantity','$purchase_price')";

    if(mysqli_query($conn,$insert)){
        header("Location: stockin.php");
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
<title>Add Purchase</title>

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
.sidebar a:hover {
    background: rgba(255,255,255,0.18);
    color: white;
    border-left: 4px solid #a7ffeb;
}
.content-area {
    padding: 30px;
}
.custom-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 28px;
    border: 1px solid rgba(44, 83, 82, 0.25);
}
.head {
    color: #2c5352;
}
.btn-primary {
    background: linear-gradient(to right, #2c5352, #497379);
    border: none;
}
</style>
</head>

<body>

<div class="top-border"></div>

<div class="top-navbar">
    <i class="bi bi-hospital"></i> Medical Inventory Management System
</div>

<div class="container-fluid">
<div class="row">

<div class="col-md-2 sidebar p-0">
    <a href="medicine.php">Medicines</a>
    <a href="supplier.php">Suppliers</a>
    <a href="stockin.php">Stock In</a>
    <a href="sales.php">Sales</a>
    <a href="viewstock.php">View Stock</a>
</div>

<div class="col-md-10 content-area">

<h3 class="head mb-4">Add New Purchase</h3>

<div class="custom-card">
<form method="POST">

<div class="row mb-3">
    <div class="col-md-6">
        <label>Batch Number</label>
        <input type="text" name="batch_number"
        value="<?php echo $batch_number; ?>"
        class="form-control" readonly>
    </div>
    <div class="col-md-6">
        <label>Medicine Name</label>
        <input type="text" name="medicine_name" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Supplier</label>
        <input type="text" name="supplier" class="form-control" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label>Expiry Date</label>
        <input type="date" name="expiry_date" class="form-control" required>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Purchase Price</label>
        <input type="number" name="purchase_price" class="form-control" required>
    </div>
</div>

<button type="submit" name="submit" class="btn btn-primary">
    <i class="bi bi-save"></i> Save Purchase
</button>

<a href="stockin.php" class="btn btn-secondary ms-2">Cancel</a>

</form>
</div>

</div>
</div>
</div>

</body>
</html>