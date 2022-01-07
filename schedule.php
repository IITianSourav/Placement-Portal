<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style_table.css">
  </head>
  <body>
    <h2 class="header2">UPCOMING EVENTS</h2>
    <?php
    session_start();

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    try {
      require_once "config.php";
        $sql = "(select ps.company_id, c.company_name, ps.profile_name, event, start_time, end_time from placement.schedule ps, placement.company c where ps.event = 'PPT' and c.company_id = ps.company_id)
union
(select distinct ps.company_id, c.company_name, ps.profile_name, event, start_time, end_time from placement.schedule ps, placement.company c, placement.registered_for pr where c.company_id = ps.company_id and ps.company_id = pr.company_id and ps.profile_name = pr.profile_name and pr.rollno = :username);";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute(array(':username'=>$_SESSION["username"]))){
        echo "<center>";
        echo "<br>";
        echo "<form method = 'post'>";
        echo '<table border = 1>';
        echo "<tr><td>COMPANY_ID</td><td>COMPANY_NAME</td><td>PROFILE_NAME</td><td>EVENT</td><td>START TIME</td><td>END TIME</td></tr>";
        $withdraw = array();
        $profile = array();
        $company = array();
        $k = 1;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          echo "<tr><td>";
          echo $row['company_id'];
          echo"</td><td>";
          echo $row['company_name'];
          echo"</td><td>";
          echo $row['profile_name'];
          echo "</td><td>";
          echo $row['event'];
          echo "</td><td>";
          echo $row['start_time'];
          echo "</td><td>";
          echo $row['end_time'];
          echo "</td></tr>";
        }
        echo "</table>";
        echo "</center>";
        echo "</form>";
        //print_r($withdraw);
        //print_r($company);
        //print_r($profile);
        //print_r($_POST);
      }
    }
    catch (PDOException $e) {
      echo '<script>alert("Withdrawal not allowed! Contact the administrator if you think it is a mistake.")</script>';
    }
     ?>
  </body>
</html>
