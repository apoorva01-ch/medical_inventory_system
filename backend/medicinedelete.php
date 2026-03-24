<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: loginpg.php");
    exit();
}
$conn = mysqli_connect("localhost","root","","medical_inventory");
if(!$conn){
    die("Database Error: " . mysqli_connect_error());
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']); // sanitize input
    mysqli_query($conn, "DELETE FROM medicine WHERE id = $id");
}

header("Location: medicine.php");
exit;
?>