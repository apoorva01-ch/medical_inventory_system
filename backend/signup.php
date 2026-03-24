<?php 
$host = "localhost";
$uname = "root";
$pwd = "";
$dbname = "medical_inventory";

$conn = mysqli_connect($host, $uname, $pwd, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert query
    $sql = "INSERT INTO signup(fullname, username, email, password) 
            VALUES ('$fullname', '$username', '$email', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Signup Successful'); window.location='loginpg.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - Medical Inventory</title>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Roboto',sans-serif;
    min-height:100vh;
    padding:20px 0;              /* ⬅ reduced top/bottom space */
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    background:url('loginbg.jpg') no-repeat center center/cover;
    position:relative;
}

/* Overlay */
body::before{
    content:'';
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.4);
    z-index:1;
}

/* HEADER */
.header{
    position:relative;
    z-index:2;
    text-align:center;
    margin-bottom:18px;          /* ⬅ compact */
}

.header img{
    width:180px;
}

.header h1{
    font-family:'Montserrat',sans-serif;
    font-size:30px;
    color:#bcd3d2;
    margin-top:-26px;
}

/* SIGN UP CARD */
.container{
    position:relative;
    z-index:2;
    width:511px;
    padding:42px 45px;
    border-radius:14px;
    text-align:center;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);
    box-shadow:0 22px 45px rgba(0,0,0,0.35);
}

/* TITLE */
.container h2{
    font-family:'Montserrat',sans-serif;
    color:#fff;
    font-size:26px;
    margin-bottom:22px;
}

/* INPUTS */
.input-group{
    margin-bottom:16px;
    text-align:left;
}

.input-group label{
    color:#fff;
    font-size:14px;
}

.input-group input{
    width:100%;
    padding:12px;
    margin-top:5px;
    border-radius:6px;
    border:none;
    outline:none;
    font-size:14px;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:6px;
    background:#234241;
    color:#fff;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    margin-top:8px;
}

button:hover{
    background:#0f2d2c;
}

/* SWITCH */
.switch{
    margin-top:14px;
    color:#fff;
    font-size:14px;
}

.switch a{
    color:#144d58;
    text-decoration:none;
}

/* RESPONSIVE */
@media(max-width:650px){
    body{
        padding:15px 0;
    }

    .container{
        width:92%;
        padding:35px 28px;
    }

    .header h1{
        font-size:22px;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <img src="logo.png" alt="Logo">
    <h1>Medical Inventory Management System</h1>
</div>

<!-- SIGN UP CARD -->
<div class="container">
    <h2>Create Account</h2>

    <form method="POST">
        <div class="input-group">
            <label>Full Name</label>
            <input type="text" placeholder="Enter your full name" required name="fullname">
        </div>

        <div class="input-group">
            <label>Username</label>
            <input type="text" placeholder="Create username" required name="username">
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" placeholder="Enter your email" required name="email">
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" placeholder="Create password" required name="password">
        </div>

        <button type="submit" name="submit">Sign Up</button>
    </form>

    <div class="switch">
        Already have an account? <a href="loginpg.php">Login</a>
    </div>
</div>

</body>
</html>