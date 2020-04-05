<html>
<head>
<title>Dindar Ali</title>
</head>
<body>
<h1>Welcome to my guessing game</h1>
<p>
<?php

 


  if ( ! isset($_GET['guess']) ) {              // Verify if the guess variable is set 
    echo("Missing guess parameter");
  } 

  /*
    $n = $_GET['guess'];
    $n = explode(" ", $_GET['guess']);
    $m = $n[0];
  */

    else if ( strlen($_GET['guess']) < 1 ) {    // strlen() return the length of a String
    echo("Your guess is too short");
  } else if ( ! is_numeric($_GET['guess']) ) {  
    echo("Your guess is not a number");
  } else if ( $_GET['guess'] < 18 ) {
    echo("Your guess is too low");
  } else if ( $_GET['guess'] > 18 ) {
    echo("Your guess is too high");
  } else {
    echo("Congratulations - You are right");
  }
?>
</p>
</body>
</html>
  

