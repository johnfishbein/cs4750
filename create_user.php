<?php
require('connectdb.php');
require('poll_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   if (!empty($_POST['action']) && ($_POST['action']=='Create'))
   {
    if ($_POST["password"] != $_POST["password_check"])
    {
        echo "Passwords did not match!";
    }
    else{
        // echo "passwords match!";
        createUser($_POST['username'], $_POST['name'], $_POST['email'], $_POST['password']);
        header('Location: index.php');
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">      
  <title>DB interfacing</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="shortcut icon" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" type="image/ico" />  
</head>

<body>
<div class="container">

<h1>Create New Account</h1>

<form name="mainForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
  <div class="form-group">
    Username
    <input type="text" class="form-control" name="username" required />        
  </div>  
  <div class="form-group">
    Name
    <input type="text" class="form-control" name="name" required /> 
  </div>  
  <div class="form-group">
    Email
    <input type="text" class="form-control" name="email" required />        
  </div> 
  <div class="form-group">
    Password
    <input type="text" class="form-control" name="password" required />        
  </div> 
  <div class="form-group">
    Confirm Password
    <input type="text" class="form-control" name="password_check" required />        
  </div> 
     
  <input type="submit" value="Create" name="action" class="btn btn-dark"/>
</form>  



<form action="login.php" method="post">
  <input type="submit" value="Return to login" name="action" class="btn btn-secondary" title="Return" />             
</form> 

  
<hr/>

        
</div>    
</body>
</html>
  
