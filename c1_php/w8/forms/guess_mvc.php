
<!-- 
KAIZEN

- There is lots of content about MVC model, it may be useful to spend some time learn the basics.
-->

<!-- 
Same code than guess.php but with a simple MVC structure
-->

<!-- CONTROLLER - the route (all the script here) -->
<!-- 
MODEL - the brain

- It will contain most of the php code 
- PHP code that will do the connection with the database etc.

-->
<?php
    $oldguess = '';
    $message = false;
    if ( isset($_POST['guess']) ) {

        // No errori checking here, we can add some by ourselves
        // Trick for integer / numeric parameters
        $oldguess = $_POST['guess'] + 0;
        if ( $oldguess == 42 ) {
            $message = "Great job!";
        } else if ( $oldguess < 42 ) {
            $message = "Too low";
        } else  {
            $message = "Too high...";
        }
    }
?>

<!-- 
VIEW - the blade 
Mostly html code but we can have also some small touch of PHP here and there.
-->
<html>
<head>
    <title>A Guessing game</title>
</head>
<body style="font-family: sans-serif;">
<p>Guessing game...</p>
<?php
   if ( $message !== false )  {
        echo("<p>$message</p>\n");
    }
?>
<form method="post">
   <p><label for="guess">Input Guess</label>
   <input type="text" name="guess" id="guess" size="40"
     value="<?= htmlentities($oldguess) ?>"/></p>
   <input type="submit"/>
</form>
</body>
