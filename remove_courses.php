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
</head>
<body>
  REMOVE A COURSE <br><br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <label>Company ID: </label>
    <input type="text" name="company_id" required = 'true' placeholder = "Company ID"><br><br>
        <label>Job Profile Name: </label>
          <input type="text" name="profile_name" required = 'true' placeholder = "Job Profile Name"><br><br>
        <label>Course: </label>
        <select name="cname">
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
<input type="submit" name="submit" value="DELETE THE COURSE">
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
  $sql1 = "delete from placement.open_to where cname = :cname and profile_name = :profile_name and  company_id = :company_id";
  $sql2 = "delete from placement.registered_for where cname = :cname and profile_name = :profile_name and company_id = :company_id";
  $stmt1 = $pdo->prepare($sql1);
  if($stmt1->execute(array
  (
    ':cname'=>$_POST['cname'],
    ':profile_name'=>$_POST['profile_name'],
    ':company_id'=>$_POST['company_id']
  )))
  {
    echo '<script>alert("Course Removed Successfully! Please send a notfication to update the students.") </script>';
  }
}
catch (PDOException $e) {
//  echo "Connection failed: ".$e->getMessage();
echo '<script>alert("Course cannot be added. Check the entered details. Contact the administrator if you think this is a mistake.") </script>';
}
}

?>
