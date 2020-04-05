<?php
require_once "pdo.php";
session_start();
?>
<h!DOCTYPE html>
<html>
<head>
<title>Bernardo Martelli - Autos Database</title>
<style media="screen">
  table{
    border-collapse: collapse;
  }
  table tr td,
  table th{
    padding: 6px;
  }
  .container{
     padding: 20px;
  }
</style>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

</head>
<body>
<div class="container">
<h1>Welcome to the Automobiles Database</h1>

<p>
<?php
//no login
if (! isset($_SESSION['login'])){
    echo "<a href='login.php'>Please log in</a>";
}
//login ok
 else{
   if ( isset($_SESSION['error']) ) {
       echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
       unset($_SESSION['error']);
   }
  if ( isset($_SESSION['success']) ) {
      echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
      unset($_SESSION['success']);
  }

  $stmt = $pdo->query("SELECT make, year, model, mileage, auto_id FROM autos");
 //  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  //no items in the DB
  if ($stmt->rowCount() > 0){
      echo '<table border= "1">'."\n";
      echo "<thead><tr>\n";
      echo "<th>Make</th>\n";
      echo "<th>Model</th>\n";
      echo "<th>Year</th>\n";
      echo "<th>Mileage</th>\n";
      echo "<th colspan='2'>Action</th>\n";
      echo "</tr></thead>\n";
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
              echo "<tr><td>\n";
              echo htmlentities($row['make']);
              echo "</td><td>\n";
              echo htmlentities($row['model']);
              echo "</td><td>\n";
              echo htmlentities($row['year']);
              echo "</td><td>\n";
              echo htmlentities($row['mileage']);
              echo "</td><td>\n";
              //adding Get parameter
              echo  '<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a>'."\n";
              echo "</td><td>\n";
              echo  '<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>'."\n";
              echo "</td></tr>\n";
          }
        echo '</table>'."\n";
  }
  else{
        echo 'No rows found';
  }
  ?>
  <p>
  <a href="add.php">Add New Entry</a>
  </p>
  <a href='logout.php'>Logout</a>
 <?php
}
?>

</p>
</div>
</body>
</body>