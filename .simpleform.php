<?php
require('connectdb.php');
require('friend_db.php');

$friends = getAllFriends();
$friend_to_update = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (!empty($_POST['action']) && ($_POST['action'] == 'Update'))
	{
		$friend_to_update = getFriendInfo_by_name($_POST['friend_to_update']);
	}
	else if (!empty($_POST['action']) && ($_POST['action'] == 'Add'))
	{
		// retrieve form data 
		//    $_POST['name'] refers to the value entered in the name textbox,
		//    $_POST['major'] refers to the value entered in the major textbox,
		//    $_POST['year'] refers to the value entered in the year textbox
		addFriend($_POST['name'], $_POST['major'], $_POST['year']);
		$friends = getAllFriends();
	}
	else if (!empty($_POST['action']) && $_POST['action'] == 'Delete')
	{
		// echo $_POST['friend_to_delete'];      // see what value is stored in a form element named "friend_to_delete"
		deleteFriend($_POST['friend_to_delete']);
		$friends = getAllFriends();
	}
	
	if (!empty($_POST['action']) && ($_POST['action'] == 'Confirm update'))
	{
		updateFriend($_POST['name'], $_POST['major'], $_POST['year']);
		$friends = getAllFriends();
	}
   
// extra example, in case you'd like to call a stored procedure that takes inputs from your PHP
// refer to raiseSalary() procedure we created when we discussed stored procedure
   if (!empty($_POST['action']) && ($_POST['action']=='Raise instructor salary'))
   {
      // suppose we retrieve user data entry -- old salary and new salary and
      // stored them in variables
      $oldsal = 81000;
      $newsal = 80000;
      raiseInstructorSalary($oldsal, $newsal);      // see the function at the bottom of this file
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

<h1>Friend book</h1>

<!-- <form action="formprocessing.php" method="post">  -->
<form name="mainForm" action="simpleform.php" method="post">  
  <div class="form-group">
    Your name:
    <input type="text" class="form-control" name="name" required 
    value="<?php if ($friend_to_update!=null) echo $friend_to_update['name'] ?>" 
    />        
  </div>  
  <div class="form-group">
    Major:
    <input type="text" class="form-control" name="major" required 
    value="<?php if ($friend_to_update!=null) echo $friend_to_update['major'] ?>"
    /> 
  </div>  
  <div class="form-group">
    Year:
    <input type="number" class="form-control" name="year" required max="4" min="1"
    value="<?php if ($friend_to_update!=null) echo $friend_to_update['year'] ?>" 
    />        
  </div> 
     
  <input type="submit" value="Add" name="action" class="btn btn-dark" title="Insert a friend into a friends table" />
  <input type="submit" value="Confirm update" name="action" class="btn btn-dark" title="Confirm update a friend" />
    
  <input type="submit" value="Raise instructor salary" name="action" class="btn btn-dark" title="Call stored prodecure to raise instructor's salary" />
</form>  


  
<hr/>
<h2>List of Friends</h2>
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Name</th>        
    <th width="25%">Major</th>        
    <th width="25%">Year</th> 
    <th width="10%">Update ?</th>
    <th width="10%">Delete ?</th> 
  </tr>
  </thead>
  <?php foreach ($friends as $item): ?>
  <tr>
    <td><?php echo $item['name']; ?></td>
    <td><?php echo $item['major']; ?></td>        
    <td><?php echo $item['year']; ?></td>       
    <td>
      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="submit" value="Update" name="action" class="btn btn-primary" title="Update the record" />             
        <input type="hidden" name="friend_to_update" value="<?php echo $item['name'] ?>" />
      </form> 
    </td>                        
    <td>
      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="submit" value="Delete" name="action" class="btn btn-danger" title="Permanently delete the record" />      
        <input type="hidden" name="friend_to_delete" value="<?php echo $item['name'] ?>" />
      </form>
    </td>                                              
  </tr>
  <?php endforeach; ?>
</table>
        
</div>    
</body>
</html>



<?php
function raiseInstructorSalary($old, $new)
{
   global $db;
// When we execute the procedure in phpMyAdmin, we would type 
//     SET @p0='60000'; SET @p1='61200'; CALL `raiseSalary`(@p0, @p1);

   $query = "CALL raiseSalary(:param1, :param2)";

   // prepare for execution of the stored procedure
   $statement = $db->prepare($query);

   // pass value to the command
   $statement->bindValue(':param1', $old);
   $statement->bindValue(':param2', $new);

   $statement->execute();
   $statement->closeCursor();
}
?>
  



