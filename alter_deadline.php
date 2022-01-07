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
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <label>Company ID: </label>
    <input type="text" name="company_id" required = 'true' placeholder = "Company ID"><br><br>
        <label>Job Profile Name: </label>
          <input type="text" name="profile_name" required = 'true' placeholder = "Job Profile Name"><br><br>
        <label>New Deadline: </label>
        <input type="text" name="deadline" required = 'true' placeholder = "YYYY-MM-DD HH:MM:SS"><br><br>
<input type="submit" name="submit" value="CHANGE THE DEADLINE">
</form>
</body>
</html>


<?php
// Include connect_mark file
require_once "config.php";
//echo "Connected!";
if(isset($_POST['submit']))
{
  //echo $_SESSION['username'];
  //CHECKING COMPANY ID IS ALREADY REGISTERED OR NOT?
  try{
  $sql1 = "update jobprofile set deadline = :deadline where company_id = :company_id and profile_name = :profile_name;";
  $stmt1 = $pdo->prepare($sql1);
  if($stmt1->execute(array
  (
    ':company_id'=>$_POST['company_id'],
    ':profile_name'=>$_POST['profile_name'],
    ':deadline'=>$_POST['deadline']
  )))
  {
    echo '<script>alert("Deadline Successfully altered!") </script>';
  }
}
catch (PDOException $e) {
  //echo "Connection failed: ".$e->getMessage();
echo '<script>alert("Deadline cannot be updated. Check the entered details. Contact the administrator if you think this is a mistake.") </script>';
}
}

?>
