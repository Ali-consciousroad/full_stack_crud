<!-- MODEL -->
<?php
    require_once "pdo.php";

    // Demand a GET parameter (for the mail)
    // Problem soved getting "Name parameter missing no matter what"
    /*
    my get variable didnt match

    header("Location: autos.php?email=".urlencode($_POST['who']));

    I used to write 'who' instead of 'email'.
    
    This caused the problem.
    */
    if (!isset($_GET['email']) || (strlen($_GET['email']) < 1)) 
    {
        die('Name parameter missing');
    }    
    

    // If the user requested logout go back to index.php
    if ( isset($_POST['logout']) ) {
        header('Location: index.php');
        return;
    }

    $failure = false; // if no post data

    // Add the input in the autos table
    // Check if inpu
    // 1. Verify if variables are set.
    if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']))
    {
        // 2. Verify if make variable exist
        if(strlen($_POST['make']) < 1)
        {
            $failure = "Make is required";
        }

        // 3. Verfiy if year and mileage are numbers
        else 
        {
            $year = $_POST['year'];
            $mileage = $_POST['mileage'];

            if(!is_numeric($year) || !is_numeric($mileage))
            {
                $failure = "Mileage and year must be numeric";
            }

            // Insert the value if all conditions are met.
            else 
            {       
                // Prevent SQL injection
                // Use of placeholders to avoid SQL injection.
                // SQL concatenation should be avoided!!!
                $sql =  "INSERT INTO autos (make, year, mileage) 
                        VALUES (:mk, :yr, :ml)";
                
                echo("<pre>\n".$sql."\n</pre>\n");
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':yr' => $_POST['year'],
                ':ml' => $_POST['mileage']));       

                $failure = "Record inserted";
            }
        }
    }

    // Allow to delete the rows
    
    if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) 
    {
        $sql = "DELETE FROM autos WHERE auto_id = :zip";
        echo "<pre>\n$sql\n</pre>\n";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_POST['auto_id']));
    }
    

    // If the user requested logout go back to index.php
    if ( isset($_POST['logout']) ) 
    {
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
?>

<!-- VIEW -->
<!DOCTYPE html>
    <head>
    	<title>Dindar Ali</title>
    	<?php 
        require_once "bootstrap.php"; 
        ?>
    </head>
    <body>
    	<div class="container">
    	<h1>Tracking Autos for </h1>
    	

        <?php
            
        	if (isset($_REQUEST['who'])) 
        	{
        	    echo "<h1>".htmlentities($_REQUEST['who'])."</h1>"; // Prevent HTML injection on 'name' (for data given by the user)
        	    echo "</p>\n";
            }
            
            
            
            /*

            else if(!(is_numeric('year') || is_numeric('mileage')))
            {
                $failure = "Mileage and year must be numeric";
            }
            */
            

            if ($failure === false){
                    echo('<p style="color: green;">'.$failure."</p>\n");
            }


            if ($failure !== false){
                // Look closely at the use of single and double quotes
                echo('<p style="color: red;">'.$failure."</p>\n");
            }

            /*
            else if ($failure === false) 
            {
                echo('<p style="color: green;">'.'Record inserted'."</p>\n");
            }
            */
        ?>

        
        <form method="POST">
            <p>
                <label for="mak">Make: </label>
                <input type="text" name="make" id="mak">
            </p>
            <p>
                <label for="mak">Year: </label>
                <input type="text" name="year" id="id_y">
            </p>
            <p>
                <label for="mak">Mileage: </label>
                <input type="text" name="mileage" id="id_m">
            </p>
            	<input type="submit" name="add" value="Add">
            	<input type="submit" name="logout" value="Logout">
        </form>


        <h1>Automobiles</h1>
        

        <!-- <table border="1"> -->
        
        <?php
        foreach ( $rows as $row ) 
        {
            // htmlentities prevent HTML injection by the user 
            echo "<ul><li>";
            echo(htmlentities($row['year']." "));
            echo(htmlentities($row['make']. " / "));
            echo(htmlentities($row['mileage']));
            
            // Allow to delete rows from the screen
            /*
            echo('<form method="post"><input type="hidden" ');
            echo('name="auto_id" value="'.$row['auto_id'].'">'."\n");
            echo('<input type="submit" value="Del" name="delete">');
            echo("\n</form>\n");
            */
            echo("</li></ul>\n");

        }
        ?>
</body>
</html>