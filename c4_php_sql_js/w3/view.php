<!-- READ (even if the user is not logged in ) -->

<?php
	require_once "pdo.php";
	require_once "bootstrap.php";
	session_start();
?>




<!DOCTYPE html>
<html>
<head>
	<title>Dindar Ali</title>
</head>
<body>
	<div class="container">
	<h1>Profile information</h1>

	<?php
		$stmt = $pdo->prepare (" 
				SELECT profile_id, first_name, last_name, email, headline, summary 
				FROM profile
				WHERE profile_id = :xyz	");  

		$stmt->execute(array(":xyz" => $_GET['profile_id']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		{	
			echo("<p>First Name: " .htmlentities($row['first_name'])."</p>");
			echo("<p>Last Name: " .htmlentities($row['last_name'])." </p>");
			echo("<p>Email: " .htmlentities($row['email'])." </p>");
			echo("<p>Headline: " .htmlentities($row['headline'])." </p>");
			echo("<p>Summary: " .htmlentities($row['summary'])." </p>");
			echo('<p><a href="index.php">Done</a></p>');
		}
	?>
</body>
</html>
