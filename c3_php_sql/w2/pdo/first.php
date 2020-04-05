<?php

/* In production, we will need to shut down the error message 
Here the user and password is given if we have a bug! */


echo "<pre>\n";
/*$pdo = new PDO('mysql:host=localhost;port=8889;dbname=misc',
    'fred', 'zap');*/
    /* 
    - localhost prevent theoritically security holes from outside unless our computer totally compromised.
    */
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc',
    'root', 'root');

$stmt = $pdo->query("SELECT * FROM users");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); /* Do a loop a look for all the rows that will be retrieve */
print_r($rows);

echo "</pre>\n";


