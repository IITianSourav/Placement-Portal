
<?php
    session_start();
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: company_login.php");
        exit;
    }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Student Details</title>
    <link rel="stylesheet" href="style_table.css">
  </head>
  <body>
    <h2 class="header2">ENTER PROFILE NAME TO FIND THE REGISTERED STUDENT DETAILS</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <label>Profile Name:</label>
    <input type="text" name="profile_name" required = 'true' placeholder = "Job Profile Name"><br><br>
    <input type="submit" name="submit" value="SEARCH APPLICANT">
  </form>

  <h3 class="header2">Registered Student Details</h3>
 </body>
 </html>
    

<?php

require_once "config.php";


    if(isset($_POST['submit']))
    {
        try {
            $sql = "SELECT s.name, s.rollno, s.cname, s.email_id, s.contact_no FROM placement.student s, placement.registered_for pr WHERE pr.rollno = s.rollno AND pr.profile_name = :profile_name AND pr.company_id = :company_id";
    
            $stmt = $pdo->prepare($sql);
           if($stmt->execute(array
           (
               ':company_id'=>$_SESSION['username'],
               ':profile_name'=>$_POST['profile_name']
               )))
            {
            echo "<center>";
            echo "<br>";
            echo '<table border = 1>';
            echo "<tr><td>STUDENT NAME</td><td>ROLL NO</td><td>COURSE NAME</td><td>EMAIL ID</td><td>CONTACT_NO</td></tr>";
    
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
              echo "<tr><td>";
              echo $row['name'];
              echo"</td><td>";
              echo $row['rollno'];
              echo"</td><td>";
              echo $row['cname'];
              echo"</td><td>";
              echo $row['email_id'];
              echo"</td><td>";
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
        catch (PDOException $e) {
          echo '<script>alert("No info available. Come back later.")</script>';
        }
    }

     ?>
  
