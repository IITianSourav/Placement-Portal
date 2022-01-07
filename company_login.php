<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Company Login</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
  <br><br><br><br>
  <div class="box1">
    <div id="logo">
    <img src="IIT_Guwahati_Logo.jpg" height="100" width="100">
</div>
<h3 class="header2">LOGIN</h3>
<p>Please enter your credentials to login.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Company ID: </label>
        <input type="text" name="company_id" required = 'true' placeholder = "Company ID"><br><br>
<label>Password : <input name="password" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*_+`~=?\|<>/]).{8,}" title="The password must contain at least one number, one uppercase letter, one lowercase letter, one special character and at least 8 or more characters" required = true type="password" onkeyup='check();' />
</label>
<br><br>
<input type="submit" name="submit" value="LOGIN">
<p>Don't have an account? <a href="company_register.php">Sign up now</a>.</p>
</form>
</div>
</body>
<?php
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: company_welcome.php");
    exit;
}
if(isset($_POST['submit'])){
require_once "config.php";
$sql1 = "SELECT company_id, password from placement.company WHERE company_id = :company_id";
$stmt = $pdo->prepare($sql1);
if($stmt->execute(array(':company_id'=>$_POST['company_id'])))
{
if($stmt->rowCount() == 0){
  echo '<script>alert("The Company ID is not registered! Please register.") </script>';
}
else{
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $password = $row['password'];
  if($password === md5($_POST['password'])){
    session_start();
    // Store data in session variables
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $row['company_id'];
    header("location: company_welcome.php");
  }
  else{
      echo '<script>alert("Incorrect Company ID  or Password!") </script>';
  }
}
}
}
 ?>
</html>
