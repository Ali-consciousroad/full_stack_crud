<!--UPDATE -->
<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['email']) ) 
{
    die('ACCESS DENIED');
}

// Verify if all data are set
if ( isset($_POST['first_name']) && isset($_POST['last_name'])
 && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) 
{
    // Data validation
    if (    strlen($_POST['first_name']) < 1 
        ||  strlen($_POST['last_name']) < 1
        ||  strlen($_POST['email']) < 1
        ||  strlen($_POST['headline']) < 1
        ||  strlen($_POST['summary']) < 1 ) 
    {
        $_SESSION['error'] = 'Missing data';
        //header("Location: edit.php?autos_id=".$_POST['autos_id']);
        header("Location: edit.php?profile_id=".$_REQUEST['profile_id']);
        return;
    }


    $email = $_POST['email'];


    if(strpos($email, '@') === false) 
    {

                //$failure = "Email must have an at-sign (@)";
            $_SESSION["error"] = "Email must have an at-sign (@)";
                //unset($_SESSION["error"]);
            //header( 'Location: add.php');
            header("Location: edit.php?profile_id=".$_REQUEST['profile_id']);
            error_log("Login fail ".$_POST['email']);
            return;
    }

   
        $sql = "UPDATE  profile 
        SET     first_name  =   :fn,
        last_name   =   :ln, 
        email       =   :em,
        headline    =   :he,
        summary     =   :su 
        WHERE   profile_id  =   :pid";


    // Stored procedure: prevent SQL injection
    $stmt = $pdo->prepare($sql);

        $a = array(
            ':pid' => $_POST['profile_id'],
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],    
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary']);

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
if ( ! isset($_GET['profile_id']) ) 
{
    $_SESSION['error'] = "Missing profile_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

    // Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$em = htmlentities($row['email']);
$he = htmlentities($row['headline']);
$su = htmlentities($row['summary']);
$pid = $row['profile_id'];
?>
    

<p><h1>Editing Profile</h1></p>
<form method="post">
    <p>First Name:
        <input type="text" name="first_name" value="<?= $fn ?>"></p>
        <p>Last Name:
            <input type="text" name="last_name" value="<?= $ln ?>"></p>
            <p>Email:
                <input type="text" name="email" value="<?= $em ?>"></p>
                <p>Headline:
                    <input type="text" name="headline" value="<?= $he ?>"></p>
                <p>Summary:
                    <input type="text" name="summary" value="<?= $su ?>"></p>

                    <input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
                    <p><input type="submit" value="Save"/></p>

                    <button type="button"><a href="index.php" style="color: black; text-decoration: none;">Cancel</a></button>

                    <!-- <a href="index.php">Cancel</a></p> -->
</form>
