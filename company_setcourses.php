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
<h2 class="header2">EDIT COURSE FOR JOB PROFILE</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Job Profile Name:</label>
          <input type="text" name="profile_name" required = 'true' placeholder = "Job Profile Name"><br><br>
        <label>CPI Cut-Off:</label>
          <input type="number" name="cpi_cutoff" step='0.1' required = 'true' placeholder = "CPI cut-off">
<br><br>
<label>Course Name</label>
<select name="cname" style="border: 2px solid red;">
  <option value="Btech. Biotechnology">Btech. Biotechnology</option>
  <option value="Btech. Chemical Engineering">Btech. Chemical Engineering</option>
  <option value="Btech. Chemical Science & Technology">Btech. Chemical Science & Technology</option>
  <option value="Btech. Civil Engineering">Btech. Civil Engineering</option>
  <option value="Btech. Computer Science & Engineering">Btech. Computer Science & Engineering</option>
  <option value="Btech. Electronics & Electrical Engineering">Btech. Electronics & Electrical Engineering</option>
  <option value="Btech. Electronics & Communication Engineering">Btech. Electronics & Communication Engineering</option>
  <option value="Btech. Mathematics & Computing">Btech. Mathematics & Computing</option>
  <option value="Btech. Mechanical Engineering">Btech. Mechanical Engineering</option>
  <option value="Btech. Engineering Physics">Btech. Engineering Physics</option>
  <option value="Btech. Data Science & Artifical Intelligence">Btech. Data Science & Artifical Intelligence</option>
  <option value="B.Des.">B.Des.</option>
  <option value="HSS">HSS</option>
  <option value="MA in Development Studies">MA in Development Studies</option>
  <option value="MSc. Physics">MSc. Physics</option>
  <option value="MSc. Chemistry">MSc. Chemistry</option>
  <option value="MSc. Mathematics & Computing">MSc. Mathematics & Computing</option>
  <option value="MSR in Energy">MSR in Energy</option>
  <option value="MSR in E-Mobility">MSR in E-Mobility</option>
  <option value="MSR in Disaster Management">MSR in Disaster Management</option>
  <option value="M.Des.">M.Des.</option>
  <option value="Mtech. Computer Science & Engineering">Mtech. Computer Science & Engineering</option>
  <option value="Mtech. CSE">Mtech. CSE</option>
  <option value="Mtech. Electronics Communication Engineering">Mtech. Electronics Communication Engineering</option>
  <option value="Mtech. EEE - Signal Processing">Mtech. EEE - Signal Processing</option>
  <option value="Mtech. EEE - VLSI">Mtech. EEE - VLSI</option>
  <option value="Mtech. EEE - Communication Engineering">Mtech. EEE - Communication Engineering</option>
  <option value="Mtech. EEE - Applied Control">Mtech. EEE - Applied Control</option>
  <option value="Mtech. EEE - Power & Control">Mtech. EEE - Power & Control</option>
  <option value="Mtech. EEE - RF & Photonics">Mtech. EEE - RF & Photonics</option>
  <option value="Mtech. ME - Machine Design">Mtech. ME - Machine Design</option>
  <option value="Mtech. ME - Fluids & Thermal Engineering">Mtech. ME - Fluids & Thermal Engineering</option>
  <option value="Mtech. ME - Manufacturing Science & Engineering">Mtech. ME - Manufacturing Science & Engineering</option>
  <option value="Mtech. ME - Computational Mechanics">Mtech. ME - Computational Mechanics</option>
<option value="Mtech. ME - Aerodynamics & Propulsion">Mtech. ME - Aerodynamics & Propulsion</option>
<option value="Mtech. Civil Engineering">Mtech. Civil Engineering</option>
<option value="Mtech. CE - Water Engineering & Management">Mtech. CE - Water Engineering & Management</option>
<option value="Mtech. CE - Transportation Systems Engineering">Mtech. CE - Transportation Systems Engineering</option>
<option value="Mtech. CE - Environmental Engineering">Mtech. CE - Environmental Engineering</option>
<option value="Mtech. CE - Structural Engineering">Mtech. CE - Structural Engineering</option>
<option value="Mtech. CE - Geotechnical Engineering">Mtech. CE - Geotechnical Engineering</option>
<option value="Mtech. CE - Infrastructure Engineering and Management">Mtech. CE - Infrastructure Engineering and Management</option>
<option value="Mtech. CE - Earth System Science and Engineering">Mtech. CE - Earth System Science and Engineering</option>
<option value="Mtech. Biosciences and Bioengineering (BT)">Mtech. Biosciences and Bioengineering (BT)</option>
<option value="Mtech. CL - Petroleum Refinery Engineering">Mtech. CL - Petroleum Refinery Engineering</option>
<option value="Mtech. CL - Petroleum Science & Technology">Mtech. CL - Petroleum Science & Technology</option>
<option value="Mtech. CL - Material Science & Technology">Mtech. CL - Petroleum Science & Technology</option>
<option value="Mtech. DS - Data Science">Mtech. DS - Data Science</option>
<option value="Mtech. CP - Center for Intelligent Cyber - Physical Systems">Mtech. CP - Center for Intelligent Cyber - Physical Systems</option>
<option value="PhD in Physics">PhD in Physics</option>
</select>
<br><br>
<input type="submit" name="submit" value="ADD THE COURSE">
</form>
</body>
</html>


<?php
// Include connect_mark file
require_once "config.php";
//echo "Connected!";
if(isset($_POST['submit']))
{
  //echo $_SESSION['username'];
  //CHECKING COMPANY ID IS ALREADY REGISTERED OR NOT?
  try{
  $sql1 = "INSERT INTO placement.open_to VALUES (:cname, :profile_name, :company_id, :cpi_cutoff)";
  $stmt1 = $pdo->prepare($sql1);
  if(($stmt1->execute(array
  (
    ':company_id'=>$_SESSION['username'],
    ':profile_name'=>$_POST['profile_name'],
    ':cpi_cutoff'=>$_POST['cpi_cutoff'],
    ':cname'=>$_POST['cname']
  )
))){
    echo '<script>alert("Successfully Registered!") </script>';
  }
  $sql = "select s.profile_name, s.cname, s.cpi_cutoff from placement.open_to s where s.company_id = :id and s.profile_name = :profile_name;";
  $stmt = $pdo->prepare($sql);
  if($stmt->execute(array(':id'=>$_SESSION['username'], ':profile_name'=>$_POST['profile_name']))){
  echo "<center>";
  echo "<br>";
  echo '<table border = 1>';
  echo "<tr><td>PROFILE_NAME</td><td>COURSE NAME</td><td>CPI_CUTOFF</td></tr>";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    echo "<tr><td>";
    echo $row['profile_name'];
    echo"</td><td>";
    echo $row['cname'];
    echo"</td><td>";
    echo $row['cpi_cutoff'];
    echo "</td></tr>";
  }
  echo "</table>";
  echo "</center>";
}
}
catch (PDOException $e) {
//echo "Connection failed: ".$e->getMessage();
echo '<script>alert("Course cannot be registered. Check the profile name or entered course. Contact the administrator if you think this is a mistake.") </script>';
}
  }
?>
