<?php
session_start();
require "config.php";
$id_here = $_SESSION["id"];
$sql = "SELECT * FROM bank WHERE id = $id_here " ;
$result=mysqli_query($conn,$sql);



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
      <a class="nav-item nav-link" href="../bank/bank.php">Bank</a>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
      
    </div>
  </div>
</nav>
    
<div class="balance">
<?php foreach ($result as $row){ 
 
            echo $row["balance"];

    }
    ?>
</div>

            <a href="../bank/bank.php"><button class="btn bank-btn btn-primary">Go To Bank</button></a>


        
    

  
    
</body>
</html>