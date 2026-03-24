<?php 
session_start();

$host = "localhost";
$uname = "root";
$pwd = "";
$dbname ="medical_inventory";

$conn = mysqli_connect($host, $uname , $pwd , $dbname);

if(!$conn){
    die("Connection failed");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Get user from database
    $sql = "SELECT * FROM signup WHERE username=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) == 1){

        $row = mysqli_fetch_assoc($result);

        // Verify password
        if(password_verify($password, $row['password'])){

            $_SESSION["username"] = $username;
            header("Location: medicine.php");
            exit();

        } else {
            $error = "Wrong password!";
        }

    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Medical Inventory Management System - Login</title>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Roboto', sans-serif;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: url('loginbg.jpg') no-repeat center center/cover;
        position: relative;
        min-height: 100vh;   /* height → min-height */
    overflow-y: auto;
    }

    /* Overlay for readability */
    body::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color:  rgba(0,0,0,0.4);

        z-index: 1;
    }

    /* Header */
    .header {
        position: relative;
        z-index: 2;
        text-align: center;
        margin-bottom: 30px;
        color: #fff;
 
    }

    .header img {
        width: 200px;
        margin-bottom: 10px;
        animation: fadeInDown 1.2s ease forwards;
    }

    .header h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: 35px;
        font-weight: 700;
        letter-spacing: 1px;
        color: #bcd3d2;
        animation: fadeInDown 1.4s ease forwards;
        margin-top: -33px;
    }

    /* Login Container */
    .login-container {
        position: relative;
        z-index: 2;
        /* background-color:#67888991; */
        padding: 50px 40px;
        border-radius: 12px;
        width: 500px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        text-align: center;
        animation: fadeInUp 1s ease forwards;
        background: rgba(255,255,255,0.1);
backdrop-filter: blur(10px);

    }

    .login-container h2 {
        font-family: 'Montserrat', sans-serif;
        font-size: 30px;
        font-weight: 900;
        color: whitesmoke;
        margin-bottom: 30px;
        
    }

    .input-group {
        margin-bottom: 22px;
        text-align: left;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInInput 0.8s forwards;
    }

    .input-group:nth-child(1) { animation-delay: 1.2s; }
    .input-group:nth-child(2) { animation-delay: 1.4s; }

    .input-group label {
        display: block;
        font-size: 20px;
        color: whitesmoke;
        margin-bottom: 6px;
    }

    .input-group input {
        width: 100%;
        padding: 14px 12px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
        transition: border 0.3s, box-shadow 0.3s;
         
    }

    .input-group input:focus {
        border-color: #007BFF;
        box-shadow: 0 0 8px rgba(0,123,255,0.3);
         background-color: #f0f9fa; /* subtle light blue */
    color: #000;
    }

    button {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 6px;
        background:#234241 ;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInInput 0.8s forwards;
        animation-delay: 1.6s;
        

    }

    button:hover {
       background: #1f5e5d;

        transform: translateY(-2px);
    }
    .password-group {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 14px;
    color: #ccc;
    user-select: none;
    transition: color 0.2s;
}

.toggle-password:hover {
    color: #fff;
}


    @media(max-width: 500px) {
        .login-container {
            width: 90%;
            padding: 35px 25px;
        }

        .header h1 {
            font-size: 22px;
        }

        .login-container h2 {
            font-size: 22px;
        }
    }

    /* Animations  */
     @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInInput {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .switch{
    margin-top:15px;
    color:#fff;
    font-size:14px;
}

.switch a{
    color:#104e5a;
    text-decoration:none;
}
.btn {
  display: inline-block;
  padding: 10px 20px;
   width:100%;
    padding:12px;
    border:none;
    border-radius:6px;
    background:#234241;
    color:#fff;
    font-size:20px;
    font-weight:600;
    cursor:pointer;
    margin-top:8px;
    text-decoration: none;
}

</style>
</head>
<body>

<div class="header">
    <img src="logo.png" alt="Logo"> <!-- Replace with your logo -->
    <h1>Medical Inventory Management System</h1>
</div>

<div class="login-container">
    <h2>Login</h2>
   <form method="POST">
        <div class="input-group">
            <label>Username</label>
            <input type="text" placeholder="Enter your username" required name="username"  oninvalid="this.setCustomValidity('Please enter your username')" oninput="this.setCustomValidity('')">

        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" placeholder="Enter your password" required name="password" oninvalid="this.setCustomValidity('Please enter your password')" oninput="this.setCustomValidity('')">
            <span class="toggle-password">Show</span>
        </div>
     <button type="submit" class="btn">LOGIN</button>


        <div class="switch">
       <p>Don't have an account? <a href="signup.php">Sign up</a></p>

    </div>
    </form>
</div>
<script>
  document.querySelector('.toggle-password').addEventListener('click', function() {
    const input = document.querySelector('input[name="password"]');
    if (input.type === 'password') {
      input.type = 'text';
      this.textContent = 'Hide';
    } else {
      input.type = 'password';
      this.textContent = 'Show';
    }
  });
</script>


</body>
</html>
