<!-- Given Code l.2 -> l.16 -->
<?php // line 1 added to enable color highlight
	session_start(); // Required for $_SESSION variables
	require_once "pdo.php";
	//require_once "bootstrap.php";

	if ( ! isset($_SESSION['email']) ) 
	{
		die('ACCESS DENIED');
	}

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
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']))
    {
        // 2. Verify if the variables (profile) exist
        if(     strlen($_POST['first_name']) < 1 
            ||  strlen($_POST['last_name']) < 1
            ||  strlen($_POST['email']) < 1
            ||  strlen($_POST['headline']) < 1 
            ||  strlen($_POST['summary']) < 1 )

        {
            //$failure = "Make is required";
            $_SESSION["error"] = "All field are required";
            header("Location: add.php");
            return;
        }

        // 3. Email verification
        
        else 
        {
            // Variable declaration for the Post - Redirect - Get cycle

            $profile_id = $_SESSION['profile_id'];
            //$user_id = $_SESSION['user_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $headline = $_POST['headline'];
            $summary = $_POST['summary'];

            if(strpos($email, '@') === false) 
            {
                //$failure = "Email must have an at-sign (@)";
                $_SESSION["error"] = "Email must have an at-sign (@)";
                //unset($_SESSION["error"]);
                header( 'Location: add.php');
                error_log("Login fail ".$_POST['email']);
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

                    $sql = 'INSERT INTO profile
                    (   user_id, 
                        first_name, 
                        last_name, 
                        email, 
                        headline, 
                        summary  )
                        
                    VALUES (:uid, :fn, :ln, :em, :he, :su)';


                   echo("<pre>\n".$sql."\n</pre>\n");
				   $stmt = $pdo->prepare($sql);
				   $stmt->execute(array(
                  //':pid' => $_SESSION['profile_id'],
                  ':uid' => $_SESSION['user_id'],
				  ':fn' => $_POST['first_name'],
				  ':ln' => $_POST['last_name'],
				  ':em' => $_POST['email'],
				  ':he' => $_POST['headline'],
				  ':su' => $_POST['summary']));

                    
                    /*
			    	$_SESSION("add") = $_POST("add");
				    $stmt = $pdo->query("SELECT first_name, headline FROM profile");
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
?>

<!-- VIEW -->
<!DOCTYPE html>
    <head>
    	<title>Dindar Ali</title>
        <?php
        if(isset($_SESSION["error"]))
        {
            echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
            unset($_SESSION["error"]);
        }      
        ?>
    </head>
    <body>
    	<div class="container">
    	<h1>Adding Profile for UMSI</h1>
    	<form method="POST">
    		<p>
                    <label for="fir">First Name: </label>
                    <input type="text" name="first_name" id="id_fi">
                </p>
                <p>
                    <label for="las">Last Name: </label>
                    <input type="text" name="last_name" id="id_la">
                </p>
                <p>
                    <label for="ema">Email: </label>
                    <input type="text" name="email" id="id_em">
                </p>

                 <p>
                    <label for="hea">Headline: </label><br>
                    <input type="text" name="headline" id="id_he">
                </p>

                <p>
                    <label for="sum">Summary: </label><br>
                    <input type="text" name="summary" id="id_su">

                    <!-- <form method="POST" id="testformid"> -->
        				<!-- <input type="submit" /> -->
        				<!-- 
        				<p><textarea form ="testformid" name="taname" id="taid" rows="10" cols="80" wrap="soft"></textarea></p>
        				-->
    			<p>
    				<!-- 
    				<textarea form ="testformid" name="summary" id="taid" rows="10" cols="80" wrap="soft"></textarea></p>
    				-->

            		<input type="submit" name="add" value="Add">
    	        	<input type="submit" name="logout" value="Cancel">
    	        	<a href="index.php"></a>
    	            </input>

                	<!-- </form> -->
                </p>
    	</form>
    	</div>
    </body>
</html>