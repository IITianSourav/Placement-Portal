<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coordinator Login</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
  <br><br><br><br>
  <div class="box1">
    <div id="logo">
    <img src="iitg.png" height="100" width="100">
</div>
<h3>LOGIN</h3>
<p>Please enter your credentials to login.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Coordinator ID: </label>
        <input type="text" name="username" required = 'true' placeholder = "ID"><br><br>
<label>Password: <input name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*_+`~=?\|<>/]).{8,}" title="The password must contain at least one number, one uppercase letter, one lowercase letter, one special character and at least 8 or more characters" required = true type="password" onkeyup='check();' />
</label>
<br><br>
<input type="submit" name="submit" value="LOGIN">
</form>
</div>
</body>
<?php
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome_coordinator.php");
    exit;
}
if(isset($_POST['submit'])){
require_once "config.php";
$sql1 = "SELECT id, password from coordinator where id = :username";
$stmt = $pdo->prepare($sql1);
if($stmt->execute(array(':username'=>$_POST['username']))){
if($stmt->rowCount() == 0){
  echo '<script>alert("The coordinator is not registered! Please contact the administrator.") </script>';
}
else{
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $password = $row['password'];
  if($password === md5($_POST['password'])){
    session_start();
    // Store data in session variables
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $row['id'];
    header("location: welcome_coordinator.php");
  }
  else{
      echo '<script>alert("Incorrect ID or password!") </script>';
  }
}
}
}
 ?>
</html>
