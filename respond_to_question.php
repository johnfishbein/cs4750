<?php
require('connectdb.php');
require('poll_db.php');

// echo $_POST['question_to_respond'];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['action']) && ($_POST['action'] == 'Submit'))
  {
    $success = leaveResponse($_POST['response'], $_POST['question_to_respond']);
    echo "success: ", $success;
    header("Location: view_question.php?question_to_view=".$_POST['question_to_respond']."&success=".$success);
  }
}

$question_info = getQuestion($_POST['question_to_respond']); 

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

<hr/>
<h3><?php echo $question_info[0]['question'] ?></h3>

<form name="mainForm" action="respond_to_question.php" method="post">
  <div class="form-group">
    Response
    <input type="text" class="form-control" name="response" required />        
  </div>  
  <input type="submit" value="Submit" name="action" class="btn btn-dark" title="Respond to Question" />
  <input type="hidden" name="question_to_respond" value="<?php echo $_POST['question_to_respond'] ?>" />
</form>  

<form action="view_question.php" method="get">
  <input type="submit" value="Cancel" name="action" class="btn btn-primary" title="Cancel" />             
  <input type="hidden" name="question_to_view" value="<?php echo $_POST['question_to_respond'] ?>" />
</form> 

  
<hr/>

        
</div>    
</body>
</html>
  



