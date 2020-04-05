<?php

require_once('pdo.php');

$msg = false;
$smsg = false;

// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    exit;
}

if( isset($_POST['make']) || isset($_POST['year']) || isset($_POST['mileage']) ) {
    if( ! is_numeric($_POST['year']) || ! is_numeric($_POST['mileage']) ) {
        $msg = "Mileage and year must be numeric";
    }
    elseif (strlen($_POST['make']) < 1) {
        $msg = "Make is required";
    }
    else {
        try {
            $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
            $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'])
            );
            $smsg = "Record inserted";
        } catch (Exception $e) {
            $msg = "Internal error!";
        }
    }
}

$stmt = $pdo->query("SELECT * FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
<title>7366b7a8</title>
<?php require_once('bootstrap.php') ?>
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?= htmlentities($_GET['name']) ?></h1>
<?php 
    if($msg) {
        echo("<p style='color: red;'>".$msg."</p>");
    }
    else if($smsg) {
        echo("<p style='color: green;'>".$smsg."</p>");
    }
    else {
        ;
    }
?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>

<h2>Automobiles</h2>
<ul>
<?php
    foreach ($rows as $row) { ?>
        <li><?php echo htmlentities(($row['year']." ".$row['make']." / ".$row['mileage'])) ?></li>
     <?php } ?>
</ul>
</div>
</body> 
</html>