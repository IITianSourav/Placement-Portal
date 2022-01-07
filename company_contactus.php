
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Coordinator Details</title>
    <link rel="stylesheet" href="style_table.css">
  </head>
  <body>
    <h2 class="header2">CONTACT DETAILS OF PLACEMENT COORDINATORS</h2>
    <?php
    session_start();

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: company_login.php");
        exit;
    }
    try {
      require_once "config.php";
        $sql = "SELECT name, email_id, contact_no FROM student WHERE rollno = (SELECT rollno FROM coordinator WHERE id = (SELECT coordinator_id FROM incharge_of WHERE company_id = :company_id))";

        $stmt = $pdo->prepare($sql);
       if($stmt->execute(array(':company_id'=>$_SESSION['username'] ))){
        echo "<center>";
        echo "<br>";
        echo '<table border = 1>';
        echo "<tr><td>COORDINATOR NAME</td><td>EMAIL ID</td><td>CONTACT_NO</td></tr>";

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          echo "<tr><td>";
          echo $row['name'];
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
     ?>
  </body>
</html>
