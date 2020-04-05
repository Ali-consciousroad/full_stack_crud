<?php
require_once "pdo.php";

// NEVER EVER use SQL concatenation or SQL injection will be possible!
// => Login even without knowing the right password!


// p' OR '1' = '1      Allow to access the data without knowing the password!
/* This is possible because of SQL concatenation!
Use placeholders to avoid this! Cf. login2.php */

if ( isset($_POST['email']) && isset($_POST['password'])  ) {
  echo("<p>Handling POST data...</p>\n");
  $e = $_POST['email'];
  $p = $_POST['password'];

  $sql =  " SELECT name FROM users
  WHERE email = '$e'
  AND password = '$p'  ";

  echo "<p>$sql</p>\n";

  $stmt = $pdo->query($sql);

  // Debugging tool 
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  var_dump($row);
  
  echo "-->\n";
  if ( $row === FALSE ) {
   echo "<h1>Login incorrect.</h1>\n";
 } else {
   echo "<p>Login success.</p>\n";
 }
}
?>

<!-- FORM (view) -->
<p>Please Login</p>
<form method="post">
  <p>Email:
    <input type="text" size="40" name="email"></p>
    <p>Password:
      <input type="text" size="40" name="password"></p>
      <p><input type="submit" value="Login"/>
        <a href="<?php echo($_SERVER['PHP_SELF']);?>">Refresh</a></p>
      </form>
      <p>
        Check out this
        <a href="http://xkcd.com/327/" target="_blank">XKCD comic that is relevant</a>.
