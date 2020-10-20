<?php 

/************************************/
/* Table Creation Scripts
CREATE TABLE polls(
	question VARCHAR(255), 
    deadline TIMESTAMP, 
    total_votes INT DEFAULT 0,
    poll_id INT NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(poll_id)
);


CREATE TABLE options(
	option_value VARCHAR(255), 
    votes INT DEFAULT 0, 
    poll_id INT, 
    option_id INT NOT NULL AUTO_INCREMENT, 
    FOREIGN KEY(poll_id) REFERENCES polls(poll_id),
    PRIMARY KEY(option_id)
);

INSERT INTO options (option_value, votes, poll_id) VALUES ("Test Option 1", 0, 1);


BEGIN;
INSERT INTO polls (question, deadline)
VALUES("TEST", CURRENT_TIMESTAMP);
INSERT INTO options (option_value, votes, poll_id) 
VALUES
("A", 0, LAST_INSERT_ID()),
("B", 0, LAST_INSERT_ID()),
("C", 0, LAST_INSERT_ID());
COMMIT;
*/
/************************************/


function getAllPolls()
{
    global $db;
	$query = "SELECT * FROM polls";
	$statement = $db->prepare($query);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetchAll();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;
}

function getPoll($poll_id)
{
    global $db;
    $query = "SELECT * FROM polls NATURAL JOIN options WHERE poll_id = :poll_id";

    $statement = $db->prepare($query);
	$statement->bindValue(':poll_id', $poll_id);
    $statement->execute();
    $results = $statement->fetchAll();
    
    // closes the cursor and frees the connection to the server so other SQL statements may be issued
    $statement->closecursor();
    return $results;
}


function addPoll($question, $ts, $option1, $option2, $option3) // should probably change to an array of options
{
    global $db;
    $query1 = "INSERT INTO polls (question, deadline) VALUES (:question, :ts)";
    $query2 = "INSERT INTO options (option_value, votes, poll_id) VALUES (:option1, 0, LAST_INSERT_ID()), (:option2, 0, LAST_INSERT_ID()), (:option3, 0, LAST_INSERT_ID())";
    $statement1 = $db->prepare($query1);
    $statement2 = $db->prepare($query2);
    $statement1->bindValue(':question', $question);
    $statement1->bindValue(':ts', $ts);
    $statement2->bindValue(':option1', $option1);
    $statement2->bindValue(':option2', $option2);
    $statement2->bindValue(':option3', $option3);
    try {
        $db->beginTransaction();
        $statement1->execute();
        $statement1->closecursor();
        $statement2->execute();
        $statement2->closecursor();
        
        // commit transaction
        $db->commit();
        echo "Done";
    } catch (\Throwable $e) {
        // catch exception and rollback transaction
        $db->rollback();
        throw $e; // but the error must be handled anyway
    }   
}


function voteOnPoll($option_id)
{
    global $db;
    $query = "UPDATE polls, options
	            SET options.votes = options.votes + 1,
    	            polls.total_votes = polls.total_votes + 1
                WHERE option_id = :option_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':option_id', $option_id);
    $statement->execute();
    $statement->closecursor();
}
?>

