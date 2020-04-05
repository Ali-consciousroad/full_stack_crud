
<!-- CREATE -->
<!-- MODEL --> 
<?php
	session_start();
	require_once "pdo.php";

	if ( ! isset($_SESSION['email']) ) 
	    {
	    	die('ACCESS DENIED');
		}
	//if (!isset($_['email']) || (strlen($_GET['email']) < 1))
	if (!isset($_SESSION['email']) || (strlen($_SESSION['email']) < 1))
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
    if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model']))
    {
        // 2. Verify if make variable exist
        if(     strlen($_POST['make']) < 1 
            ||  strlen($_POST['model']) < 1
            ||  strlen($_POST['year']) < 1
            ||  strlen($_POST['mileage']) < 1 )
        {
            //$failure = "Make is required";
            $_SESSION["error"] = "All field are required";
            header("Location: add.php");
            return;
        }

        // 3. Verfiy if year and mileage are numbers
        else 
        {
            // Variable declaration for the Post - Redirect - Get cycle
            $year = $_POST['year'];
            $mileage = $_POST['mileage'];
            $make = $_POST['make'];
            $model = $_POST['model'];
            //$user_id = $_SESSION['user_id'];
            $autos_id = $_SESSION['autos_id'];
            
            

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
	                $sql =  "INSERT INTO autos 
                    (   make, 
                        model, 
                        year, 
                        mileage) 
	                        
                            VALUES 
                    (:mk, :md, :yr, :ml)";
	                
	                echo("<pre>\n".$sql."\n</pre>\n");
	                $stmt = $pdo->prepare($sql);
	                $stmt->execute(array(
	                ':mk' => $_POST['make'],
                    ':md' => $_POST['model'],    
	                ':yr' => $_POST['year'],
	                ':ml' => $_POST['mileage'])); 
			    	
                    /*
			    	$_SESSION("add") = $_POST("add");
				    $stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos");
				    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				    */
				    $_SESSION["success"] = "Record added";
				    header("Location: index.php");
                    echo('<p style="color:green">'.$_SESSION["error"]."</p>\n");
                    unset($_SESSION["error"]);
				    return;
				}
            }
        }
    }

    /*
    // Allow to delete the rows
    if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) 
    {
        $sql = "DELETE FROM autos WHERE autos_id = :zip";
        echo "<pre>\n$sql\n</pre>\n";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_POST['autos_id']));
    }
    */
    

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
                <label for="yea">Year: </label>
                <input type="text" name="year" id="id_y">
            </p>
            <p>
                <label for="mil">Mileage: </label>
                <input type="text" name="mileage" id="id_m">
            </p>

             <p>
                <label for="mod">Model: </label>
                <input type="text" name="model" id="mod">
            </p>


            	<input type="submit" name="add" value="Add New Entry">
            	<input type="submit" name="logout" value="Logout">
        </form>       
	</body>
</html>