<?php
require_once "pdo.php";
session_start();
if (!isset($_SESSION['name'])) {
  die("ACCESS DENIED");
}
if (isset($_POST['cancel'])){
  header('Location: index.php');
}
//make, model, miliage, year
if (isset($_POST['save'])){

  //data validation
  if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1
      || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1){

        $_SESSION['error'] = 'All fields are required';
        header('Location: edit.php?auto_id='.$_GET['auto_id']);
        return;
  }

  elseif ( !is_numeric($_POST['mileage'])){
    $_SESSION['error'] = 'Mileage must be an integer';
    header('Location: edit.php?auto_id='.$_GET['auto_id']);
    return;
  }
  elseif ( !is_numeric($_POST['year'])){
    $_SESSION['error'] = 'Year must be an integer';
    header('Location: edit.php?auto_id='.$_GET['auto_id']);
    return;
  }

    //insert record
    elseif ( isset($_POST['make']) && isset($_POST['model'])
         && isset($_POST['mileage']) && isset($_POST['year']) && isset($_POST['auto_id'])){

           $sql = 'UPDATE autos SET make = :make,
                   model = :model, mileage = :mileage, year = :year
                   WHERE auto_id = :auto_id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                     ':make' => $_POST['make'],
                     ':model' => $_POST['model'],
                     ':mileage' => $_POST['mileage'],
                     ':year' => $_POST['year'],
                     ':auto_id' => $_POST['auto_id'],
            ));
            $_SESSION['success'] = 'Record updated';
            header('Location: index.php');
            return;
    }
}

$stmt = $pdo->prepare("SELECT * FROM autos WHERE auto_id = :x");
$stmt->execute(array(':x' => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false){
    $_SESSION['error'] = 'Bad value for autos_id';
    header('Location: index.php');
    return;
}

$ma = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$mi = htmlentities($row['mileage']);
$y = htmlentities($row['year']);
$auto_id = $row['auto_id'];


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bernardo Martelli</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <h1>Editing Automobile</h1>
      <?php
      if ( isset($_SESSION['error']) ) {
          echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
          unset($_SESSION['error']);
      }
      ?>
      <form method="post">
        <p>Make<input type="text" name="make" size="40" value="<?= $ma ?>"></p>
        <p>Model<input type="text" name="model" size="40" value="<?= $mo ?>"></p>
        <p>Year<input type="text" name="year" size="10" value="<?= $y ?>"></p>
        <p>Mileage<input type="text" name="mileage" size="10" value= "{{{PHP6}}}"></p>
        <input type="hidden" name="auto_id" value="<?= $auto_id ?>">
        <input type="submit" value="Save" name= "save">
        <input type="submit" name="cancel" value="Cancel">
      </form>
    </div>
  </body>
</html>