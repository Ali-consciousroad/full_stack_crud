<?php
session_start();
unset($_SESSION['name']);// to log user out
unset($_SESSION['user_id']);//to log user out
require_once "pdo.php";

if (isset($_POST['cancel'])) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';

if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = "Email and password are required";
		header("Location: login.php");
		return;
    } 
	
$check = hash('md5', $salt.$_POST['pass']);
$stmt = $pdo->prepare('SELECT user_id, name FROM users
    WHERE email = :em AND password = :pw');
$stmt -> execute ( array( ':em' => $_POST['email'], ':pw' => $check));

$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
        if ($row !== false) {
            $_SESSION['name'] = $row['name'];
			$_SESSION['user_id']= $row['user_id'];
            header("Location: index.php");
            return;
			
        } else {
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
        }

}
// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Welcome to Autos Database Eva Huang</title>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>
    <?php
    if ( isset($_SESSION['error']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <form method="POST" action="login.php">
        User Name <input type="text" name="email"><br/>
        Password <input type="text" name="pass" id="id_1723"><br/>
        <input type="submit" onClick="return doValidate();" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p>
        For a password hint, view source and find a password hint in the HTML comments.
        <!-- Hint: The password is the four character sound a cat
        makes (all lower case) followed by 123. -->
    </p>
</div>
<script>
	
	function doValidate() {
    console.log('Validating...');
    try {
		addr-document.getElementById('email').value;
        pw = document.getElementById('id_1723').value;
        console.log("Validating pw="+pw);
        if (addr == null || adde == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
		if (addr.indexof("@")== -1){
			alert("Invalid email address")
			return false;
		}
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>
</body>