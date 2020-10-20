<?php
require('connectdb.php');
require('poll_db.php');

echo $_GET['poll_to_view'];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (!empty($_POST['action']) && ($_POST['action'] == 'Vote'))
	{
		voteOnPoll($_POST['selected_option']);
	}
}

$poll_info = getPoll($_GET['poll_to_view']);

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
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
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
      </form>
      
    </td>                                                          
  </tr>
  <?php endforeach; ?>
</table>

<form action="index.php" method="get">
  <input type="submit" value="Return to Polls List" name="action" class="btn btn-primary" title="Create new poll" />             
</form> 

</div>    
</body>
</html>
  



