
<!-- Model --> 
<?php
	session_start();
	require_once "pdo.php";
	$stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dindar Ali</title>
	<?php require_once "bootstrap.php"; ?>


</head>
<body style="font-family: sans-serif;">

	<!-- Container for the document (default margin, padding etc.) -->
	<div class="container">
	<h1></h1>
	<?php
		// Check if the username (email) is set.
	    if ( ! isset($_SESSION['name']) ) 
	    {
	    	die('Not logged in');
		}


	    if (isset($_SESSION["name"]))
	    {
	    	// Post -> Session / Redirection -> Get 
	    	$_GET['name'] = $_SESSION['name'];
		   

		  	echo "<h1>Tracking Autos for ".htmlentities($_SESSION["name"])."</h1>"; // Prevent HTML injection on 'name' (for data given by the user)
	    	echo "</p>\n";
	    }
	    	
	    // Flash message - success
    	if (isset($_SESSION["success"]) ) 
	    {
		    echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
		    unset($_SESSION["success"]);
	    }  
		    

			echo"<h2>Automobiles</h2>";

		
	    /*
		if ( isset($_SESSION['add'])) 
	    {
	    	$_GET['add'] = $_SESSION['add'];
		    // Redirect the browser to add.php
			header('Location: view.php');
			return;
		}
		*/
	?>
  
    <?php
	    foreach ( $rows as $row ) 
	    {
	        // htmlentities prevent injection by the user (SQL, html)
	        echo "<ul><li>";
	        echo(htmlentities($row['year']." "));
	        echo(htmlentities($row['make']. " / "));
	        echo(htmlentities($row['mileage']));
	        
	        // Allow to delete rows from the screen
	        /*
	        echo('<form method="post"><input type="hidden" ');
	        echo('name="auto_id" value="'.$row['auto_id'].'">'."\n");
	        echo('<input type="submit" value="Del" name="delete">');
	        echo("\n</form>\n");
	        */
	        
	        echo("</li></ul>\n");
	    }
    ?>

    	<p><a href='add.php'>Add New</a> | <a href='logout.php'>Logout</a></p>

    </div>
</body>
</html>