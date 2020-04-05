<!-- Model: The brain -->
<?php // Do not put any HTML above this line
require_once "pdo.php";

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
	header('Location: index.php');
	return;
}

// More information on MD5.My-Addr.com about MD5 Database, hash etc.
$salt = 'XyZzy12*_'; 	
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
// Password: php123 -> Later, we will learn to store the password in a database

$failure = false;  // If we have no POST data

// Check the email and password from the database
// Check to see if we have some POST data, if we do, process it
if (isset($_POST['who']) && isset($_POST['pass']) ) 
{
		// Use of placeholders to avoid SQL injection (NEVER use concatenation!)
		$sql = 	"	SELECT name 
					FROM users 
	        		WHERE email 	= 	:em 
	        		AND password 	= 	:pw    ";  

	    // PRO TIP for debugging    
	    //echo "<p>$sql</p>\n";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	    	':em' => $_POST['who'], 
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
    if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1 ) 
	{ // Check the length of the login and the password
		$failure = "Email and password are required";
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
		$email = $_POST['who'];

		if(strpos($email, '@') === false) 
		{
	  		$failure = "Email must have an at-sign (@)";
	  		error_log("Login fail ".$_POST['who']);
		}

		else
		{
			$check = hash('md5', $salt.$_POST['pass']); // Hash the password
			if ( $check == $stored_hash ) 
			{
	            // Success => Redirect the browser to game.php
				header("Location: autos.php?email=".urlencode($_POST['who']));

				error_log("Login success ".$_POST['who']); // Send an success msg to the error_log file (file location on phpinfo.php -> erro_log)

				return;
			} 
			else 
			{
				$failure = "Incorrect password";
				error_log("Login fail ".$_POST['who']." $check");
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
		if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
			echo('<p style="color: red;">'.htmlentities($failure)."</p>\n"); 
		}
		?>

		<form method="POST">
			<label for="nam">User Name</label>
			<input type="text" name="who" id="nam"><br/>
			<label for="id_1723">Password</label>
			<input type="password" name="pass" id="id_1723"><br/>
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

