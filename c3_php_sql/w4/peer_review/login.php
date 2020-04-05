<?php // Do not put any HTML above this line
// line added to turn on color syntax highlight
require_once "pdo.php";
session_start();

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123
//$failure = false;  // If we have no POST data


  

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    unset($_SESSION['email']);
    $who = htmlentities($_POST['email']); 
    $pass = htmlentities($_POST['pass']);
    $_SESSION['email'] = $who;
    if ( strlen($who) < 1 || strlen($pass) < 1 ) {
        $_SESSION['error'] = "E-mail address and password are required";
        header('Location: login.php');
        return;
    } else if ( strpos($who, "@") == false ) { // E-mail address doesn't contains an at-sign
        //$failure = "Email must have an at-sign (@)";
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            error_log("Login success ".$who); // log the success login attempt
            // Redirect the browser to view.php
            $_SESSION["success"] = "Logged in."; // ?
            //$_SESSION['name'] = $email;
            header("Location: view.php");
            return;
        } else {
            error_log("Login fail ".$who." $check"); // log the failed login attempt
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
            return;
        }
    }
}
// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Rui Pan</title>
</head>
<body>
    <div class="container">
        <h1>Please Log In</h1>
        <?php
            // Display flash error message (on the next GET request)
            if ( isset($_SESSION['error']) ) {
              echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
              unset($_SESSION['error']);
            }
        ?>

        <form method="POST">
            <label for="nam">E-mail</label>
            <input type="text" name="email" id="nam"><br/>
            <label for="id_1723">Password</label>
            <input type="text" name="pass" id="id_1723"><br/>
            <input type="submit" value="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>
        
        <p>
            For a password hint, view source and find a password hint
            in the HTML comments.
            <!-- Hint: The password is the 3  character language we are learning (all lower case) followed by 123. php123-->
        </p>
    </div>
</body>