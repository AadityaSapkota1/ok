<?php
session_start();
require_once "config.php";
$id_here = $_SESSION["id"];
$sql = "SELECT * FROM bank WHERE id = $id_here " ;
$result=mysqli_query($conn,$sql);

if(empty($_SESSION["username"])){
    header("location:../registration/register.php");
}

   

    $deposit = $withdraw = 0;
    $deposit_err = $withdraw_err =  "";
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if ((!isset($_POST['deposit']))) {
            $deposit_err = "depost cannot be blank";
            echo $deposit_err;
        } 
        else {
            $deposit = trim($_POST['deposit']);
            
        }
    
        if (!isset($_POST['withdraw'])) {
            $withdraw_err = "withdraw cannot be blank";
            echo $withdraw_err;
        } 
        else {
            $withdraw = trim($_POST['withdraw']);
            echo $withdraw;
        }
    
    
    


// Check input errors before inserting in database
    if (empty($deposit_err) && empty($withdraw_err)) {

        // Prepare an update statement
        


            $sql = "UPDATE bank SET  balance=?  WHERE id=?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ii", $param_balance,$param_id);


                // Set parameters
                foreach ($result as $row){ 
                $param_balance =  $row["balance"] + $deposit - $withdraw;
                $param_id = $_SESSION["id"];
                }
            }
       
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {


            // Records updated successfully. Redirect to landing page
            header("location: ../registration/welcome.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}





   





?>


<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css?v=<?php echo time();?>" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<link rel="stylesheet" href="bank.css?v=<?php echo time(); ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
</head>
<body>
<div class="balance">
<?php foreach ($result as $row){ 
 
            echo $row["balance"];

    }
    ?>
</div>

    <div class="bank">
    

    <div class="feature">
        <div class="deposit">
    <form action="" class="deposit" method="post"> 
        <!-- ../registration/welcome.php -->
      
        <input type="number" class="form-control" name="deposit" placeholder="Deposit How Much ?"> 
       
    
        

        </div>

    <br>

        <div class="withdraw">

       
    
        
        <input type="number" class="form-control" name="withdraw" placeholder="Withdraw How Much ?"> 

        <br>

        <button type="submit" class="btn btn-primary btn-withdraw">Submit</button>
        </div>
    </form>


    </div>
</body>
</html>