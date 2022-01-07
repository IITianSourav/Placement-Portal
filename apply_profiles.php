<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style_table.css">
  </head>
  <body>
    <h2 class="header2">APPLY FOR PROFILES</h2>
    <br><br>
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
    require_once "config.php";
    $sql = "select Applied_profiles, Available_profiles from placement.profiles_applied where rollno = :username";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute(array(':username'=>$_SESSION["username"]))){
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      echo "Total profiles applied for : ". $row['Applied_profiles'];
      echo "<br>";
      echo "Total number of available profiles: ".$row['Available_profiles'];
      echo "<br>";
    }
    $sql = "select c.company_id, company_name, p.profile_name, cpi_cutoff, profile_description, process_description, pay_CTC_rs, pay_base_rs, location, jd_link, deadline from placement.pay p, placement.company c, placement.jobprofile jp, placement.open_to op, placement.student s where op.profile_name = jp.profile_name and op.cname = s.cname and op.company_id = jp.company_id and p.company_id = jp.company_id and p.profile_name = jp.profile_name and c.company_id = jp.company_id and s.rollno = :username and s.cpi>=op.cpi_cutoff and s.cname in (select cname from placement.open_to op where op.profile_name = jp.profile_name and op.company_id = jp.company_id)";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute(array(':username'=>$_SESSION["username"]))){
    echo "<center>";
    echo "<br>";
    echo "<form method = 'post'>";
    echo '<table border = 1>';
    echo "<tr><td>COMPANY_ID</td><td>COMPANY_NAME</td><td>PROFILE_NAME</td><td>CPI_CUTOFF</td><td>PROFILE_DESCRIPTION</td><td>PROCESS_DESCRIPTION</td><td>PAY_CTC_RS</td><td>PAY_BASE_RS</td><td>LOCATION</td><td>JD_LINK</td><td>DEADLINE</td><td>ACTION</td></tr>";
    $apply = array();
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
      echo"</td><td>";
      echo $row['cpi_cutoff'];
      echo "</td><td>";
      echo $row['profile_description'];
      echo "</td><td>";
      echo $row['process_description'];
      echo "</td><td>";
      echo $row['pay_CTC_rs'];
      echo "</td><td>";
      echo $row['pay_base_rs'];
      echo "</td><td>";
      echo $row['location'];
      echo "</td><td>";
      echo $row['jd_link'];
      echo "</td><td>";
      echo $row['deadline'];
      echo "</td><td>";
      $var = 'apply'.$k;
      $k = $k + 1;
      array_push($apply, $var);
      array_push($profile, $row['profile_name']);
      array_push($company, $row['company_id']);
      echo "<input type = 'submit' name = $var value = 'APPLY'>";
      echo "</td></tr>";
    }
    echo "</table>";
    echo "</center>";
    echo "</form>";
    //print_r($apply);
    //print_r($company);
    //print_r($profile);
    //print_r($_POST);
  }
for($i=0; $i<$k; $i++){
if(isset($_POST[$apply[$i]])){
  //echo "Yes";
  //echo $profile[$i].$company[$i];
 require_once "config.php";
  $sql ="insert into registered_for values (:username, :profile_name, :company_id, 'Ongoing');";
  $stmt = $pdo->prepare($sql);
  //echo "YEs";
  if($stmt->execute(array(':username'=>$_SESSION["username"], ':profile_name'=>$profile[$i], ':company_id'=>$company[$i]))){
    echo '<script>if(confirm("Successfully Applied!")) document.location = "aboutus.php";
    else {
      document.location = "apply_profiles.php";
    }
    </script>';
  }
}
}
  }
      catch (PDOException $e) {
      echo '<script>alert("Application not admitted! Check your applied profiles or contact the administrator if you think it is a mistake.") </script>';
      }
    ?>
</html>
