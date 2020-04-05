<?php // Do not put any HTML above this line
session_start();
require_once "pdo.php";
$stmt = $pdo->query("SELECT profile_id,first_name,last_name,headline FROM profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kareem Emad's Resume Registry</title>
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">

</head>
<body>
<div class="container">
    <h1>Kareem Emad's Resume Registry </h1>
    <?php
    if (isset($_SESSION['success'])) {
        echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
        unset($_SESSION['success']);
    }
    ?>

    <ul>
        <?php
          if((!(isset($_SESSION['name'])) && sizeof($rows) < 1 )) {
              echo '<p><a href="login.php">Please log in</a></p>';
            }
      else if(isset($_SESSION['name'] )&& sizeof($rows) < 1){
          echo '<p><a href="logout.php">Logout</a></p>';
          echo '<p><a href="add.php">Add New Entry</a></p>';
        } else if(isset($_SESSION['name'] )&& sizeof($rows) < 1){
              echo '<p><a href="logout.php">Logout</a></p>';
              echo '<p><a href="add.php">Add New Entry</a></p>';
            }   else if (sizeof($rows) > 0 && isset($_SESSION['name'])){
                echo '<p><a href="logout.php">Logout</a></p>';
                  echo "<table border='1'>";
                  echo " <thead><tr>";
                  echo "<th>Name</th>";
                   echo " <th>Headline</th>";
                   echo "<th>Action</th>";
                   echo " </tr></thead>";
                        foreach ($rows as $row) {
                          echo "<tr><td>";
                          echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.$row['first_name'].' '.$row['last_name'].'</a>');
                          echo("</td><td>");
                          echo($row['headline']);
                          echo("</td><td>");
                            echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> <a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
                          echo("</td></tr>\n");
                        }
                  echo "</table>";
                  echo '<p><a href="add.php">Add New Entry</a></p>';
                    echo '</li><br/></ul>';
              }else if(sizeof($rows) > 0 && !isset($_SESSION['name'])) {
                echo '<p><a href="login.php">Please log in</a></p>';
                  echo "<table border='1'>";
                  echo " <thead><tr>";
                  echo "<th>Name</th>";
                   echo " <th>Headline</th>";
                   echo " </tr></thead>";
                        foreach ($rows as $row) {
                          echo "<tr><td>";
                          echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.$row['first_name'].' '.$row['last_name'].'</a>');
                          echo("</td><td>");
                          echo($row['headline']);
                          echo("</td></tr>\n");
                        }
                  echo "</table>";
                  echo '</li><br/></ul>';
              }
            echo '<p> <b>Note:</b> Your implementation should retain data across multiple
                  logout/login sessions.  This sample implementation clears all its
                  data on logout - which you should not do in your implementation. </p>';

         ?>
</div>
</body>