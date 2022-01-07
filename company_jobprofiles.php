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
<head>
<link rel="stylesheet" href="style_table.css">
</head>
<body>
  <h2 class="header2">ADD DETAILS FOR JOB-PROFILE</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Job Profile Name:</label>
          <input type="text" name="profile_name" required = 'true' placeholder = "Job Profile Name"><br><br>
        <lable>CPI Cutt-Off:</lable>
          <input type="number" name="cpi_cutoff" step='0.1' required = 'true' placeholder = "CPI cut-off"><br><br>
        <label>Profile Description:</label>
          <textarea name="profile_description" rows="6" cols="50" style="border: 2px solid red;"></textarea>
          <br><br><br>
        <label>Selection Process Description:</label>
        <textarea name="process_description" rows="6" cols="50" style="border: 2px solid red;"></textarea>
        <br><br>
        <label>Pay CTC Rs:</label>
          <input type="number" name="pay_ctc_rs"  required = 'true' placeholder = "Pay CTC Rs"><br><br>
        <label>Pay Base Rs:</label>
          <input type="number" name="pay_base_rs" required = 'true' placeholder = "Pay Base Rs"><br><br>
        <label>Job Location:</label>
          <input type="text" name="location" required = 'true' placeholder = "Job Location"><br><br>
        <label>Job Details link:</label>
          <input type="text" name="jd_link" required = 'true' placeholder = "Share link"><br><br>
        <label>Deadline:</label>
        <input type="text" name="deadline" required = 'true' placeholder = "YYYY-MM-DD HH:MM:SS"><br><br>
<br><br>
<input type="submit" name="submit" value="submit">

</form>
</body>
</html>


<?php
// Include connect_mark file
require_once "config.php";
//echo "Connected!";
if(isset($_POST['submit']))
{
  echo $_SESSION['username'];
  //CHECKING COMPANY ID IS ALREADY REGISTERED OR NOT?
  try{
  $sql1 = "INSERT INTO placement.jobprofile VALUES (:company_id, :profile_name, :cpi_cutoff, :profile_description, :process_description, :location, :jd_link, :deadline)";
  $stmt1 = $pdo->prepare($sql1);
  $sql2 = "INSERT INTO placement.pay VALUES (:company_id, :profile_name, :pay_CTC_rs, :pay_Base_rs)";
  $stmt2 = $pdo->prepare($sql2);
  if(($stmt1->execute(array
  (
    ':company_id'=>$_SESSION['username'],
    ':profile_name'=>$_POST['profile_name'],
    ':cpi_cutoff'=>$_POST['cpi_cutoff'],
    ':profile_description'=>$_POST['profile_description'],
    ':process_description'=>$_POST['process_description'],
    ':location'=>$_POST['location'],
    ':jd_link'=>$_POST['jd_link'],
    ':deadline'=>$_POST['deadline']
  )
)) && ($stmt2->execute(array(':company_id'=>$_SESSION['username'], ':profile_name'=>$_POST['profile_name'], ':pay_CTC_rs'=>$_POST['pay_ctc_rs'], ':pay_Base_rs'=>$_POST['pay_base_rs']))
)){
    echo '<script>alert("Successfully Registered!") </script>';
  }
}
catch (PDOException $e) {
  echo "Connection failed: ".$e->getMessage();
//echo '<script>alert("Notification cannot be sent. Check the entered details. Contact the administrator if you think this is a mistake.") </script>';
}
  }

?>
