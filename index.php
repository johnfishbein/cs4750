<?php
require('connectdb.php');
require('poll_db.php');

// check if logged in
if(!isset($_SESSION['uname'])){
  header('Location: login.php');
}
// logout
if(isset($_POST['logout_button'])){
  session_destroy();
  header('Location: index.php');
}


$uname = $_SESSION['uname'];
$uid = $_SESSION['uid'];
echo "<p>You are logged in as user '$uname' with id '$uid'</p>";

$polls = getAllPolls();
// $polls = getActivePolls();
// $polls = getFollowedPolls();

// if ($_SERVER['REQUEST_METHOD'] == 'POST')
// {
//    if (!empty($_POST['action']) && ($_POST['action']=='Add'))
//       addFriend($_POST['name'], $_POST['major'], $_POST['year']);
// }
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

<!-- <h1>Homepage</h1> -->
  <form method='post' action="">
      <input type="submit" value="Logout" name="logout_button" class="btn btn-secondary"> 
  </form>

  <form action="question_list.php" method='post'>
      <input type="submit" value="Go to Questions List" name="question_redirect" class="btn btn-primary"> 
  </form>

  <form action="user_page.php" method='post'>
      <input type="submit" value="Edit User Account" name="user_account_redirect" class="btn btn-primary"> 
  </form>

<form action="add_poll_form.php" method="post">
  <input type="submit" value="Add Poll" name="action" class="btn btn-primary" title="Create new poll" />             
</form> 


<hr/>
<h2>List of Polls</h2>
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="40%">Question</th>        
    <th width="15%">Deadline</th>
    <th width="10%">Total Votes</th>
    <th width="20%">Creator</th>
    <th width="5%">ID</th>
    <th width="10%">View</th>
  </tr>
  </thead>
  <?php foreach ($polls as $item): ?>
  <tr>
    <td><?php echo $item['question']; ?></td>
    <td><?php echo $item['deadline']; ?></td>        
    <td><?php echo $item['total_votes']; ?></td>        
    <td><?php echo $item['creator']; ?></td>  
    <td><?php echo $item['poll_id']; ?></td>  
    <td>
    <form action="view_poll.php" method="post">
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
  
