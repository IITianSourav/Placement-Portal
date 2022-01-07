<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: company_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome_Company</title>
</head>
<frameset rows="20%,70%">
  <frame name = "header" src = "header.php">
<frameset cols="25%,75%">
  <frame name = "left" src = "company_left.html">
  <frame name = "right" src = "company_right.php" style="padding:0px;">
  </frameset>
  </frameset>
<body>
    <h1 >Hi, <b><?php echo $_SESSION["username"]; ?>
    </b>. Welcome to the portal.</h1>
    <p >
        <a href="company_reset_password.php" class="btn btn-warning">Reset Password</a>
        <a href="company_logout.php" class="btn btn-danger ml-3">Log Out</a>
    </p>
    <h2> Welcome, <?php echo $_SESSION["username"]; ?></h2>
</body>
</html>
