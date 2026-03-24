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
    $id            = intval($_POST['id']);
    $supplier_name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
    $phone         = mysqli_real_escape_string($conn, $_POST['phone']);
    $email         = mysqli_real_escape_string($conn, $_POST['email']);

    $update = mysqli_query($conn,"UPDATE supplier SET
        supplier_name = '$supplier_name',
        phone         = '$phone',
        email         = '$email'
        WHERE id = $id
    ");

    if(!$update){
        die("Update Error: " . mysqli_error($conn));
    } else {
        header("Location: supplier.php");
        exit;
    }
}

/* =========================
   FETCH DATA
========================= */
if(!isset($_GET['id'])){
    die("Invalid Request");
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM supplier WHERE id = $id");

if(mysqli_num_rows($result) == 0){
    die("Record Not Found");
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<div class="container" style="margin-top:50px; width:50%;">
    <div class="panel panel-primary">
        <div class="panel-heading"><h4>Edit Supplier</h4></div>
        <div class="panel-body">
            <form method="post">

                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" name="supplier_name" class="form-control"
                    value="<?= $row['supplier_name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control"
                    value="<?= $row['phone']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                    value="<?= $row['email']; ?>" required>
                </div>

                <button type="submit" name="submit" class="btn btn-success">
                    Update Supplier
                </button>

                <a href="supplier.php" class="btn btn-default">
                    Cancel
                </a>

            </form>
        </div>
    </div>
</div>

</body>
</html>