
<?php
require_once "config.php";

session_start();
if(isset($_SESSION["username"])){
    header("location:login.php");
}



$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                    echo $username_err;
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


    if (empty(trim($_POST['email']))) {
        $email_err = "email cannot be blank";
    } 
    else {
        $email = trim($_POST['email']);
    }


// Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

// Check for confirm password field
    if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
        $password_err = "Passwords should match";
    }


// If there were no errors, go ahead and insert into the database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);

            // Set these parameters
            $param_username = $username;
            $param_email = $_POST["email"];
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                $query = "INSERT INTO bank (username,balance) VALUES (?,?)";
                $smnt = mysqli_prepare($conn,$query);
                if($smnt){
                    mysqli_stmt_bind_param($smnt, "si", $param_name, $param_balance);
                    $param_name = $_POST["username"];
                    $param_balance = 0;
                    if(mysqli_stmt_execute($smnt)){
                        header("location: login.php");
                    }
                }
                
            } 
            
            else {
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }

    

    mysqli_close($conn);
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css?v=<?php echo time();?>" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registration.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    
    <title>Register</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav nav-links">
      <a class="nav-item  nav-link active" href="../index.php">Home </a>
      <a class="nav-item nav-link" href="register.php">Register</a>
      <a class="nav-item nav-link" href="login.php">Login</a>
      
    </div>
  </div>
</nav>
    
        <form action="" class="reg-form form-group" method="post"> 

        
            <label for="username"> Username </label>
            <input type="text" name="username" class="form-control" placeholder="Enter your username"> <br>
            
            <label for="email"> Email </label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email"> <br>
            
            <label for="password"> Enter Password </label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password"> <br>
            
            <label for="confirm_password"> Confirm Password </label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm your password"> <br>

            <button class="btn btn-primary" type="submit">Sign In</button>

        </form>

        
    

  
    
</body>
</html>