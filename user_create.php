<?php
// Include config file
require_once "db_connection.php";
 
// Define variables and initialize with empty values
$username = $useremail = $usertype = "";
$username_err = $useremail_err = $usertype_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate brand name
    $input_username = trim($_POST["username"]);
    if(empty($input_username)){
        $username_err = "Please enter name of brand.";
    } elseif(!filter_var($input_username, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $username_err = "Please enter a valid name.";
    } else{
        $username = $input_username;
    }
    
    // Validate brand id
    $input_useremail = trim($_POST["useremail"]);
    if(empty($input_useremail)){
        $useremail_err = "Please enter brand ID";     
    } else{
        $useremail = $input_useremail;
    }
    
    // Validate brand status
    $input_usertype = trim($_POST["usertype"]);
    if(empty($input_usertype)){
        $usertype_err = "Please state brand availability.";     
    } else{
        $usertype = $input_usertype;
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($useremail_err) && empty($username_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, useremail, usertype) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username,  $param_useremail, $param_usertype);
            
            // Set parameters
            $param_username = $username;
            $param_useremail = $useremail;
            $param_usertype = $usertype;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: user.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link href="https://fonts.googleapis.com/css?family=Orbitron&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Add a User</h2>
                    </div>
                    <p> Fill this form and submit to add a new brand.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>User Name</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($useremail_err)) ? 'has-error' : ''; ?>">
                            <label>User Email</label>
                            <input type="text" name="useremail" class="form-control" value="<?php echo $useremail; ?>">
                            <span class="help-block"><?php echo $useremail_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($usertype_err)) ? 'has-error' : ''; ?>">
                            <label>User Type</label>
                            <select  name="usertype" id="" value="<?php echo $usertype; ?>">
                                <option value="">Please Select</option>
                                <option value="Master">Master</option>
                                <option value="User">User</option>                             
                            </select>
                            <span class="help-block"><?php echo $usertype_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-secondary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>