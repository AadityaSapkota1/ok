<?php
// Include config file
require_once "config.php";

//Define variables and initialize with empty values
$product_name = $cost =  "";
$product_name_err = $cost_err =  "";
// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    




//Validate first name
    $input_product_name = trim($_POST["product_name"]);
    if (empty($input_product_name)) {
        $product_name_err = "Please enter product name";
        echo "Please enter a name.";
    } 
     else {
        $product_name = $input_product_name;
    }
    
    $input_code = trim($_POST["code"]);
    if (empty($input_code)) {
        echo "Please enter code";
    } 
     else {
        $code= $input_code;
    }


    $input_cost = trim($_POST["cost"]);
    if (empty($input_cost)) {
        $cost_err = "Please enter a last name";
        echo "Please enter a last name.";
    } 

    else {
        $cost = $input_cost;
    }


// Check input errors before inserting in database
    if (empty($product_name_err) && empty($cost_err) && empty($email_err)) {

        // Prepare an update statement
        


            $sql = "UPDATE products SET product_name=?, code=?, cost=? WHERE id=?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssi", $param_product_name, $param_code, $param_cost, $param_id);


                // Set parameters
                $param_product_name = $product_name;
                $param_code = $code;
                $param_cost = $cost;
                $param_id = $id;
            }
       
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {


            // Records updated successfully. Redirect to landing page
            header("location: view.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }


// Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);


        // Prepare a select statement
        $sql = "SELECT * FROM products WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);


            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);


                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result);

                    // Retrieve individual field value
                    $product_name = $row["product_name"];
                    $code = $row["code"];
                    $cost = $row["cost"];
                   

                } else {


                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="store.css?v=<?php echo time();?>">
    <title>Edit Data</title>
</head>
<body>
<div class="nav-bar">


<ul class="nav-links">
    <li> <a href="store.php"> Store </a></li>
    <li> <a href="registration/logout.php"> Logout </a></li>


</ul>


</div>

<br><br>
<form class="form-group" method="post" action="" enctype="multipart/form-data">
    <input type="text"class="form-control" name="product_name" value="<?php echo $product_name; ?>"<br><br>
    <input type="text"class="form-control" name="code" value="<?php echo $code; ?>"<br><br>
    <input type="text" name="cost" class="form-control" value="<?php echo $cost; ?>"<br><br>
    <input type="file" class="form-control" name="image"><br><br><?php echo $image; ?><br>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="submit" class="btn btn-primary" value="update">
</form>

</body>
</html>