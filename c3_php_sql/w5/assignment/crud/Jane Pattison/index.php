<?php
	require_once "pdo.php";
	session_start();

	$autos = $pdo->query("SELECT * FROM autos;");
	$rows = $autos->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
<title>Jane Pattison Auto DB</title>
</head>
<body>
<div class="container">
<h1>Welcome to the Auto DB</h1>
<?php
	if ( isset($_SESSION['email']) ) {
		if ( empty($rows) ) {
			echo("<p>No rows found.</p>\n");
		} else {
			if ( isset($_SESSION['success']) ) {
				echo("<p>".$_SESSION['success']."</p>\n");
				unset($_SESSION['success']);
			}
			echo '<table border="1">'."\n";
			echo "<tr><td><b>Make</b></td><td><b>Model</b></td><td><b>Year</b></td><td><b>Mileage</b></td><td><b>Action</b></td></tr>\n";
			foreach ( $rows as $row ) {
				echo "<tr><td>";
				echo(htmlentities($row['make']));
				echo("</td><td>");
				echo(htmlentities($row['model']));
				echo("</td><td>");
				echo(htmlentities($row['year']));
				echo("</td><td>");
				echo(htmlentities($row['mileage']));
				echo("</td><td>");
				echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
				echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
				echo("</td></tr>\n");
			}
			echo "</table>\n";
		}
		echo("<p><a href='add.php'>Add New Entry</a></p>\n");
		echo("<p><a href='logout.php'>Logout</a></p>\n");
	} else {
		echo("<p><a href='login.php'>Please log in</a></p>\n");
	}
?>
</body>
</html>