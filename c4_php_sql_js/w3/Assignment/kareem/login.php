<?php
session_start();
require_once "pdo.php";
if (isset($_POST['cancel'])) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}
$salt = 'XyZzy12*_';

if (isset($_POST['email']) && isset($_POST['pass'])) {
      $check = hash('md5', $salt.$_POST['pass']);
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = "User name and password are required";
    } else if (strpos($_POST['email'], "@") === false) {
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
    } else {
        $stmt= $pdo->prepare('SELECT user_id , name from users where email=:email AND password=:pass');
        $stmt->execute( array(
          ":email"=>$_POST['email'],
          ":pass" =>$check
        ));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            error_log("Login success ".$_POST['email']);
            $_SESSION['name'] = $_POST['email'];
            $_SESSION['user_id']=$row['user_id'];
            header("Location: index.php");
            return;
        } else {
            $_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
            header("Location: login.php");
        }
    }
}
// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Autos Database Kareem Emad</title>
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">

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
        User Name <input type="text" name="email" id="email"><br/>
        Password <input type="text" name="pass" id="id_1723"><br/>
        <input type="submit" onclick="return doValidate();" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p>
        For a password hint, view source and find a password hint
        in the HTML comments.
        <!-- Hint: The password is the four character sound a cat
        makes (all lower case) followed by 123. -->
    </p>
    <script>
    function doValidate() {
        console.log('Validating...');
          try {
em = document.getElementById('email').value;
pw = document.getElementById('id_1723').value;

console.log("Validating pw="+pw+"em="+em);
if (pw == null || pw == ""|| em == ""|| em == null ) {

alert("Both fields must be filled out");

return false;
}
if(em.indexOf('@')==-1){
alert("Invalid Email Address");
return false;
}
return true;

} catch(e) {

return false;

}

return false;

}

    </script>
</div>
</body>