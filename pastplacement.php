<!DOCTYPE html>
<html>
    <head>
      <title>
        Past Placement Record
</title>
<link rel="stylesheet" href="style_table.css">
    </head>

    <body>
        <h1 class="header">Past Placement Record for year 2020</h1>
    </body>
</html>

<?php

require_once "config.php";


        try {
            $sql = "SELECT * FROM placement.pastplc1 ";
            $stmt = $pdo->prepare($sql);
           if($stmt->execute())
            {
            echo "<center>";
            echo "<br>";
            echo '<table border = 1>';
            echo "<tr><td>COMPANY NAME</td><td>PROFILE NAME</td><td>NO. OF STUDENTS PLACED</td></tr>";
    
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
              echo "<tr><td>";
              echo $row['companyname'];
              echo"</td><td>";
              echo $row['profilename'];
              echo"</td><td>";
              echo $row['no_student'];
              echo "</td></tr>";
            }
            echo "</table>";
            echo "</center>";
          }
        }
        catch (PDOException $e) {
          echo '<script>alert("No info available. Come back later.")</script>';
        }

     ?>