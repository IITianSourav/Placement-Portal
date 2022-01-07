
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Company Registration</title>
  <link rel="stylesheet" href="style_register.css">
</head>
<body>
        <div class = "header"><h2>REGISTER</h2>
          <div id="logo">
          <img src="IIT_Guwahati_Logo.jpg" height="130" width="130">
        </div>
      </div>
      <div class="box1">
        <p><h2 class="header2">Please fill this form to create an account</div></p>
        <p>Already have an account? <a href="company_login.php">LOGIN HERE</a>.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>Company ID:</label>
                <input type="text" name="company_id" required = 'true' placeholder = ' Company ID'><br><br>
                <label>Company Name:</label>
                <input type="text" name="company_name" required = 'true' placeholder = 'Company Name'><br><br>
                <p><h2 class="header2">Company POC Details</h2></p>
                <label>POC Name:</label>
                <input type="text" name="name" required = 'true' placeholder = ' POC Name'><br><br>
                <label>Contact Number:</label>
                <input type="number" name="contactno" required = 'true' placeholder = "Contact Number"><br><br>
                <label>Email ID:</label>
                <input type="text" name="emailid" required = 'true' placeholder = "Email ID"><br><br>

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
<label>Password : <input name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*_+`~=?\|<>/]).{8,}" title="The password must contain at least one number, one uppercase letter, one lowercase letter, one special character and at least 8 or more characters" required = true type="password" onkeyup='check();' />
</label>
<br><br>
<label>Confirm Password:
  <input type="password" name="confirm_password" id="confirm_password"  onkeyup='check();' />
  <span id='message'></span>
</label>
<br><br>
<input type="submit" name="submit" value="REGISTER">
        </form>
      </div>
</body>
<?php
// Include config file
require_once "config.php";
//echo "Connected!";
if($_POST['password']!=$_POST['confirm_password']){
  echo '<script>alert("Passwords do not match!") </script>';
}
$sql = "select company_id from placement.company where company_id = :company_id";
$stmt = $pdo->prepare($sql);
if($stmt->execute(array(':company_id'=>$_POST['company_id']))){
if($stmt->rowCount() == 1){
  echo '<script>alert("The company is already registered! Please login.") </script>';
}
}
try{
  require_once "config.php";
$sql = "insert into placement.company values (:company_id, :company_name, :password)";
$stmt = $pdo->prepare($sql);
$sql2 = "insert into placement.poc values(:company_id, :name, :contactno, :emailid);";
$stmt2 = $pdo->prepare($sql2);
if($stmt->execute(array(':company_id'=>$_POST['company_id'], ':company_name'=>$_POST['company_name'], 'password'=>md5($_POST['password']))) && $stmt2->execute(array(':company_id'=>$_POST['company_id'],':name'=>$_POST['name'], ':contactno'=>$_POST['contactno'], ':emailid'=>$_POST['emailid'])))
{
  echo '<script>alert("Successfully Registered!") </script>';
  header("location: company_login.php");
}
}
catch (PDOException $e) {
  echo '<script>alert("Unsuccessful Registration! Contact the administrator if you think this is a mistake.")</script>';
// echo "Connection failed: ".$e->getMessage();
}
?>
</html>
