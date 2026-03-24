<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: loginpg.php");
    exit();
}
$conn = mysqli_connect("localhost","root","","medical_inventory");
if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

/* =========================
   UPDATE DATA
========================= */
if(isset($_POST['submit'])){
    $id             = intval($_POST['id']); // use POST id from form
    $medicine_name  = mysqli_real_escape_string($conn, $_POST['medicine_name']);
    $category       = mysqli_real_escape_string($conn, $_POST['category']);
    $purchase_price = mysqli_real_escape_string($conn, $_POST['purchase_price']);
    $selling_price  = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $quantity       = mysqli_real_escape_string($conn, $_POST['quantity']);
    $expiry_date    = mysqli_real_escape_string($conn, $_POST['expiry_date']);

    $update = mysqli_query($conn,"UPDATE medicine SET
        medicine_name  = '$medicine_name',
        category       = '$category',
        purchase_price = '$purchase_price',
        selling_price  = '$selling_price',
        quantity       = '$quantity',
        expiry_date    = '$expiry_date'
        WHERE id = $id
    ");

    if(!$update){
        die("Update Error: " . mysqli_error($conn));
    } else {
        header("Location: medicine.php");
        exit;
    }
}

/* =========================
   FETCH DATA FOR FORM
========================= */
if(!isset($_GET['id'])){
    die("Invalid Request");
}
$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM medicine WHERE id = $id");
if(mysqli_num_rows($result) == 0){
    die("Record Not Found");
}
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Medicine</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<div class="container" style="margin-top:50px; width:50%;">
    <div class="panel panel-primary">
        <div class="panel-heading"><h4>Edit Medicine</h4></div>
        <div class="panel-body">
            <form method="post">
                <!-- Hidden ID -->
                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                <div class="form-group">
                    <label>Medicine Name</label>
                    <input type="text" name="medicine_name" class="form-control"
                    value="<?= $row['medicine_name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <option value="Tablet" <?= $row['category']=="Tablet"?"selected":""; ?>>Tablet</option>
                        <option value="Syrup" <?= $row['category']=="Syrup"?"selected":""; ?>>Syrup</option>
                        <option value="Injection" <?= $row['category']=="Injection"?"selected":""; ?>>Injection</option>
                        <option value="Capsule" <?= $row['category']=="Capsule"?"selected":""; ?>>Capsule</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Purchase Price</label>
                    <input type="number" step="0.01" name="purchase_price" class="form-control"
                    value="<?= $row['purchase_price']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Selling Price</label>
                    <input type="number" step="0.01" name="selling_price" class="form-control"
                    value="<?= $row['selling_price']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" class="form-control"
                    value="<?= $row['quantity']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="date" name="expiry_date" class="form-control"
                    value="<?= $row['expiry_date']; ?>" required>
                </div>

                <button type="submit" name="submit" class="btn btn-success">Update Medicine</button>
                <a href="medicine.php" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>