
<!-- MODEL --> 
<?php
	session_start();
	require_once "pdo.php";


	if ( ! isset($_SESSION['name']) ) 
	    {
	    	die('Not logged in');
		}
	//if (!isset($_['email']) || (strlen($_GET['email']) < 1))
	if (!isset($_SESSION['name']) || (strlen($_SESSION['name']) < 1))
	{
        die('Name parameter missing');
    }    
    

    // If the user requested logout go back to index.php
    if ( isset($_POST['logout']) ) 
    {
        header('Location: index.php');
        return;
    }

    //$failure = false; // if no post data
    // Add the input in the autos table
    // Check if inpu
    // 1. Verify if variables are set.
    if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']))
    {
        // 2. Verify if make variable exist
        if(strlen($_POST['make']) < 1)
        {
            //$failure = "Make is required";
            $_SESSION["error"] = "Make is required";
            header("Location: add.php");
            return;
        }

        // 3. Verfiy if year and mileage are numbers
        else 
        {
            $year = $_POST['year'];
            $mileage = $_POST['mileage'];

            if(!is_numeric($year) || !is_numeric($mileage))
            {
                //$failure = "Mileage and year must be numeric";
                $_SESSION["error"] = "Mileage and year must be numeric";
                header("Location: add.php");
                return; 
            }

            // Insert the value if all conditions are met.
            else 
            {       
                  
                //$failure = "Record inserted";
                //$_SESSION["success"] = "Record inserted";
                //header("Location: view.php");

                
                if (isset($_POST['add']))
			    {	
			    	

			    	$_SESSION['add'] = $_POST['add'];
			    	// Use of placeholders to avoid SQL injection with SQL concatenation
	                $sql =  "INSERT INTO autos (make, year, mileage) 
	                        VALUES (:mk, :yr, :ml)";
	                
	                echo("<pre>\n".$sql."\n</pre>\n");
	                $stmt = $pdo->prepare($sql);
	                $stmt->execute(array(
	                ':mk' => $_POST['make'],
	                ':yr' => $_POST['year'],
	                ':ml' => $_POST['mileage']));     
			    	/*
			    	$_SESSION("add") = $_POST("add");
				    $stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos");
				    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				    */
				    
				    $_SESSION["success"] = "Record inserted";
				    header("Location: view.php");
				    return;
				}
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
?>

<!-- VIEW -->
<!DOCTYPE html>
	<head>
		<title>Dindar Ali</title>
		<?php 
			require_once "pdo.php";
			require_once "bootstrap.php"; 

			// Note triple not equals and think how badly double
			// not equals would work here...
			/*
			if ( $failure !== false ) {
			// Look closely at the use of single and double quotes
			echo('<p style="color: red;">'.htmlentities($failure)."</p>\n"); 
			*/
			if(isset($_SESSION["error"]))
			{
				echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
				unset($_SESSION["error"]);
			}
		?>
	</head>
	<body>
		<div class="container">    
		<h1>Tracking Autos for</h1>
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
	</body>
</html>