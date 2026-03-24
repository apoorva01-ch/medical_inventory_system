<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: loginpg.php");
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

/* =========================
   DASHBOARD COUNTS
========================= */

// Total Medicines
$total_medicines = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM medicine")
)['total'] ?? 0;

// Total Batches
$total_batches = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM stockin")
)['total'] ?? 0;

// Low Stock (quantity < 10)
$low_stock = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM stockin WHERE quantity < 10")
)['total'] ?? 0;

// Expired Medicines
$expired = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM stockin WHERE expiry_date < CURDATE()")
)['total'] ?? 0;

// In Stock Quantity (sum)
$in_stock = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(quantity) AS total FROM stockin WHERE quantity > 0")
)['total'] ?? 0;


/* =========================
   CATEGORY WISE STOCK
========================= */

$category_query = mysqli_query($conn, "
    SELECT 
        IFNULL(m.category,'Tablet') as category, 
        SUM(s.quantity) as total_qty
    FROM stockin s
    LEFT JOIN medicine m 
    ON TRIM(LOWER(s.medicine_name)) = TRIM(LOWER(m.medicine_name))
    GROUP BY m.category
");
if(!$category_query){
    die("SQL Error: " . mysqli_error($conn));
}

$categories = [];
$category_data = [];

while($row = mysqli_fetch_assoc($category_query)){
    $categories[] = $row['category'];
    $category_data[] = $row['total_qty'];
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Medical Inventory Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(to right,#e0f7f6,#f4f9f9);
}
.sidebar{
    min-height:100vh;
    background:#2c5352;
}
.sidebar a{
    color:white;
    padding:12px 20px;
    display:block;
    text-decoration:none;
}
.sidebar a:hover{
    background:rgba(255,255,255,0.2);
}
.dashboard-card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    display:flex;
    justify-content:space-between;
    align-items:center;
}
canvas{
    max-width:300px;
    margin:auto;
}
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<div class="col-md-2 sidebar p-0">
    <a href="medicine.php">Medicines</a>
    <a href="supplier.php">Suppliers</a>
    <a href="stockin.php">Stock In</a>
    <a href="sales.php">Sales</a>
    <a href="viewstock.php">View Stock</a>
</div>

<div class="col-md-10 p-4">

<h2 class="mb-4">Dashboard</h2>

<div class="row g-4 mb-4">

<div class="col-md-4">
<div class="dashboard-card">
<div>
<h6>Total Medicines</h6>
<h3 class="text-primary"><?php echo $total_medicines; ?></h3>
</div>
<i class="bi bi-capsule fs-2 text-primary"></i>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div>
<h6>Total Batches</h6>
<h3 class="text-secondary"><?php echo $total_batches; ?></h3>
</div>
<i class="bi bi-box-seam fs-2 text-secondary"></i>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div>
<h6>Low Stock</h6>
<h3 class="text-warning"><?php echo $low_stock; ?></h3>
</div>
<i class="bi bi-exclamation-triangle fs-2 text-warning"></i>
</div>
</div>

</div>

<div class="row g-4 mb-4">

<div class="col-md-6">
<div class="dashboard-card">
<div>
<h6>Expired Medicines</h6>
<h3 class="text-danger"><?php echo $expired; ?></h3>
</div>
<i class="bi bi-x-circle fs-2 text-danger"></i>
</div>
</div>

<div class="col-md-6">
<div class="dashboard-card">
<div>
<h6>Total In Stock Quantity</h6>
<h3 class="text-success"><?php echo $in_stock; ?></h3>
</div>
<i class="bi bi-check-circle fs-2 text-success"></i>
</div>
</div>

</div>

<div class="row g-4">

<div class="col-md-6">
<div class="card p-3 text-center">
<h5>Category Stock Overview</h5>
<canvas id="pieChart1"></canvas>
</div>
</div>

<div class="col-md-6">
<div class="card p-3 text-center">
<h5>Stock Status</h5>
<canvas id="pieChart2"></canvas>
</div>
</div>

</div>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/* CATEGORY CHART */

new Chart(document.getElementById('pieChart1'),{
    type:'pie',
    data:{
        labels: <?php echo json_encode($categories); ?>,
        datasets:[{
            data: <?php echo json_encode($category_data); ?>,
            backgroundColor:['#0d6efd','#ffc107','#198754','#dc3545','#6f42c1','#20c997']
        }]
    }
});

/* STOCK STATUS CHART */

new Chart(document.getElementById('pieChart2'),{
    type:'doughnut',
    data:{
        labels:['In Stock','Expired','Low Stock'],
        datasets:[{
            data:[
                <?php echo $in_stock; ?>,
                <?php echo $expired; ?>,
                <?php echo $low_stock; ?>
            ],
            backgroundColor:['#198754','#dc3545','#ffc107']
        }]
    }
});

</script>

</body>
</html>