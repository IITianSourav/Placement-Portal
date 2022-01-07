<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome student</title>
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<frameset rows="20%,70%">
  <frame name = "header" src = "header.php">
<frameset cols="25%,75%">
  <frame name = "left" src = "student_left.html">
  <frame name = "right" src = "aboutus.html" style="padding:0px;">
  </frameset>
  </frameset>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?>
    </b>. Welcome to the portal.</h1>
    <p>
        <a href="reset-password.php">Reset Your Password</a>
        <a href="logout.php">Sign Out of Your Account</a>
    </p>
</body>
</html>
