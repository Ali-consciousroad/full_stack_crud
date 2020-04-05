<?php
session_start();
require_once "pdo.php";
$stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline
  FROM users JOIN profile ON users.user_id = profile.user_id");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
   <title>Carlos Trogolo's Resume Registry</title>
   <?php require_once "bootstrap.php"; ?>
</head>

<body>
  <div class="container">
  <h1>Carlos Trogolo's Resume Registry</h1>
  <?php
  if (isset($_SESSION['name'])) {
    echo "<p><a href='logout.php'>Log out</a></p>";
  }
  ?>
  <?php
  if (isset($_SESSION['success'])) {
    echo ('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
    unset($_SESSION['success']);
  }
  ?>

<ul>
  <?php
  if (!isset($_SESSION['name'])) {
    echo "<p><a href='login.php'>Please log in</a></p>";
  }
  if (true) {
    if (true) {
      echo "<table border='1'>";
      echo "<thead><tr>";
      echo "<th>Name</th>";
      echo "<th>Headline</th>";
      if (isset($_SESSION['name'])) {
        echo "<th>Action</th";
      }
      echo "</tr></thead>";
      foreach ($rows as $row) {
        echo ("<tr><td>");
        echo ("<a href='view.php?profile_id=".$row['profile_id']."'>" . $row['first_name'] . $row['last_name']."</a>");
        echo ("</td><td>");
        echo ($row['headline']);
        echo ("</td>");
        if (isset($_SESSION['name'])) {
          echo ("<td>");
          echo ('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / <a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
        }
        echo ("</td></tr>\n");
      }
      echo "</table>";
    } else {
      echo 'No rows found';
    }
  }
  echo '</li></ul';
  ?>
  <p><a href="add.php">Add New Entry</a></p>
  </div>
</body>
</html>