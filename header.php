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
<html>
  <head>
    <title>heading</title>
    <link rel="stylesheet" href="style_table.css">
  </head>
  <body>
    <div class="header">
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?>
      </b>. Welcome to the portal.</h1>
      <p>
          <a href="reset-password.php" position="right">Reset Your Password</a>
          <a href="logout.php" position="right">Sign Out of Your Account</a>
      </p>
      <div id="logo"> 
      <img src="IIT_Guwahati_Logo.jpg" height="150" width="150"> 
</div>
    </div>
  </body>
</html>
