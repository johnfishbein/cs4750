<?php
require('connectdb.php');
require('poll_db.php');

// $table_rows = ""; // default to two table rows
// 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   if (!empty($_POST['action']) && ($_POST['action']=='Submit'))
   {
      addQuestion($_POST['question']);
      header("Location: question_list.php");
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

<h1>Add Question</h1>

<!-- <form action="formprocessing.php" method="post">  -->
<form name="mainForm" action="add_question_form.php" method="post">
  <div class="form-group">
    New Question
    <input type="text" class="form-control" name="question" required/>        
  </div>  
  <input type="submit" value="Submit" name="action" class="btn btn-dark" title="Create a new Question" />
  
</form>  
<form action="question_list.php" method="post">
  <input type="submit" value="Return to Questions List" name="action" class="btn btn-primary" title="Return" />             
</form> 

  
<hr/>

        
</div>    
</body>
</html>
  
