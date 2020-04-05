<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dindar Ali</title>
	<?php 
	require_once "pdo.php";
	require_once "bootstrap.php"; 
	?>
</head>
<body>
	<div class="container">
		<h1>Welcome to Autos Database</h1>
		<p>
			<a href="login.php">Please Log In</a>
		</p>

		<!--
		<p>
			Attempt to go to 
			<a href="autos.php">autos.php</a> without logging in - it should fail with an error message.
		</p>
		-->

		<p>
			<!-- Link to view.php -->
			Attempt to go to 
			<a href="view.php">view.php</a> without logging in - it should fail with an error message.
		</p>
		<p>
			<!-- Linkg to add.php -->
			Attempt to go to 
			<a href="add.php">add.php</a> without logging in - it should fail with an error message.
		</p>
		
		
		<p>
			<!-- Open the specifications in a new tab -->
			<a href="https://www.wa4e.com/assn/autosess/"
			target="_blank">Specification for this Application</a>
		</p>
	</div>
</body>
</html>