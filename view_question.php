<?php
require('connectdb.php');
require('poll_db.php');

// echo $_GET['question_to_view'];

if (isset($_GET['success']) && $_GET['success'] == 0 )
{
    echo "ERROR: You already responded to this question";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['action']) && ($_POST['action'] == 'Return to Question List'))
  {
    header("Location: question_list.php");
  }
  elseif (!empty($_POST['action']) && ($_POST['action'] == 'Follow'))
  {
    followQuestion($_POST['question_to_view']);
    $is_following = 1;
  }
  elseif (!empty($_POST['action']) && ($_POST['action'] == 'Unfollow'))
  {
    unfollowQuestion($_POST['question_to_view']);
    $is_following = 0;
  }
}
// $poll_info = getPoll($_GET['poll_to_view']);
if (isset($_GET['question_to_view']))
{
  $question_to_view = $_GET['question_to_view'];
}
else
{
  $question_to_view = $_POST['question_to_view'];
}
$is_following = isUserFollowingQuestion($question_to_view);
$question_info = getQuestion($question_to_view); // maybe change this to have it passed in
$question_responses = getQuestionResponses($question_to_view);

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
<p> Is Active? <?php echo $question_info[0]['is_active'] ?> </p>

<!-- Display follow / unfollow button -->
<?php if (!$is_following){ ?>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="submit" value="Follow" name="action" class="btn btn-primary" />      
        <input type="hidden" name="question_to_view" value="<?php echo $question_to_view ?>">
  </form>

<?php }else { ?>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="submit" value="Unfollow" name="action" class="btn btn-primary" />      
        <input type="hidden" name="question_to_view" value="<?php echo $question_to_view ?>">
  </form>
<?php } ?>



<form action="edit_question.php" method="post">
  <input type="submit" value="Edit Question" name="action" class="btn btn-primary" title="Edit"/>             
  <input type="hidden" name="question_to_edit" value="<?php echo question_to_view ?>">
</form> 

<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="70%">Response</th>        
    <th width="10%">Responder</th>
    <th width="10%">Response Timestamp</th>
    <th width="10%">Response ID</th>
    <!-- <th width="30%">Vote</th> -->
  </tr>
  </thead>
  <?php foreach ($question_responses as $response): ?>
  <tr>
    <td><?php echo $response['response_value']; ?></td>
    <td><?php echo $response['responder']; ?></td>
    <td><?php echo $response['response_timestamp']; ?></td>
    <td><?php echo $response['response_id']; ?></td> 
  </tr>
  <?php endforeach; ?>
</table>

<form action="respond_to_question.php" method="post">
  <input type="submit" value="Respond to Question" name="action" class="btn btn-primary" title="Edit"/>             
  <input type="hidden" name="question_to_respond" value="<?php echo $question_to_view ?>">
</form> 


<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  <input type="submit" value="Return to Question List" name="action" class="btn btn-secondary" title="Return" />             
</form> 

</div>    
</body>
</html>
  



