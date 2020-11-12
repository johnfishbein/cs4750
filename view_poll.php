<?php
require('connectdb.php');
require('poll_db.php');

// echo $_GET['poll_to_view'];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (!empty($_POST['action']) && ($_POST['action'] == 'Vote'))
	{
    voteOnPoll($_POST['selected_option'], $_POST['poll_to_view']);
    // $is_following = isUserFollowingPoll($_GET['poll_to_view']);
  }
  elseif (!empty($_POST['action']) && ($_POST['action'] == 'Edit Poll'))
  {
    header("Location: edit_poll.php");
  }
  elseif (!empty($_POST['action']) && ($_POST['action'] == 'Return to Polls List'))
  {
    header("Location: index.php");
  }
  elseif (!empty($_POST['action']) && ($_POST['action'] == 'Follow'))
  {
    followPoll($_POST['poll_to_view']);
    $is_following = 1;
  }
  elseif (!empty($_POST['action']) && ($_POST['action'] == 'Unfollow'))
  {
    unfollowPoll($_POST['poll_to_view']);
    $is_following = 0;
  }
  elseif (!empty($_POST['action']) && ($_POST['action'] == 'Delete Poll'))
  {
    deletePoll($_POST['poll_to_delete']);
    header("Location: index.php");
  }
}

$is_following = isUserFollowingPoll($_POST['poll_to_view']);
$is_creator = isUserCreatorPoll($_POST['poll_to_view']);

$poll_info = getPoll($_POST['poll_to_view']);

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
<h3><?php echo $poll_info[0]['question'] ?></h3>
<p> Is Active? <?php echo $poll_info[0]['is_active'] ?> </p>

<!-- Display follow / unfollow button -->
<div style='border: dotted; color: white; padding-bottom: 5px;'>
<?php if (!$is_following){ ?>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" style='float: left; margin: 5px;'>
        <input type="submit" value="Follow" name="action" class="btn btn-primary" />      
        <input type="hidden" name="poll_to_view" value="<?php echo $_POST['poll_to_view'] ?>">
  </form>

<?php }else { ?>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" style='float: left; margin: 5px;'>
        <input type="submit" value="Unfollow" name="action" class="btn btn-primary" />      
        <input type="hidden" name="poll_to_view" value="<?php echo $_POST['poll_to_view'] ?>">
  </form>
<?php } ?>

<?php if ($is_creator){ ?>

<form action="edit_poll.php" method="post" style='float: left; margin: 5px;'>

  <input type="submit" value="Edit Poll" name="action" class="btn btn-primary" title="Edit"/>             
  <input type="hidden" name="poll_to_edit" value="<?php echo $_POST['poll_to_view'] ?>">
</form> 

<form action="view_poll.php" method="post" style='float: left; margin: 5px;'>
  <input type="submit" value="Delete Poll" name="action" class="btn btn-warning" title="Edit"/>             
  <input type="hidden" name="poll_to_delete" value="<?php echo $_POST['poll_to_view'] ?>">
</form> 
</div>
<?php } ?>



<table class="w3-table w3-bordered w3-card-4 center" style="width:70%; margin-top: 50px;">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="40%">Option</th>        
    <th width="30%">Number of Votes</th>
    <th width="30%">Vote</th>
  </tr>
  </thead>
  <?php foreach ($poll_info as $option): ?>
  <tr>
    <td><?php echo $option['option_value']; ?></td>
    <td><?php echo $option['votes']; ?></td>        
    <td>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="submit" value="Vote" name="action" class="btn btn-danger" title="Vote on this option"/>      
        <input type="hidden" name="selected_option" value="<?php echo $option['option_id'] ?>" />
        <input type="hidden" name="poll_to_view" value="<?php echo $_POST['poll_to_view'] ?>">
      </form>
      
    </td>                                                          
  </tr>
  <?php endforeach; ?>
</table>
</div>

<!-- <form action="index.php" method="post"> -->
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" style='margin-top: 30px; margin-left: 160px;'>
  <input type="submit" value="Return to Polls List" name="action" class="btn btn-primary" title="Return" />             
</form> 

</div>    
</body>
</html>
  



