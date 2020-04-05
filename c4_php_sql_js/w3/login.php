<?php
    require_once "bootstrap.php";
    require_once "pdo.php";
    session_start();

    if ( isset($_POST["email"]) && isset($_POST["pass"]) ) 
    {
        
        // PRO TIP for debugging
        
        var_dump($row);
        if ( $row === FALSE ) {
            echo "<h1>Login incorrect.</h1>\n";
        } else { 
            echo "<p>Login success.</p>\n";
        }    

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

            else
            {
                $salt = 'XyZzy12*_';
                $check = hash('md5', $salt.$_POST['pass']);

                $stmt = $pdo->prepare(
                    'SELECT user_id, name 
                     FROM users
                     WHERE email = :em 
                     AND password = :pw');

                $stmt->execute(array( 
                    ':em' => $_POST['email'], 
                    ':pw' => $check));

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                //var_dump($row);

                if ( $row !== false ) 
                {   $_SESSION['name'] = $row['name'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['email'] = $_POST['email']; // Needed or that does not work!
                    // Redirect the browser to index.php
                    header("Location: index.php");
                    return;     
                }

                else 
                {   
                    // Repeat the process
                    $_SESSION["error"] = "Incorrect Information";
                    header( 'Location: login.php' ) ;
                    return;
                }
            }
        }
    }
?>

<html>
<head>
</head>
    <style>
        a:link, a:hover{
            text-decoration: none;
            color: black;
        }
    </style>
<body style="font-family: sans-serif;">
    <div class="container">
        <h1>Please Log in</h1>
        <?php
            if (isset($_SESSION["error"])) {
                echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
                unset($_SESSION["error"]);
            }
        ?>
        <form method="post">
            <p><strong>Email </strong><input type="text" name="email" id="id_mail"></p>
            <p>
            <strong>Password </strong><input type="password" name="pass" id="id_pass"></p>
            <!-- password is umsi -->
            <p><input type="submit" onclick="return doValidate();" value="Log In">
            <a href="index.php">
                <input type="button" value="Cancel">
            </a>
        </form>
        <p>
             For a password hint, view source and find an account and password hint in the HTML comments. 
        </p>
    </div>

<!-- JavaScript -->
<!-- Given code -->
<script type="text/javascript">
    function doValidate() {
    console.log('Validating...');
    try {
        ml = document.getElementById('id_mail').value;
        pw = document.getElementById('id_pass').value;
        console.log("Validating pw="+pw);
        if (pw == null || pw == "" || ml == null || ml == "") {
            alert("Both fields must be filled out");
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
</html>