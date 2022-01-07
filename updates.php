<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style_table.css">
  </head>
  <body>
    <h2 class="header2">LATEST NOTIFICATIONS</h2>
    <?php
    session_start();

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    try {
      require_once "config.php";
        $sql = "select c.company_id, c.company_name, c.profile_name, message, date from placement.updates c, placement.registered_for pr where c.company_id = pr.company_id and c.profile_name = pr.profile_name and pr.rollno = :username";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute(array(':username'=>$_SESSION["username"]))){
        echo "<center>";
        echo "<br>";
        echo "<form method = 'post'>";
        echo '<table border = 1>';
        echo "<tr><td>COMPANY_ID</td><td>COMPANY_NAME</td><td>PROFILE_NAME</td><td>MESSAGE</td><td>DATE</td></tr>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          echo "<tr><td>";
          echo $row['company_id'];
          echo"</td><td>";
          echo $row['company_name'];
          echo"</td><td>";
          echo $row['profile_name'];
          echo"</td><td>";
          echo $row['message'];
          echo"</td><td>";
          echo $row['date'];
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
