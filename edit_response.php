<?php
require('connectdb.php');
require('poll_db.php');
 
// echo $_POST['question_to_view'];
// echo $_POST['response_to_edit'];



if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   if (!empty($_POST['action']) && ($_POST['action']=='Update'))
   {
      updateResponse($_POST['response_to_edit'], $_POST['response']);
    }
}

$response_info = getResponseWithQuestion($_POST['response_to_edit']); 

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

<h1><?php echo $response_info['question'] ?></h1>

<form name="mainForm" action="edit_response.php" method="post">
  <div class="form-group">
    Response
    <input type="text" class="form-control" name="response" value="<?php echo $response_info['response_value'] ?>" />        
  </div>  
  <input type="submit" value="Update" name="action" class="btn btn-dark" />
  <input type="hidden" name="question_to_view" value="<?php echo $_POST['question_to_view'] ?>" />
  <input type="hidden" name="response_to_edit" value="<?php echo $_POST['response_to_edit'] ?>" />
</form>  

<form action="view_question.php" method="get">
  <input type="submit" value="Return to Question" name="action" class="btn btn-primary" title="Cancel" />             
  <input type="hidden" name="question_to_view" value="<?php echo $_POST['question_to_view'] ?>" />
</form> 

  
<hr/>

        
</div>    
</body>
</html>
  
