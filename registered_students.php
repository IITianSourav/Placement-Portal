<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Registered Students</title>
    <link rel="stylesheet" href="style_table.css">
  </head>
  <body>
    <h2 class="header2">REGISTERED STUDENTS</h2>
    <br><br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label>Company_ID</label>
            <input type="text" name="company_id" required = 'true' value = 'company_id'><br><br>
            <label>Company_Name</label>
            <input type="text" name="company_name" required = 'true' value = "company_name"><br><br>
            <label>Profile Name</label>
            <input type="text" name="profile_name" required = 'true' value = 'profile_name'><br><br>
            <input type="submit" name="submit" value="SEARCH">
            </form>
  </body>
  <?php
  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
  }
  try {
    if(isset($_POST['submit'])){
    require_once "config.php";
      $sql = "select s.name, s.rollno, s.cname, s.email_id, s.contact_no from placement.student s, placement.registered_for pr where pr.rollno = s.rollno and pr.profile_name = :profile_name and pr.company_id = :company_id;";
      $stmt = $pdo->prepare($sql);
      if($stmt->execute(array(':profile_name'=>$_POST['profile_name'], ':company_id'=>$_POST['company_id']))){
      echo "<center>";
      echo "<br>";
      echo '<table border = 1>';
      echo "<tr><td>ROLL NUMBER</td><td>NAME</td><td>COURSE</td><td>EMAIL ID</td><td>CONTACT NUMBER</td></tr>";
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['rollno'];
        echo"</td><td>";
        echo $row['name'];
        echo "</td><td>";
        echo $row['cname'];
        echo "</td><td>";
        echo $row['email_id'];
        echo "</td><td>";
        echo $row['contact_no'];
        echo "</td></tr>";
      }
      echo "</table>";
      echo "</center>";
      //print_r($withdraw);
      //print_r($company);
      //print_r($profile);
      //print_r($_POST);
    }
  }
  }
  catch (PDOException $e) {
    echo '<script>alert("Record not Found! Check the entered details or contact the administrator if you think this is a mistake.")</script>';
  }
  ?>
</html>
