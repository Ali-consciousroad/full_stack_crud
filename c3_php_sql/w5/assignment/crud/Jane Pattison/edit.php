<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
	if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || 
			strlen($_POST['mileage']) < 1 || strlen($_POST['year']) < 1 ) {
		$_SESSION['error'] = 'All fields are required';
		header("Location: edit.php?autos_id=".$_POST['autos_id']);
		return;
	}
	if ( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ) {
		$_SESSION['error'] = 'Mileage and year must be numeric';
		header("Location: edit.php?autos_id=".$_POST['autos_id']);
		return;
	}
	
	$sql = "UPDATE autos SET make = :make, 
		model = :model, 
		mileage = :mileage, 
		year = :year 
		WHERE autos_id = :autos_id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		':make' => $_POST['make'],
		':model' => $_POST['model'],
		':mileage' => $_POST['mileage'],
		':year' => $_POST['year'],
		':autos_id' => $_POST['autos_id']));
	$_SESSION['success'] = 'Record updated';
	header('Location: index.php');
	return;
}

$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
	$_SESSION['error'] = 'Bad value for autos_id';
	header('Location: index.php');
	return;
}

if ( isset($_SESSION['error']) ) {
	echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
	unset($_SESSION['error']);
}

$mk = htmlentities($row['make']);
$md = htmlentities($row['model']);
$ml = htmlentities($row['mileage']);
$yr = htmlentities($row['year']);
$autos_id = $row['autos_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Jane Pattison</title>
</head>
<body>
<p>Edit entry</p>
<form method="post">
	<p>Make:
	<input type="text" name="make" value="<?= $mk ?>">
	</p><p>Model:
	<input type="text" name="model" value="<?= $md ?>">
	</p><p>Mileage:
	<input type="text" name="mileage" value="<?= $ml ?>">
	</p><p>Year:
	<input type="text" name="year" value="<?= $yr ?>">
	</p>
	<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
	<p><input type="submit" value="Save">
	<a href="index.php">Cancel</a></p>
</form>
</body>
</html>