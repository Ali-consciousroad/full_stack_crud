<?php
	require_once "pdo.php";
	require_once "bootstrap.php";
	session_start();
?>

<!DOCTYPE html>
	<head>
		<title>Dindar Ali</title>
	</head>

	<body>
		<div class="container">
			<h1>Ali Dindar's Resume Registry</h1>
			<!-- <p><a href="logout.php">Logout</a></p>-->

			<?php 
			// Use of pdo prevent SQL injection
			$stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM profile");  

			// Verify if the the super global variable "email" is set
			if ( ! isset($_SESSION["email"]) ) 
		    { 
				echo("<p><a href='login.php'>Please log in</a></p>");
				echo('<table border="1">'."\n");
		        echo"<tr>
		                <th>Name</th>
		                <th>Headline</th>
		            <tr>";
		   
		        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) 
		        {
			 		echo "<tr><td>";
			        echo(htmlentities($row['first_name']));

			        echo("</td><td>");
			        echo(htmlentities($row['headline']));
			       
			        echo("</td></tr>\n");
			    }
		    } 

		    // If that's the case, display a flash message (error or success) when needed.
		    else 
		    { 
		    	if ( isset($_SESSION['error']) ) 
		        {
		            echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
		            unset($_SESSION['error']);
		        }

		        elseif ( isset($_SESSION['success']) ) 
		        {
		            echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
		            unset($_SESSION['success']);
		        }

		    	echo("<p><a href='logout.php'>Logout</a></p>");
				echo('<table border="1">'."\n");        
		        echo"<tr>
		                <th>Name</th>
		                <th>Headline</th>
		                <th>Action</th>
		            <tr>";
		   
		        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) 
		        {
		        	// Question: Why do we need to use a dot with $row ? -> .$row['']
			 		echo "<tr><td>";
			        //echo(htmlentities($row['first_name'] . " " . $row['last_name']));
			        echo('<a href="view.php?profile_id='.$row['profile_id'].'" > '.$row['first_name'].'  '. $row['last_name'].'</a>');

			        //echo('<a href="view.php"> htmlentities($row['first_name']) </a>');
			        echo("</td><td>");
			        echo(htmlentities($row['headline']));

			        echo("</td><td>");
			        echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
			        echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
			        echo("</td></tr>\n");
			    }
			    echo('<p><a href="add.php">Add New Entry</a></p>');
			}
		    		
		    ?>
		        </table>
	
	        <p>
	        	 <strong>Note:</strong> Your implementation should retain data across multiple logout/login sessions. 
	        </p>

	        <p>
	        	<a href="https://www.coursera.org/learn/javascript-jquery-json/supplement/zOyK3/assignment-specification-profiles-positions-and-jquery" target="_blank">Assignment instruction</a>
	        </p>

	        <p>
	        	<a href="https://www.wa4e.com/solutions/res-position/" target="_blank">Sample solution</a>
	        </p>

		</div>
	</body>
</html>