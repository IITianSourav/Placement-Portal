<?php
// Include connect_mark file
require_once "connect_mark.php";
//echo "Connected!";
if($_POST['password']!=$_POST['confirm_password']){
  echo '<script>alert("Passwords do not match!") </script>';
}
$sql1 = "select companyid from placement.company where companyid = :companyid";
$stmt = $pdo->prepare($sql1);
if($stmt->execute(array(':username'=>$_POST['username']))){
if($stmt->rowCount() == 1){
  echo '<script>alert("The roll number is already registered! Please login.") </script>';
}
}
try{
  require_once "connect_mark.php";
$sql2 = "insert into placement.company values (:company_name, :companyid)";
$stmt = $pdo->prepare($sql2);
if($stmt->execute(array(':company_name'=>$_POST['company_name'], ':companyid'=>$_POST['companyid']))){
  echo '<script>alert("Successfully Registered!") </script>';
}
$sql3 = "insert into placement.poc values (:companyid, :name, :emailid, :contactno)";
$stmt = $pdo->prepare($sql3);
$stmt->execute(array(':companyid'=>$_POST['companyid'],
':name'=>$_POST['name'],
':emailid'=>$_POST['emailid'],
':contactno'=>$_POST['contactno']
));
echo '<script>alert("Successfully Registered!") </script>';

header("location: login.php");
}
catch (PDOException $e) {
  echo '<script>alert("Connection failed: ".$e->getMessage()) </script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Registration</title>
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
        <h2>REGISTER</h2>
        <p>Please fill this form to create an account.</p>
        <p>Already have an account? <a href="company_login.php">Login here</a>.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>Company ID</label>
                <input type="text" name="companyid" required = 'true'  pattern="[A-Za-z]{1,}" value = 'companyid'><br><br>
                <label>Company Name</label>
                <input type="text" name="company_name" required = 'true'  pattern="[A-Za-z]{1,}" value = 'company_name'><br><br>
                <p>Company POC Details</p>
                <label>POC Name</label>
                <input type="text" name="name" required = 'true'  pattern="[A-Za-z]{1,}" value = 'name'><br><br>
                <label>Contact Number</label>
                <input type="number" name="contactno" required = 'true' value = "Contact Number"><br><br>
                <label>Email ID</label>
                <input type="text" name="emailid" required = 'true' value = "emailid"><br><br>

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
</body>
</html>
