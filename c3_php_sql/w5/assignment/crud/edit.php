<!--UPDATE -->
<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['email']) ) {
            die('ACCESS DENIED');
}

if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['mileage']) ) 
{
    // Data validation
    if (    strlen($_POST['make']) < 1 
        ||  strlen($_POST['model']) < 1
        ||  strlen($_POST['year']) < 1
        ||  strlen($_POST['mileage']) < 1 ) 

    {
        $_SESSION['error'] = 'Missing data';
        //header("Location: edit.php?autos_id=".$_POST['autos_id']);
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }
    
            $sql = "UPDATE  autos 
                    SET     make     =   :mk,
                            model    =   :md, 
                            year     =   :yr, 
                            mileage  =   :ml
                    WHERE   autos_id =   :a_id";


    // Stored procedure: prevent SQL injection
    $stmt = $pdo->prepare($sql);
    
    /*
    $stmt->execute(array(
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $_POST['password'],
        ':user_id' => $_POST['user_id']));
        */

    //$_GET['autos_id'] = $row['autos_id']


    $a = array(
        ':a_id' => $_POST['autos_id'],
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],    
        ':yr' => $_POST['year'],
        ':ml' => $_POST['mileage']);

    // Debugging: print the content of the array()
    /*
    echo("<pre>");
         print_r($a); 
    echo("</pre>");
    */
   
    $stmt->execute($a); 

    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}


// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) 
{
    $_SESSION['error'] = "Missing autos_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$mk = htmlentities($row['make']);
$md = htmlentities($row['model']);
$yr = htmlentities($row['year']);
$ml = htmlentities($row['mileage']);
$a_id = $row['autos_id'];
?>

<p>Edit Auto</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $mk ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $md ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $yr ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $ml ?>"></p>

<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
