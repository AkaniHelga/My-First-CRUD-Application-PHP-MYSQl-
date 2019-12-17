<?php
// Include config file
require_once "db_connection.php";
 
// Define variables and initialize with empty values
$brand_name = $brand_code = $brand_status = $price = "";
$brand_name_err = $brand_code_err = $brand_status_err = $price_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate brand name
    $input_brand_name = trim($_POST["brand_name"]);
    if(empty($input_brand_name)){
        $brand_name_err = "Please enter name of brand.";
    } elseif(!filter_var($input_brand_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $brand_name_err = "Please enter a valid name.";
    } else{
        $brand_name = $input_brand_name;
    }
    
    // Validate brand code
    $input_brand_code = trim($_POST["brand_code"]);
    if(empty($input_brand_code)){
        $brand_code_err = "Please enter brand_code";     
    } else{
        $brand_code = $input_brand_code;
    }
    
    // Validate brand status
    $input_brand_status = trim($_POST["brand_status"]);
    if(empty($input_brand_status)){
        $brand_status_err = "Please state brand availability.";     
    } else{
        $brand_status = $input_brand_status;
    }

      // Validate brand code
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter price";     
    } else{
        $price = $input_price;
    }

    
    // Check input errors before inserting in database
    if(empty($brand_name_err) && empty($brand_code_err) && empty($brand_status_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO brand (brand_name, brand_code, brand_status, price) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisi", $param_brand_name,  $param_brand_code, $param_brand_status, $param_price);
            
            // Set parameters
            $param_brand_name = $brand_name;
            $param_brand_code = $brand_code;
            $param_brand_status = $brand_status;
            $param_price = $price;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: brand.php");
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
                        <h2>Create Brand Record</h2>
                    </div>
                    <p> Fill this form and submit to add a new brand.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($brand_name_err)) ? 'has-error' : ''; ?>">
                            <label>Brand Name</label>
                            <input type="text" name="brand_name" class="form-control" value="<?php echo $brand_name; ?>">
                            <span class="help-block"><?php echo $brand_name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($brand_code_err)) ? 'has-error' : ''; ?>">
                            <label>Brand Code</label>
                            <input type="number" name="brand_code" class="form-control" value="<?php echo $brand_code; ?>">
                            <span class="help-block"><?php echo $brand_code_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($brand_status_err)) ? 'has-error' : ''; ?>">
                            <label>Brand Status</label>
                            <select  name="brand_status" id="" value="<?php echo $brand_status; ?>">
                                <option value="">Please Select</option>
                                <option value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>  
                            </select>
                            <span class="help-block"><?php echo $brand_status_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Price ($)</label>
                            <input type="number" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-secondary" value="Submit">
                        <a href="brand.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>