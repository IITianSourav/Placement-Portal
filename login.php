<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<h2>LOGIN</h2>
<p>Please enter your credentials to login.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Roll Number</label>
        <input type="number" name="username" required = 'true' value = "Roll Number"><br><br>
<label>Password : <input name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*_+`~=?\|<>/]).{8,}" title="The password must contain at least one number, one uppercase letter, one lowercase letter, one special character and at least 8 or more characters" required = true type="password" onkeyup='check();' />
</label>
<br><br>
<input type="submit" name="submit" value="LOGIN">
<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
</form>
</body>
<?php
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
if(isset($_POST['submit'])){
require_once "config.php";
$sql1 = "SELECT rollno, password from student_cred where rollno = :username";
$stmt = $pdo->prepare($sql1);
if($stmt->execute(array(':username'=>$_POST['username']))){
if($stmt->rowCount() == 0){
  echo '<script>alert("The roll number is not registered! Please register.") </script>';
}
else{
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $password = $row['password'];
  if($password === md5($_POST['password'])){
    session_start();
    // Store data in session variables
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $row['rollno'];
    header("location: welcome.php");
  }
  else{
      echo '<script>alert("Incorrect roll number or password!") </script>';
  }
}
}
}
 ?>
</html>
