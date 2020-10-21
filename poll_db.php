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


function addPoll($question, $ts, $option1, $option2, $option3) // Need to change to an array of options
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
// will need to edit created_by table to incl
{
    global $db;
    $query = "UPDATE polls, options
	            SET options.votes = options.votes + 1,
    	            polls.total_votes = polls.total_votes + 1
                WHERE options.option_id = :option_id 
                AND polls.poll_id = options.poll_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':option_id', $option_id);
    $statement->execute();
    $statement->closecursor();
}


function updatePoll($poll_id, $poll_arr, $new_question, $new_option1, $new_option2, $new_option3) // need to fix this for arrays
// why does this update deadline
{
    global $db;
    $question_query = "UPDATE polls SET polls.question = :new_question WHERE poll_id = :poll_id";
    $option_query = "UPDATE options SET options.option_value = :new_option WHERE option_id = :option_id";
    

    try {
        $db->beginTransaction();

        // update question
        $question_statement = $db->prepare($question_query);
        $question_statement->bindValue(':new_question', $new_question);
        $question_statement->bindValue(':poll_id', $poll_id);
        $question_statement->execute();
        $question_statement->closecursor();

        $new_vals = array($new_option1, $new_option2, $new_option3);
        $i = 0;
        foreach ($poll_arr as $option):
            // update each option
            $option_statement = $db->prepare($option_query);
            $option_statement->bindValue(':new_option', $new_vals[$i]);
            $option_statement->bindValue(':option_id', $option['option_id']);
            $option_statement->execute();
            $option_statement->closecursor();
            $i = $i + 1;
        endforeach;
        $db->commit();
        echo "Done";
    } catch (\Throwable $e) {
        // catch exception and rollback transaction
        $db->rollback();
        throw $e; // but the error must be handled anyway
    }   
    
}
?>

