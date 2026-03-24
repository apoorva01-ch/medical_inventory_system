<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: loginpg.php");
    exit();
}
$conn = mysqli_connect("localhost","root","","medical_inventory");

if(!$conn){
    die("Connection failed");
}

if(!isset($_GET['invoice'])){
    die("No Invoice Selected");
}

$invoice = $_GET['invoice'];

/* Fetch header data */
$sale_query = mysqli_query($conn,
    "SELECT invoice_no, sale_date, payment_status, customer_name
     FROM addsale
     WHERE invoice_no='$invoice'
     LIMIT 1");

$sale = mysqli_fetch_assoc($sale_query);

if(!$sale){
    die("Invoice Not Found");
}

/* Fetch items of this invoice only */
$item_query = mysqli_query($conn,
    "SELECT medicine, price, quantity, total
     FROM addsale
     WHERE invoice_no='$invoice'");

/* Calculate grand total */
$total_query = mysqli_query($conn,
    "SELECT SUM(total) as grand_total
     FROM addsale
     WHERE invoice_no='$invoice'");

$total_row = mysqli_fetch_assoc($total_query);
$grand_total = $total_row['grand_total'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f9f9;
    padding:40px;
}
.invoice-box{
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}
.invoice-header{
    border-bottom:2px solid #2c5352;
    padding-bottom:15px;
    margin-bottom:20px;
}
.invoice-title{
    color:#2c5352;
}
.table th{
    background:#e3f3f2;
}
@media print{
    button{
        display:none;
    }
    body{
        padding:0;
    }
}
</style>
</head>

<body>

<div class="container">
<div class="invoice-box">

<div class="row invoice-header">
    <div class="col-md-6">
        <h4 class="invoice-title">MEDISCAN</h4>
        <p>
            123 Main Street <br>
            City, India <br>
            Phone: 9876543210
        </p>
    </div>

    <div class="col-md-6 text-end">
        <h5><strong>INVOICE</strong></h5>
        <p>
            <strong>Invoice No:</strong> <?php echo $sale['invoice_no']; ?><br>
            <strong>Date:</strong> <?php echo date("d-m-Y", strtotime($sale['sale_date'])); ?><br>
            <strong>Status:</strong> <?php echo $sale['payment_status']; ?>
        </p>
    </div>
</div>

<h6><strong>Customer:</strong> <?php echo $sale['customer_name']; ?></h6>

<table class="table table-bordered mt-3">
<thead>
<tr>
    <th>Medicine</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Total</th>
</tr>
</thead>

<tbody>
<?php while($item = mysqli_fetch_assoc($item_query)) { ?>
<tr>
    <td><?php echo $item['medicine']; ?></td>
    <td><?php echo $item['quantity']; ?></td>
    <td>₹<?php echo $item['price']; ?></td>
    <td>₹<?php echo $item['total']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

<div class="text-end mt-3">
    <h5><strong>Grand Total: ₹<?php echo $grand_total; ?></strong></h5>
</div>

<div class="text-center mt-4">
    <button onclick="window.print()" class="btn btn-success">
        Print Invoice
    </button>
</div>

</div>
</div>

</body>
</html>