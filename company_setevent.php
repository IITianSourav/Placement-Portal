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
  <h2 class="header2">SET EVENT DETAILS</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Profile Name:</label>
          <input type="text" name="profile_name" required = 'true' placeholder = "Job Profile Name"><br><br>
        <label>Event Name:</label>
          <input type="text" name="event" required = 'true' placeholder = "Event Name"><br><br>
        <lable>Start Time:</lable>
        <input type="text" name="start_time" required = 'true' placeholder = "YYYY-MM-DD HH:MM:SS"><br><br>
        <lable>End Time:</lable>
        <input type="text" name="end`_time" required = 'true' placeholder = "YYYY-MM-DD HH:MM:SS"><br><br>
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
  $sql1 = "INSERT INTO placement.schedule VALUES (:company_id, :profile_name, :event, :start_time, :end_time)";
  $stmt1 = $pdo->prepare($sql1);
  if($stmt1->execute(array
  (
    ':company_id'=>$_SESSION['username'],
    ':profile_name'=>$_POST['profile_name'],
    ':event'=>$_POST['event'],
    ':start_time'=>$_POST['start_time'],
    ':end_time'=>$_POST['end_time']
  
)))
{
    echo '<script>alert(" Event added Successfully.") </script>';
}
}
catch (PDOException $e) {
  echo "Connection failed: ".$e->getMessage();
//echo '<script>alert("Notification cannot be sent. Check the entered details. Contact the administrator if you think this is a mistake.") </script>';
}
  }

?>