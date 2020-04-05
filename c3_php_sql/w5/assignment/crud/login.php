<?php
    session_start();
    require_once "bootstrap.php";
    if ( isset($_POST["email"]) && isset($_POST["pass"]) ) {
        // Why do we need to unset the $_SESSION[] variable?
        // unset($_SESSION["user_id"]);  
        if ( $_POST['pass'] == 'php123' ) {
            
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["success"] = "Logged in.";
            header( 'Location: index.php' ) ;

            return;
        } 
        
        else {        // Repeat the process
            $_SESSION["error"] = "Incorrect password.";
            header( 'Location: login.php' ) ;
            return;
        }
    }
?>
<html>
<head>
</head>
<body style="font-family: sans-serif;">
    <div class="container">
        <h1>Please Log in</h1>
        <?php
            if ( isset($_SESSION["error"]) ) 
            {
                echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
                unset($_SESSION["error"]);
            }
        ?>
        <form method="post">
        <p>Account: <input type="text" name="email" value=""></p>
        <p>Password: <input type="password" name="pass" value=""></p>
        <!-- password is umsi -->
        <p><input type="submit" value="Log In">
        <a href="index.php">Cancel</a></p>
        </form>
    </div>
</body>
