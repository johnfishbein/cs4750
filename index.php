<?php
require('connectdb.php');
require('poll_db.php');

$polls = getAllPolls();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  //  if (!empty($_POST['action']) && ($_POST['action']=='Add'))
  //     addFriend($_POST['name'], $_POST['major'], $_POST['year']);
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

<form action="add_poll_form.php" method="get">
  <input type="submit" value="Add Poll" name="action" class="btn btn-primary" title="Create new poll" />             
</form> 


<hr/>
<h2>List of Polls</h2>
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="50%">Question</th>        
    <th width="20%">Deadline</th>
    <th width="10%">Total Votes</th>
    <th width="10%">ID</th>
    <th width="10%">View</th>
  </tr>
  </thead>
  <?php foreach ($polls as $item): ?>
  <tr>
    <td><?php echo $item['question']; ?></td>
    <td><?php echo $item['deadline']; ?></td>        
    <td><?php echo $item['total_votes']; ?></td>        
    <td><?php echo $item['poll_id']; ?></td>       
    <td>
    <form action="view_poll.php" method="get">
        <input type="submit" value="View" name="action" class="btn btn-primary" title="Update the record" />             
        <input type="hidden" name="poll_to_view" value="<?php echo $item['poll_id'] ?>" />
      </form> 

      
    </td>                                                          
  </tr>
  <?php endforeach; ?>
</table>
        
</div>    
</body>
</html>
  
