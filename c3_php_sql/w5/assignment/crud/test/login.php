<!-- 
Model - The brain
-->
<?php // Do not put any HTML above this line
session_start(); 			// Nothing can be written this (even html!)
require_once "pdo.php";

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
	header('Location: index.php');
	return;
}

// More information on MD5.My-Addr.com
$salt = 'XyZzy12*_'; 	
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
 // Pw is php123

//$failure = false;  // If we have no POST data


// 1. POST (Old way / Bad way : Post -> Get)
// Check the email and password from the database
// Check to see if we have some POST data, if we do, process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) 
{
		/*
		// Useless
		unset($_SESSION["who"]);
		unset($_SESSION["pw"]); // unset current "who" sessions variable
		*/

		// Use of placeholders to avoid SQL injection with SQL concatenation
		$sql = "SELECT name FROM users 
	        WHERE email = :em AND password = :pw";  

	    // PRO TIP for debugging    
	    //echo "<p>$sql</p>\n";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	    	':em' => $_POST['email'], 
	    	':pw' => $_POST['pass']));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    // PRO TIP for debugging
    /*
    var_dump($row);
    if ( $row === FALSE ) {
    	echo "<h1>Login incorrect.</h1>\n";
    } else { 
    	echo "<p>Login success.</p>\n";
    }    
    */
    
    

    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) 
	{ 
		// Check the length of the login and the password
		//$failure = "Email and password are required";
		$_SESSION["error"] = "Email and password are required";
		header('Location: login.php');
		return;
		
	}
	else 
	{
		//Problem: this also give a failure if I forget " . "
		//Check the format of the email given by the user
		/*
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
		{
	  		$failure = "Email must have an at-sign (@)";
		}
		*/

		$email = $_POST['email'];

		if(strpos($email, '@') === false) 
		{
	  		//$failure = "Email must have an at-sign (@)";
	  		$_SESSION["error"] = "Email must have an at-sign (@)";
	  		//unset($_SESSION["error"]);
	  		header( 'Location: login.php');
	  		error_log("Login fail ".$_POST['email']);
            return;
		}

		/*
		
		*/

		else
		{
			$check = hash('md5', $salt.$_POST['pass']); // Hash the password
			if ( $check == $stored_hash ) 
			{
	            /*
				header("Location: autos.php?email=".urlencode($_POST['who']));
				*/
				// 2. REDIRECTION

				// Redirect the browser to view.php
				$_SESSION["name"] = $_POST["email"];
            	$_SESSION["success"] = "Logged in.";
				//header("Location: view.php");
				//header("Location: index.php?email=".urlencode($_POST['email']));
                header("Location: index.php");


				error_log("Login success ".$_POST['email']); // Send an success msg to the error_log file (file location on phpinfo.php -> erro_log)
				return;
			} 
			
			else
			{
				//$failure = "Incorrect password";
				$_SESSION["error"] = "Incorrect password.";
				error_log("Login fail ".$_POST['email']." $check");
				header( 'Location: login.php' ) ;
	        	return;
			}

			
		}
	}
}

// View 
?>
<!DOCTYPE html>
<html>
<head>
	<?php 
	require_once "bootstrap.php"; 
	require_once "pdo.php";
	?>
	<title>Dindar Ali</title>

</head>
<body>
	<div class="container">
		<h1>Please Log In</h1>
		<?php

// Note triple not equals and think how badly double
// not equals would work here...

		/*
		if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
			echo('<p style="color: red;">'.htmlentities($failure)."</p>\n"); 
		}
		*/

		if ( isset($_SESSION["error"]) ) 
		{
   		 	echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
   		 	/* unset the variable so the error message appear only one time even if the user click the refresh button */
	        unset($_SESSION["error"]);
		}
		if (isset($_SESSION["success"]))
		{
			echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
			unset($_SESSION["success"]);
		}
		?>

		<form method="POST">
			<label for="nam">User Name</label>
			<input type="text" name="email" id="nam"><br/>
			<label for="id_1723">Password</label>
			<input type="text" name="pass" id="id_1723"><br/>
			<input type="submit" value="Log In">
			<input type="submit" name="cancel" value="Cancel">
		</form>
		<p>
			For a password hint, view source and find a password hint
			in the HTML comments.
<!-- Hint: The password is the four character sound a cat
	makes (all lower case) followed by 123. -->
</p>
</div>
</body>
</html>

