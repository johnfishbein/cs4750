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
	global $db;
	$query = "SELECT * FROM friends";
	$statement = $db->prepare($query);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetchAll();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;
}

function addFriend($name, $major, $year)
{
	global $db;
	
	// bad
    // $query = "INSERT INTO friends (name, major,year) VALUES('...', '...', '...')";
	// $query = "INSERT INTO friends VALUES('" . $name . "', '" . $major . "'," . $year . ")";	
	// $statement = $db->query($query); 

	// good 
	$query = "INSERT INTO friends VALUES(:name, :major, :year)";
	$statement = $db->prepare($query);
	$statement->bindValue(':name', $name);
	$statement->bindValue(':major', $major);
	$statement->bindValue(':year', $year);
	$statement->execute();        // run query, if the statement is successfully executed, execute() returns true
	                              // false otherwise
	
	$statement->closeCursor();    // release hold on this connection
}
   
function getFriendInfo_by_name($name)
{
	global $db;
	
	// bad
	$query = "SELECT * FROM friends WHERE name ='" . $name . "'";
	$statement = $db->query($query);
	
	// good, use prepare statement to minimize chance of sql injection
	// $query = "SELECT * FROM friends WHERE name = :name";
	// $statement = $db->prepare($query);
	// $statement->bindValue(':name', $name);
	// $statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	// fetch() return a row
	$results = $statement->fetch();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;
}

function updateFriend($name, $major, $year)
{
	global $db;
	
	$query = "UPDATE friends SET major=:major, year=:year WHERE name=:name";
	$statement = $db->prepare($query);
	$statement->bindValue(':name', $name);
	$statement->bindValue(':major', $major);
	$statement->bindValue(':year', $year);
	$statement->execute();
	$statement->closeCursor();
}

function deleteFriend($name)
{
	global $db;
	$query = "DELETE FROM friends WHERE name=:name";
	$statement = $db->prepare($query);
	$statement->bindValue(':name', $name);
	$statement->execute();      // run query
	$statement->closeCursor();  // release hold on this connection	
}
?>
