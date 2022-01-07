<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Send updates</title>
    <link rel="stylesheet" href="style_table.css">
  </head>
  <body>
    <h2 calss="header2">SEND NOTIFICATIONS<h2>
    <br><br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label>Company ID: </label>
            <input type="text" name="company_id" required = 'true' value = 'company_id'><br><br>
            <label>Company Name: </label>
            <input type="text" name="company_name" required = 'true' value = "company_name"><br><br>
            <label>Profile Name: </label>
            <input type="text" name="profile_name" required = 'true' value = 'profile_name'><br><br>
            <label>Message: </label>
            <textarea name="message" rows="8" cols="80" style=" border: 2px solid red;"></textarea>
            <br><br>
            <input type="submit" name="submit" value="SEND">
            </form>
  </body>
  <?php
  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login_coordinator.php");
      exit;
  }
  try {
if(isset($_POST['submit'])){
  //echo "Yes";
  //echo $profile[$i].$company[$i];
 require_once "config.php";
  $sql ="insert into placement.updates values (:company_id, :company_name, :profile_name, :message, CURRENT_TIMESTAMP);";
  $stmt = $pdo->prepare($sql);
  //echo "YEs";
  if($stmt->execute(array('company_id'=>$_POST['company_id'],':company_name'=>$_POST['company_name'], ':profile_name'=>$_POST['profile_name'], ':message'=>$_POST['message']))){
    echo '<script>if(confirm("Notification sent successfully!"))
    document.location = "schedule_coordinator.php";
    else {
      document.location = "update_coordinator.php";
    }
    </script>';
  }
}
}
      catch (PDOException $e) {
        print_r($_POST);
      //echo '<script>alert("Notification cannot be sent. Check the entered details. Contact the administrator if you think this is a mistake.") </script>';
      }
    ?>
  </html>
