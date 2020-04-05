<?php
    session_start();
    require_once "pdo.php";
    // Protect the database from being modified without the user properly logged in
    // Check the session to see if the user's name is set
    // If the user's name is not present, the view.php must stop immediately using the PHP die() function
    if ( ! isset($_SESSION['email']) ) {
        die('Not logged in');
    }


    // If the user requested logout, navigate back to index.php
    if ( isset($_POST['logout']) ) {
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->query("SELECT make, year, mileage FROM autos ORDER BY make");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Rui Pan</title>
        <?php require_once "bootstrap.php"; ?>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1><?php
            if ( isset($_SESSION['name']) ) {
                echo "Tracking Autos for ";
                echo htmlentities($_SESSION['name']);
                echo "\n";
            }
            ?></h1>

            

            <h2>Automobiles</h2>

            <?php
                // Prints out the table
                foreach ($rows as $row) {
                    echo "<ul><li>";
                    echo ($row['year']);
                    echo " ";
                    echo ($row['make']);
                    echo " ";
                    echo "/";
                    echo " ";
                    echo ($row['mileage']);
                    echo "</li></ul>\n";
                }
            ?>

            <p>
                <a href="add.php">Add New</a> |
                <a href="logout.php">Logout</a>
            </p>
        </div>
</body>
</html>