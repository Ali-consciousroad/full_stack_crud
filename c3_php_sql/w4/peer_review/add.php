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

    if (isset($_POST['add'])) {
        unset($_SESSION['make']);
        unset($_SESSION['year']);
        unset($_SESSION['mileage']);

        $make = htmlentities($_POST['make']);
        $year = htmlentities($_POST['year']);
        $mileage = htmlentities($_POST['mileage']);

        if (! is_numeric($year) || (! is_numeric($mileage)) || strlen($year) < 1 || strlen($mileage) < 1) {
            $_SESSION['failure'] = 'Mileage and year must be numeric';
            header('Location: add.php');
            return;
        } else if ( strlen($make) < 1 ) {
            $_SESSION['failure'] = 'Make is required';
            header('Location: add.php');
            return;
        } else {
            // Insert into table
            $_SESSION['make'] = $make;
            $_SESSION['year'] = $year;
            $_SESSION['mileage'] = $mileage;

            $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
                    $stmt->execute(array(
                        ':mk' => $make,
                        ':yr' => $year,
                        ':mi' => $mileage)
            );
            $_SESSION['success'] = 'Record inserted';
            // Navigate back
            header('Location:view.php');
            return;
        }
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rui Pan's Automobile Tracker</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <h1>Tracking Autos for <?= htmlentities($_SESSION['who']); ?></h1>

        <?php
        if (isset($_SESSION['failure']) ) {
            echo('<p style="color:red">'.htmlentities($_SESSION['failure'])."</p>\n");
            unset($_SESSION['failure']);
        }
        ?>

        <form method="post">
            <p>Make:
                <input type="text" name="make" size="60"/></p>
            <p>Year:
                <input type="text" name="year"/></p>
            <p>Mileage:
                <input type="text" name="mileage"/></p>
            <input type="submit" name="add" value="Add">
            <input type="submit" name="logout" value="Logout">
        </form>


    </div>
</body>
</html>