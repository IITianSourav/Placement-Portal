<?php 
require_once "config.php";
  $sql = "select s.name, s.rollno, s.cname, s.email_id, s.contact_no from placement.student s, placement.registered_for pr where pr.rollno = s.rollno and pr.profile_name = :profile_name and pr.company_id = :company_id;";
}
  $stmt = $pdo->prepare($sql);
  if($stmt->execute(array(':profile_name'=>$profile, ':company_id'=>$id))){
  echo "<center>";
  echo "<br>";
  echo '<table border = 1>';
  echo "<form method = 'post'>";
  echo "<tr><td>ROLL NUMBER</td><td>NAME</td><td>COURSE</td><td>EMAIL ID</td><td>CONTACT NUMBER</td><td>ACTION</td></tr>";
  $withdraw = array();
  $rollno = array();
  $k = 1;
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
    echo "</td><td>";
    $var = 'withdraw'.$k;
    $k = $k + 1;
    array_push($withdraw, $var);
    array_push($rollno, $row['rollno']);
    echo "<input type = 'submit' name = $var value = 'DELETE THE APPLICATION'>";
    echo "</td></tr>";
  }
  echo "</table>";
  echo "</center>";
  echo "</form>";
  print_r($rollno);
  print_r($_POST);
}
if($k==1){
  echo '<script>if(confirm("No records found! Check the entered details.")) document.location = "manage_students.php";
  else {
    document.location = "schedule_coordinator.php";
  }
  </script>';
}
for($i=0; $i<$k; $i++){
if(isset($_POST[$withdraw[$i]])){
//echo "Yes";
//echo $profile[$i].$company[$i];
require_once "config.php";
$sql = "delete from placement.registered_for where rollno = :username and profile_name = :profile_name and company_id = :company_id";
$stmt = $pdo->prepare($sql);
//echo "YEs";
if($stmt->execute(array(':username'=>$rollno[i], ':profile_name'=>$profile, ':company_id'=>$id))){
  echo '<script>if(confirm("Application Deleted Successfully!")) document.location = "update_coordinator.php";
  else {
    document.location = "schedule_coordinator.php";
  }
  </script>';
}
else {
echo '<script>alert("Deletion not allowed! Contact the administrator if you think it is a mistake.") </script>';
}
}
}
}
catch (PDOException $e) {
echo '<script>alert("Unsuccessful deletion! Check the entered details or contact the administrator if you think this is a mistake.")</script>';
}
 ?>
