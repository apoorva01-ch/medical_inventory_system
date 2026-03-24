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

if(isset($_POST['save_sale'])){

    $invoiceno = $_POST['invoice_no'];
    $saledate = $_POST['sale_date'];
    $paymentstatus = $_POST['payment_status'];
    $customername = $_POST['customer_name'];

    for($i = 0; $i < count($_POST['medicine']); $i++){

        $medicine = $_POST['medicine'][$i];
        $price = floatval($_POST['price'][$i]);
        $qty = intval($_POST['qty'][$i]);
        $total = $price * $qty;

        if($medicine != ""){

           $query = "INSERT INTO addsale
(invoice_no, sale_date, payment_status, customer_name, medicine, price, quantity, total)
VALUES 
('$invoiceno', '$saledate', '$paymentstatus', '$customername', '$medicine', '$price', '$qty', '$total')";

$result = mysqli_query($conn, $query);

if(!$result){
    die("Insert Error: " . mysqli_error($conn));
}
        }
    }

    header("Location: sales.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Sale</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f9f9;
    padding:30px;
}
.card{
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}
@media print{
    .no-print{
        display:none;
    }
    body{
        background:white;
    }
}
</style>
</head>

<body>
<form method="POST">
<div class="container">

<div class="card p-4">

<h4 class="mb-4">New Sale</h4>

<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label">Invoice No</label>
        <input type="text" id="invoice_no" name="invoice_no" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Sale Date</label>
        <input type="date" id="sale_date" name="sale_date" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Payment Status</label>
        <select class="form-control" name="payment_status">
            <option>Paid</option>
            <option>Pending</option>
            <option>Partial</option>
        </select>
    </div>
</div>

<div class="mb-4">
    <label class="form-label">Customer Name</label>
    <input type="text" name="customer_name" class="form-control" placeholder="Enter customer name">
</div>

<table class="table table-bordered" id="medicineTable">
    <thead class="table-light">
        <tr>
            <th>Medicine</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th class="no-print">Action</th>  
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="text" name="medicine[]" class="form-control"></td>
            <td><input type="number" name="price[]" class="form-control price" oninput="calculate(this)"></td>
            <td><input type="number" name="qty[]" class="form-control qty" oninput="calculate(this)"></td>
            <td><input type="number" class="form-control total" readonly></td>
            <td class="no-print">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
            </td>
        </tr>
    </tbody>
</table>

<button type="button" class="btn btn-secondary no-print mb-3" onclick="addRow()">+ Add Medicine</button>

<div class="text-end">
    <h5>Grand Total: ₹ <span id="grandTotal">0</span></h5>
</div>

<div class="text-end mt-4 no-print">
    <button type="submit" name="save_sale" class="btn btn-primary">
        Save Sale
    </button>
    <button type="button" onclick="window.print()" class="btn btn-success">Print Invoice</button>
</div>

</div>
</form>
</div>

<script>
    document.querySelector("form").addEventListener("submit", function() {

    document.querySelectorAll("#medicineTable tbody tr").forEach(function(row){

        let priceInput = row.querySelector(".price");
        let qtyInput = row.querySelector(".qty");

        let price = parseFloat(priceInput.value) || 0;
        let qty = parseInt(qtyInput.value) || 0;

        priceInput.value = price;
        qtyInput.value = qty;

    });

});
function generateInvoice(){
    const random = Math.floor(Math.random() * 100000);
    document.getElementById("invoice_no").value = "INV-" + random;
}
generateInvoice();

document.getElementById("sale_date").value = new Date().toISOString().split('T')[0];

function addRow(){
    const table = document.getElementById("medicineTable").getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();

    newRow.innerHTML = `
        <td><input type="text" name="medicine[]" class="form-control"></td>
        <td><input type="number" name="price[]" class="form-control price" oninput="calculate(this)"></td>
        <td><input type="number" name="qty[]" class="form-control qty" oninput="calculate(this)"></td>
        <td><input type="number" class="form-control total" readonly></td>
        <td class="no-print">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
        </td>
    `;
}

function removeRow(btn){
    btn.closest("tr").remove();
    updateGrandTotal();
}

function calculate(element){
    const row = element.closest("tr");
    const price = row.querySelector(".price").value || 0;
    const qty = row.querySelector(".qty").value || 0;
    const total = price * qty;
    row.querySelector(".total").value = total;
    updateGrandTotal();
}

function updateGrandTotal(){
    let grandTotal = 0;
    const totals = document.querySelectorAll(".total");
    totals.forEach(input=>{
        grandTotal += parseFloat(input.value) || 0;
    });
    document.getElementById("grandTotal").innerText = grandTotal;
}
</script>

</body>
</html>