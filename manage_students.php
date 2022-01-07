<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage Applicants</title>
    <link rel="stylesheet" href="style_table.css">
  </head>
  <body>
  <h2 class="header2">MANAGE APPLICANTS</h2>
    <br><br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label>Student Roll No</label>
      <input type="text" name="rollno" required = 'true' ><br><br>
            <label>Company_ID</label>
            <input type="text" name="company_id" required = 'true' ><br><br>
            <label>Company_Name</label>
            <input type="text" name="company_name" required = 'true' ><br><br>
            <label>Profile Name</label>
            <input type="text" name="profile_name" required = 'true' ><br><br>
            <input type="submit" name="submit1" value="DELETE THE APPLICATION"><br><br><br>
          </form>
  <?php
  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
  }
  try {
    if(isset($_POST['submit1'])){
      require_once "config.php";
      $id = $_POST['company_id'];
      $profile = $_POST['profile_name'];
      $sql = "delete from placement.registered_for where rollno = :username and profile_name = :profile_name and company_id = :company_id";
      $stmt = $pdo->prepare($sql);
      if($stmt->execute(array(':username'=>$_POST['rollno'], ':profile_name'=>$profile, ':company_id'=>$id))){
      //echo "YEs";
      $count=$stmt->rowCount();
       if ($count == 0) {
         echo '<script>alert("Unsuccessful deletion! Check the entered details or contact the administrator if you think this is a mistake.")</script>';
       }
      else{
        echo '<script>if(confirm("Application Deleted Successfully!"));
        </script>';
      }
    }
    else {
      echo '<script>alert("Deletion not allowed! Contact the administrator if you think it is a mistake.") </script>';
    }
    echo "Current registrations for the company_id: ".$id." profile_name: ".$profile;
    echo "<br><br>";
      $sql = "select s.name, s.rollno, s.cname, s.email_id, s.contact_no from placement.student s, placement.registered_for pr where pr.rollno = s.rollno and pr.profile_name = :profile_name and pr.company_id = :company_id;";
      $stmt = $pdo->prepare($sql);
      if($stmt->execute(array(':profile_name'=>$profile, ':company_id'=>$id))){
      echo "<center>";
      echo "<br>";
      echo '<table border = 1>';
      echo "<form method = 'post'>";
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
      echo "</form>";
    }
  }
}
  catch (PDOException $e) {
    echo '<script>alert("Unsuccessful deletion! Check the entered details or contact the administrator if you think this is a mistake.")</script>';
  }
  ?>
</body>
  </html>
