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

			$stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM profile");  



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
			 		echo "<tr><td>";
			        echo(htmlentities($row['first_name']));
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
	        	<a href="https://www.wa4e.com/assn/res-profile/" target="_blank">Assignment instruction</a>
	        </p>

	        <p>
	        	<a href="https://www.wa4e.com/solutions/res-profile/" target="_blank">Sample solution</a>
	        </p>

		</div>
	</body>
</html>