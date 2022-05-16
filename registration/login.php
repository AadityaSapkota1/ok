<?php
//This script will handle login
session_start();
if(isset($_SESSION['username']))
{
    header("location:welcome.Php");
    exit;
}
require_once "config.php";
$username = $password = "";
$err = "";
// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){

    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username and password";
        echo $err;
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


    if(empty($err))
    {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;

// Try to execute this statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1)
            {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt))
                {
                    if(password_verify($password, $hashed_password))
                    {
// this means the password is correct. Allow user to login
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;

//Redirect user to welcome page
                        header("location:welcome.php");

                    }
                }

            }

        }
    }


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
    
        <form action="" class="log-form form-group" method="post"> 

        
            <label for="username"> Username </label>
            <input type="text" name="username" class="form-control" placeholder="Enter your username"> <br>
            

            
            <label for="password"> Enter Password </label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password"> <br>
            
     

            <button class="btn btn-primary" type="submit">Sign In</button>

        </form>

        
    


    
</body>
</html>
