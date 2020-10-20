<?php 

// CREATE TABLE friends (
//    name varchar(30) NOT NULL,
//    major varchar(10) NOT NULL,
//    year int NOT NULL,
//    PRIMARY KEY (name) );  

// Prepared statement (or parameterized statement) happens in 2 phases:
//   1. prepare() sends a template to the server, the server analyzes the syntax
//                and initialize the internal structure.
//   2. bind value (if applicable) and execute
//      bindValue() fills in the template (~fill in the blanks.
//                For example, bindValue(':name', $name);
//                the server will locate the missing part signified by a colon
//                (in this example, :name) in the template
//                and replaces it with the actual value from $name.
//                Thus, be sure to match the name; a mismatch is ignored.
//      execute() actually executes the SQL statement


function getAllFriends()
{
    
	
	
	
}

function addFriend($name, $major, $year)
{
	global $db;
	
//	$query = 'INSERT INTO friends (name, major, year) VALUES ("' . $name . '", "' . $major . '", ' . $year . ')';
	$query = 'INSERT INTO friends VALUES ("' . $name . '", "' . $major . '", ' . $year . ')';
    $statement = $db->query($query);
}
   
function getFriendInfo_by_name($name)
{
	
	
	
}

function updateFriend($name, $major, $year)
{

	
	
	
}

function deleteFriend($name)
{
  
	
	
	
}
?>
