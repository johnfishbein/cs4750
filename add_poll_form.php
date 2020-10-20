<?php
require('connectdb.php');
require('poll_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   if (!empty($_POST['action']) && ($_POST['action']=='Add'))
   {
      $timestamp = date("Y-m-d H:i:s");
      addPoll($_POST['question'], $timestamp, $_POST['option1'], $_POST['option2'], $_POST['option3']);
    header("Location: index.php");
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

<h1>Polls</h1>

<!-- <form action="formprocessing.php" method="post">  -->
<form name="mainForm" action="add_poll_form.php" method="post">
  <div class="form-group">
    Question
    <input type="text" class="form-control" name="question" required />        
  </div>  
  <div class="form-group">
    Option 1
    <input type="text" class="form-control" name="option1" required /> 
  </div>  
  <div class="form-group">
    Option 2
    <input type="text" class="form-control" name="option2" required />        
  </div> 
  <div class="form-group">
    Option 3
    <input type="text" class="form-control" name="option3"/>        
  </div> 
     
  <input type="submit" value="Add" name="action" class="btn btn-dark" title="Create a new Poll" />
  
</form>  

  
<hr/>

        
</div>    
</body>
</html>
  
