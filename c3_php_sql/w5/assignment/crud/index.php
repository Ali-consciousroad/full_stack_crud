<!-- READ -->
<?php
    require_once "pdo.php";
    require_once "bootstrap.php"; 
    session_start();
?>
<html>
<head>
    <title>Dindar Ali</title>
</head>
<body>

    <div class="container">
        <h1>Welcome to Autos Database</h1>
        
        <p>
            <!-- Linkg to add.php -->
            Attempt to  
            <a href="add.php">Add New Entry</a> without logging in 
        </p>
    
    <?php
       //$_GET['user_id'] = $_SESSION['user_id'];
        if ( isset($_SESSION['error']) ) 
        {
            echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
            unset($_SESSION['error']);
        }
        if ( isset($_SESSION['success']) ) 
        {
            echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
            unset($_SESSION['success']);

        }


        if ( ! isset($_SESSION["email"]) ) 
        { 
            ?>
               <p>
                    <a href="login.php">Please log in</a>
                </p>
               <p>
                    <a href="https://www.coursera.org/learn/database-applications-php/supplement/nFiMf/assignment-specification-autos-c-r-u-d" 
                    target="_blank">Assignment specification</a>
                </p>
            <?php 
        } 
    
        else 
        { 
            echo('<table border="1">'."\n");
            
            echo"<tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Mileage</th>
                    <th>Action</th>
                </tr>";
                
                
            $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");    
       
            while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) 
            {
                echo "<tr><td>";
                echo(htmlentities($row['make']));
                echo("</td><td>");
                echo(htmlentities($row['model']));
                echo("</td><td>");
                echo(htmlentities($row['year']));
                echo("</td><td>");
                echo(htmlentities($row['mileage']));
                echo("</td><td>");
                

                echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
                echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                echo("</td></tr>\n");
            }
            ?>
            </table>
            <a href="add.php">Add New Entry</a>
            <p><a href="logout.php">Logout</a></p>
            <p>
                <strong>Note:</strong> Your implementation should retain data across multiple logout/login sessions. This sample implementation clears all its data on logout - which you should not do in your implementation. 
            </p>
        
        <?php 
        }
        ?> 
    
    </div>
</body>
