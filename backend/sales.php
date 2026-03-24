<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: loginpg.php");
    exit();
}
$host = "localhost";
$uname = "root";
$pwd = "";
$db = "medical_inventory";

$conn = mysqli_connect($host, $uname, $pwd, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$query = "SELECT * FROM addsale";
$data = mysqli_query($conn, $query);

if (!$data) {
    die("Query Failed: " . mysqli_error($conn));
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

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        .container-fluid {
    min-height: 100vh;
}
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

        .btn {
            border-radius: 8px;
        }

        .btn-primary {
            background: linear-gradient(to right, #2c5352, #497379);
            border: none;
        }

        .btn-danger {
            background-color: #b02a37;
        }

        .page-link {
            border-radius: 8px;
            margin: 0 4px;
            color: #2c5352;
        }

        .page-item.active .page-link {
            background-color: #2c5352;
            border-color: #2c5352;
            color: white;
        }

        .head {
            color: black;
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
        a{
    text-decoration: none;
    color: #3f6f73;
}
@media print {
    .sidebar,
    .top-navbar,
    .top-border,
    .btn,
    .sales-search-box {
        display: none !important;
    }

    .content-area {
        padding: 0;
    }

    body {
        background: white;
    }
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
        <button class="logout-btn ms-3"><a href="loginpg.php" style="color:#2c5352;text-decoration: none;">Logout</a></button>
    </div>
</div>

<div class="container-fluid">
<div class="row">

<div class="col-md-2 sidebar p-0">
            <a href="medicine.php" class="active"><i class="bi bi-capsule me-2"></i> Medicines</a>
            <a href="supplier.php"><i class="bi bi-truck me-2"></i>Suppliers</a> 
            <a href="stockin.php"><i class="bi bi-box-arrow-in-down me-2"></i> Stock In</a>
            <a href="sales.php"><i class="bi bi-cart me-2"></i> Sales</a>
            <a href="Viewstock.php"><i class="bi bi-box-seam me-2"></i> View Stock</a>
</div>

<div class="col-md-10 content-area">

<button class="btn btn-primary mb-3">
    <i class="bi bi-plus-lg"></i><a href="addsale.php" style="color: white;text-decoration: none;">New Sale</a> 
</button>

<button class="btn btn-primary mb-3">
    <i class="bi bi-clock-history"></i> <a href="saleshistory.php" style="color: white;text-decoration: none;">Sales History</a>
</button>

<div class="custom-card">

<h4 class="mb-3 head">Sales List</h4>

<div class="sales-search-box">
<div class="sales-search-row">
    <input type="text" class="sales-input small" placeholder="From Date">
    <input type="text" class="sales-input small" placeholder="To Date">
    <input type="text" class="sales-input large" placeholder="Invoice Number">
    <button class="sales-search-btn">Search</button>
</div>
</div>

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
if(mysqli_num_rows($data) > 0){

    while($row = mysqli_fetch_assoc($data)){

        $sale_id = $row['id'];              // correct
        $invoice = $row['invoice_no'];
        $customer = $row['customer_name'];
        $date = $row['sale_date'];
        $status = $row['payment_status'];
        $total = $row['total'];             // correct
?>
<tr>
    <td><?php echo $sale_id; ?></td>
    <td><?php echo $invoice; ?></td>
    <td><?php echo $customer; ?></td>
    <td><?php echo $date; ?></td>
    <td><?php echo $total; ?></td>

    <td>
        <?php
        if($status == "Paid"){
            echo "<button class='btn btn-sm btn-success'>Paid</button>";
        } elseif($status == "Pending"){
            echo "<button class='btn btn-sm btn-warning'>Pending</button>";
        } else {
            echo "<button class='btn btn-sm btn-info'>Partial</button>";
        }
        ?>
    </td>

    <td>
        <a href='invoice.php?invoice=<?php echo $invoice; ?>' 
           class='btn btn-sm btn-primary'>
           Open Bill
        </a>
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