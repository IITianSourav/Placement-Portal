<?php
// Initialize the session
session_start();
if($_POST['password']!=$_POST['confirm_password']){
  echo '<script>alert("Passwords do not match!") </script>';
}
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Include connect_mark file
if(isset($_POST['submit'])){
require_once "connect_mark.php";
            // Attempt to execute the prepared statement
            try{
            $sql = "UPDATE company set password = :password where companyid = :companyid";
            $stmt = $pdo->prepare($sql);
            if($stmt->execute(array
            (':password'=>md5($_POST['password']), ':username'=>$_SESSION["username"])))
            {
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: company_login.php");
                exit;
            }
          }
          catch (PDOException $e) {
            echo '<script>alert("Connection failed: ".$e->getMessage()) </script>';
          }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <script>
          var check = function() {
          if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'MATCHING';
          } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'NOT MATCHING';
          }
        }
        </script>
        <label>New Password : <input name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*_+`~=?\|<>/]).{8,}" title="The password must contain at least one number, one uppercase letter, one lowercase letter, one special character and at least 8 or more characters" required = true type="password" onkeyup='check();' />
        </label>
        <br><br>
        <label>Confirm Password:
          <input type="password" name="confirm_password" id="confirm_password" required = true onkeyup='check();' />
          <span id='message'></span>
        </label>
        <br><br>
        <input type="submit" name="submit" value="RESET THE PASSWORD">
        </form>
</body>
</html>
