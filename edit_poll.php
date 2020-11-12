<?php

require('connectdb.php');
require('poll_db.php');

// echo "Poll NUM:";
// echo $_POST['poll_to_edit']; // post request from view poll 

// $poll_info = getPoll($_POST['poll_to_edit']);
$poll_info = getPoll($_POST['poll_to_edit']);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   if (!empty($_POST['action']) && ($_POST['action']=='Update'))
   {
    //   $timestamp = date("Y-m-d H:i:s"); // need to be able to take input as datetime
      updatePoll($_POST['poll_to_edit'], $poll_info, $_POST['question'], $_POST['option1'], $_POST['option2'], $_POST['option3']); // need to alter to options array
      $poll_info = getPoll($_POST['poll_to_edit']);
    }
  //   elseif (!empty($_POST['action']) && ($_POST['action']=='Re-activate Poll'))
  //  {
  //     activatePoll($_POST['poll_to_edit']);
  //     $poll_info[0]['is_active'] = 1;
  //   }
  //   elseif (!empty($_POST['action']) && ($_POST['action']=='Deactivate Poll'))
  //  {
  //     deactivatePoll($_POST['poll_to_edit']);
  //     $poll_info[0]['is_active'] = 0;
  //   }
}

// $poll_info = getPoll($_POST['poll_to_edit']);


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

<form name="mainForm" action="edit_poll.php" method="post">
  <div class="form-group">
    Question
    <input type="text" class="form-control" name="question" value="<?php echo $poll_info[0]['question'] ?>" />        
  </div>  
  <!-- NEED TO CHANGE THIS TO REFLECT ARRAY -->
  <div class="form-group">
    Option 1
    <input type="text" class="form-control" name="option1" value="<?php echo $poll_info[0]['option_value'] ?>" /> 
  </div>  
  <div class="form-group">
    Option 2
    <input type="text" class="form-control" name="option2" value="<?php echo $poll_info[1]['option_value'] ?>" />        
  </div> 
  <div class="form-group">
    Option 3
    <input type="text" class="form-control" name="option3" value="<?php echo $poll_info[2]['option_value'] ?>"/>        
  </div> 

  <div>
  <input type="submit" value="Update" name="action" class="btn btn-dark" title="Update Poll" style='float: left; margin-right: 5px;' />
  <input type="hidden" name="poll_to_edit" value="<?php echo $_POST['poll_to_edit']?>" />
  <!-- <input type="hidden" name="old_poll_info" value="<?php $poll_info?>" /> -->
</form>  


<!-- <form action="index.php" method="post" style='float: left; margin-right: 5px;'>
  <input type="submit" value="Return to Polls List" name="action" class="btn btn-primary" title="Return" />             
</form>  -->
<form action="view_poll.php" method="post" style='float: left; margin-right: 5px;'>
  <input type="submit" value="Return to Poll" name="action" class="btn btn-primary" />
  <input type="hidden" name="poll_to_view" value="<?php echo $_POST['poll_to_edit']?>" />           
</form> 

</div>



  
<hr/>

        
</div>    
</body>
</html>
  
