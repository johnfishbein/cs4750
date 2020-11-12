<?php 

function getUserInfo()
{
    global $db;
    $query = "SELECT * FROM users WHERE user_id = ".$_SESSION['uid'];
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();
    return $result;
}


function updateUserInfo($new_username, $new_name, $new_email, $new_password)
{
    global $db;
    $query = "UPDATE users SET username = :new_uname, name = :new_name, email = :new_email, password = :new_password WHERE user_id = :userid";
    $statement = $db->prepare($query);

    $statement->bindValue(':new_uname', $new_username);
    $statement->bindValue(':new_name', $new_name);
    $statement->bindValue(':new_email', $new_email);
    $statement->bindValue(':new_password', $new_password);
    $statement->bindValue(':userid', $_SESSION['uid']);
    
    $statement->execute();
    $statement->closecursor();
    $_SESSION['uname'] = $new_username;
}

function createUser($username, $name, $email, $password)
{
    global $db;
    $query = "INSERT INTO users (username, email, name, `password`) VALUES (:uname, :email, :name, :pwd)";
    $statement = $db->prepare($query);
    $statement->bindValue(':uname', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':pwd', $password);
    $statement->execute();
    $statement->closecursor();


    $_SESSION['uname'] = $username;
    $_SESSION['uid'] = $db->lastInsertId();

}
function questionsYouCreated() {
    global $db;
    // $query = "SELECT * FROM polls";
    $query = "SELECT question, deadline, question_id, total_responses, creator
    FROM questions NATURAL JOIN question_created_by NATURAL JOIN users
    WHERE users.user_id = question_created_by.creator AND creator = :userid;";

    $statement = $db->prepare($query);
    $statement->bindValue(':userid', $_SESSION['uid']);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetchAll();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;
}

function pollsYouCreated() {
    global $db;
    // $query = "SELECT * FROM polls";
    $query = "SELECT question, poll_id, is_active, total_votes, deadline, name AS creator 
    FROM polls NATURAL JOIN poll_created_by NATURAL JOIN users
    WHERE users.user_id = poll_created_by.creator AND users.user_id = :userid";

    $statement = $db->prepare($query);
    $statement->bindValue(':userid', $_SESSION['uid']);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetchAll();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;
}

function getAllPolls()
{
    global $db;
    // $query = "SELECT * FROM polls";
    $query = "SELECT question, poll_id, is_active, total_votes, deadline, name AS creator 
                FROM polls NATURAL JOIN poll_created_by NATURAL JOIN users
                WHERE users.user_id = poll_created_by.creator";
	$statement = $db->prepare($query);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetchAll();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;
}

function getActiveQuestions() {
    global $db;
    // $query = "SELECT * FROM polls";
    $query = "SELECT question, question_id, deadline, total_responses, name AS creator
    FROM questions NATURAL JOIN question_created_by NATURAL JOIN users
    WHERE is_active = 1 AND users.user_id = question_created_by.creator";
	$statement = $db->prepare($query);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetchAll();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;

}

// returns active polls
function getActivePolls()
{
    global $db;
    // $query = "SELECT * FROM polls";
    $query = "SELECT question, poll_id, is_active ,total_votes, deadline, name AS creator 
                FROM polls NATURAL JOIN poll_created_by NATURAL JOIN users
                WHERE is_active = TRUE AND users.user_id = poll_created_by.creator";
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
    // $query = "SELECT * FROM polls NATURAL JOIN options WHERE poll_id = :poll_id";
    $query = "SELECT question, is_active, total_votes, option_value, option_id, votes, deadline
                FROM polls NATURAL JOIN `options`
                WHERE poll_id = :poll_id";

    $statement = $db->prepare($query);
	$statement->bindValue(':poll_id', $poll_id);
    $statement->execute();
    $results = $statement->fetchAll();
    
    // closes the cursor and frees the connection to the server so other SQL statements may be issued
    $statement->closecursor();
    return $results;
}

function questionsFollowedBy() {
    global $db;
    $query = "SELECT question, deadline, total_responses, creator, question_id
    FROM questions NATURAL JOIN question_created_by NATURAL JOIN question_followed_by
    WHERE user_following = :userid";
    $statement = $db->prepare($query);
    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();
    return $results;
    
}

function getAllQuestions()
{
    global $db;
    // $query = "SELECT * FROM polls";
    $query = "SELECT question, question_id, deadline, total_responses, name AS creator
                FROM questions NATURAL JOIN question_created_by NATURAL JOIN users
                WHERE users.user_id = question_created_by.creator";
	$statement = $db->prepare($query);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetchAll();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;
}


// should return question value and is active
function getQuestion($question_id)
{
    global $db;
    $query = "SELECT question, deadline, is_active, total_responses
                FROM questions WHERE question_id = :question_id";

    $statement = $db->prepare($query);
	$statement->bindValue(':question_id', $question_id);
    $statement->execute();
    $results = $statement->fetchAll();
    
    // closes the cursor and frees the connection to the server so other SQL statements may be issued
    $statement->closecursor();
    return $results;
}

function getQuestionResponses($question_id)
{
    global $db;
    $query = "SELECT response_value, r.response_id, question, deadline, response_timestamp, l.user_responding AS responder_id, name AS responder 
                FROM responses r, questions q, leaves_response l, users 
                WHERE r.response_id = l.response_id AND r.question_id = q.question_id AND 
                    l.user_responding = users.user_id AND q.question_id = :question_id";

    $statement = $db->prepare($query);
	$statement->bindValue(':question_id', $question_id);
    $statement->execute();
    $results = $statement->fetchAll();
    
    // closes the cursor and frees the connection to the server so other SQL statements may be issued
    $statement->closecursor();
    return $results;
}

/*
Steps:
1- create poll in poll table
2- insert row into poll_created_by table
3- insert row into poll_followed_by table
4- create option(s) in options table // need to change for variable options
*/
function addPoll($question, $option1, $option2, $option3) 
{ 
    global $db;
    $query1 = "INSERT INTO polls (question) VALUES (:question)";
    $query2 = "INSERT INTO poll_created_by (creator, poll_id) VALUES (:userid, LAST_INSERT_ID())";
    $query3 = "INSERT INTO poll_followed_by (user_following, poll_id) VALUES (:userid, LAST_INSERT_ID())";
    $query4 = "INSERT INTO options (option_value, poll_id) VALUES (:option1, LAST_INSERT_ID()), (:option2, LAST_INSERT_ID()), (:option3, LAST_INSERT_ID())";
    

    $statement1 = $db->prepare($query1);
    $statement2 = $db->prepare($query2);
    $statement3 = $db->prepare($query3);
    $statement4 = $db->prepare($query4);

    $statement1->bindValue(':question', $question);
    // $statement1->bindValue(':ts', $ts);
    $statement2->bindValue(":userid", $_SESSION['uid']);
    $statement3->bindValue(":userid", $_SESSION['uid']);
    
    $statement4->bindValue(':option1', $option1);
    $statement4->bindValue(':option2', $option2);
    $statement4->bindValue(':option3', $option3);
    try {
        $db->beginTransaction();
        $statement1->execute();
        $statement1->closecursor();
        
        $statement2->execute();
        $statement2->closecursor();
        
        $statement3->execute();
        $statement3->closecursor();

        $statement4->execute();
        $statement4->closecursor();
        
        // commits transaction
        $db->commit();
    } catch (\Throwable $e) {
        // catch exception and rollback transaction
        $db->rollback();
        throw $e; // but the error must be handled anyway
    }   
}


function isPollActive($poll_id)
{
    global $db;
    // do check to ensure not voted
    $query = "SELECT is_active FROM polls WHERE poll_id = :poll_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':poll_id', $poll_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();

    return $result['is_active'];
}


function isQuestionActive($question_id)
{
    global $db;
    // do check to ensure not voted
    $query = "SELECT is_active FROM questions WHERE question_id = :question_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':question_id', $question_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();

    return $result['is_active'];
}

/*
Steps:
1- Check whether user has voted on this poll previously
2- update options table by incrementing votes on that option_id
3- update polls table with total votes for that poll 
4- update votes_on table 
*/
function voteOnPoll($option_id, $poll_id) // maybe change to have a return
{
    global $db;
    // do check to ensure not voted
    $has_user_voted_query = "SELECT COUNT(*) as cnt FROM votes_on WHERE user_voting = :userid AND poll_id = :poll_id";
    $statement = $db->prepare($has_user_voted_query);
    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->bindValue(':poll_id', $poll_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();

    if ($result['cnt'] > 0){
        echo "You Already Voted on this Poll";
    }
    elseif (!isPollActive($poll_id)){
        echo "This Poll is Inactive";
    }
    else
    {
    $query1 = "UPDATE options SET votes = votes + 1 WHERE option_id = :option_id";
    $query2 = "UPDATE polls SET total_votes = total_votes + 1 WHERE poll_id = :poll_id";
    $query3 = "INSERT INTO votes_on (user_voting, option_id, poll_id) VALUES (:userid, :option_id, :poll_id)";


    $statement1 = $db->prepare($query1);
    $statement2 = $db->prepare($query2);
    $statement3 = $db->prepare($query3);

    $statement1->bindValue(':option_id', $option_id);
    $statement2->bindValue(':poll_id', $poll_id);
    $statement3->bindValue(':userid', $_SESSION['uid']);
    $statement3->bindValue(':option_id', $option_id);
    $statement3->bindValue(':poll_id', $poll_id);

    try {
        $db->beginTransaction();
        $statement1->execute();
        $statement1->closecursor();
        
        $statement2->execute();
        $statement2->closecursor();
        
        $statement3->execute();
        $statement3->closecursor();        
        // commits transaction
        $db->commit();
    } catch (\Throwable $e) {
        // catch exception and rollback transaction
        $db->rollback();
        throw $e; // but the error must be handled anyway
    }  
    } 
}


// this only updates 3 options
function updatePoll($poll_id, $poll_arr, $new_question, $new_option1, $new_option2, $new_option3) // need to fix this for arrays
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
            if ($i >= 3){ break;}
            // update each option
            $option_statement = $db->prepare($option_query);
            $option_statement->bindValue(':new_option', $new_vals[$i]);
            $option_statement->bindValue(':option_id', $option['option_id']);
            $option_statement->execute();
            $option_statement->closecursor();
            $i = $i + 1;
        endforeach;
        $db->commit();
    } catch (\Throwable $e) {
        // catch exception and rollback transaction
        $db->rollback();
        throw $e; // but the error must be handled anyway
    }   
    
}


/*
Steps:
1- create question in questions table
2- insert row into question_created_by table
3- insert row into question_followed_by table
*/
function addQuestion($new_question) 
{ 
    global $db;;
    $query1 = "INSERT INTO questions (question) VALUES (:question)";
    $query2 = "INSERT INTO question_created_by (creator, question_id) VALUES (:userid, LAST_INSERT_ID())";
    $query3 = "INSERT INTO question_followed_by (user_following, question_id) VALUES (:userid, LAST_INSERT_ID())";
    

    $statement1 = $db->prepare($query1);
    $statement2 = $db->prepare($query2);
    $statement3 = $db->prepare($query3);

    $statement1->bindValue(':question', $new_question);
    $statement2->bindValue(":userid", $_SESSION['uid']);
    $statement3->bindValue(":userid", $_SESSION['uid']);

    try {
        $db->beginTransaction();
        $statement1->execute();
        $statement1->closecursor();
        
        $statement2->execute();
        $statement2->closecursor();
        
        $statement3->execute();
        $statement3->closecursor();
        
        // commits transaction
        $db->commit();
    } catch (\Throwable $e) {
        // catch exception and rollback transaction
        $db->rollback();
        throw $e; // but the error must be handled anyway
    }   
}



/*
Steps:
1- Check whether user has responded on this question previously --- return false if so
2- update question table by incrementing total num responses on that questionis
3- insert into responses table with actual response
4- insert into leaves_response table 
*/
function leaveResponse($response_value, $question_id)
{
    // echo "REsponse: ", $response_value;
    // echo "Question: ", $question_id;
    global $db;

    // do check to ensure not responded already
    $has_user_responded_query = "SELECT COUNT(*) as cnt FROM leaves_response WHERE user_responding = :userid AND question_id = :question_id";
    $statement = $db->prepare($has_user_responded_query);
    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->bindValue(':question_id', $question_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();

    if ($result['cnt'] > 0){
        echo "You already responded to this question";
        return 0;
    }
    elseif (!isQuestionActive($question_id)){
        echo "Question is not active";
        return 0;
    }
    
    // leave response
    $query1 = "UPDATE questions SET total_responses = total_responses + 1 WHERE question_id = :question_id";
    $query2 = "INSERT INTO responses (response_value, question_id) VALUES (:response_value, :question_id)";
    $query3 = "INSERT INTO leaves_response (user_responding, response_id, question_id) VALUES (:userid, LAST_INSERT_ID(), :question_id)";

    $statement1 = $db->prepare($query1);
    $statement2 = $db->prepare($query2);
    $statement3 = $db->prepare($query3);

    $statement1->bindValue(':question_id', $question_id);
    $statement2->bindValue(':response_value', $response_value);
    $statement2->bindValue(':question_id', $question_id);
    $statement3->bindValue(':userid', $_SESSION['uid']);
    $statement3->bindValue(':question_id', $question_id);

    try {
        $db->beginTransaction();
        $statement1->execute();
        $statement1->closecursor();
        
        $statement2->execute();
        $statement2->closecursor();
        
        $statement3->execute();
        $statement3->closecursor();        
        // commits transaction
        $db->commit();
    } catch (\Throwable $e) {
        // catch exception and rollback transaction
        $db->rollback();
        throw $e; // but the error must be handled anyway
    }

    return 1;

}

function getResponseWithQuestion($response_id)
{
    global $db;
    $query = "SELECT response_value, question FROM responses NATURAL JOIN questions WHERE response_id = :response_id";
    $statement = $db->prepare($query);

    $statement->bindValue(':response_id', $response_id);

    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();
    return $result;
}


function updateResponse($response_id, $new_response)
{
    global $db;
    $query = "UPDATE responses SET response_value = :new_response WHERE response_id = :response_id";
    $statement = $db->prepare($query);

    $statement->bindValue(':new_response', $new_response);
    $statement->bindValue(':response_id', $response_id);
    $statement->execute();
    $statement->closecursor();
}

function followPoll($poll_id){
    global $db;
    $query = "INSERT INTO poll_followed_by (user_following, poll_id) VALUES (:userid, :poll_id)";
    $statement = $db->prepare($query);

    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->bindValue(':poll_id', $poll_id);

    $statement->execute();
    $statement->closecursor();
}

function unfollowPoll($poll_id){
    global $db;
    $query = "DELETE FROM poll_followed_by WHERE user_following = :userid AND poll_id = :poll_id";
    $statement = $db->prepare($query);

    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->bindValue(':poll_id', $poll_id);

    $statement->execute();
    $statement->closecursor();
}

function isUserFollowingPoll($poll_id)
{
    global $db;
    $query = "SELECT COUNT(*) AS cnt FROM poll_followed_by WHERE user_following = :userid AND poll_id = :poll_id";
    $statement = $db->prepare($query);

    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->bindValue(':poll_id', $poll_id);

    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();

    if ($result['cnt'] > 0){
        return 1;
    }
    return 0;
}

function followQuestion($question_id){
    global $db;
    $query = "INSERT INTO question_followed_by (user_following, question_id) VALUES (:userid, :question_id)";
    $statement = $db->prepare($query);

    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->bindValue(':question_id', $question_id);

    $statement->execute();
    $statement->closecursor();
}

function unfollowQuestion($question_id)
{
    global $db;
    $query = "DELETE FROM question_followed_by WHERE user_following = :userid AND question_id = :question_id";
    $statement = $db->prepare($query);

    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->bindValue(':question_id', $question_id);

    $statement->execute();
    $statement->closecursor();
}

function isUserFollowingQuestion($question_id)
{
    global $db;
    $query = "SELECT COUNT(*) AS cnt FROM question_followed_by WHERE user_following = :userid AND question_id = :question_id";
    $statement = $db->prepare($query);

    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->bindValue(':question_id', $question_id);

    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();

    if ($result['cnt'] > 0){
        return 1;
    }
    return 0;
}
function deactivatePoll($poll_id)
{
    global $db;
    $query = "UPDATE polls SET is_active = 0 WHERE poll_id = :poll_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':poll_id', $poll_id);
    $statement->execute();
    $statement->closecursor();
}

function activatePoll($poll_id)
{
    global $db;
    $query = "UPDATE polls SET is_active = 1 WHERE poll_id = :poll_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':poll_id', $poll_id);
    $statement->execute();
    $statement->closecursor();
}


function deactivateQuestion($question_id)
{
    global $db;
    $query = "UPDATE questions SET is_active = 0 WHERE question_id = :question_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':question_id', $question_id);
    $statement->execute();
    $statement->closecursor();
}

function activateQuestion($question_id)
{
    global $db;
    $query = "UPDATE questions SET is_active = 1 WHERE question_id = :question_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':question_id', $question_id);
    $statement->execute();
    $statement->closecursor();
}


function getPollCreator($poll_id)
{
    global $db;
    $query = "SELECT creator FROM poll_created_by WHERE poll_id = :poll_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':poll_id', $poll_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();

    return $result['creator'];
    
}

function isUserCreatorPoll($poll_id)
{
    $creator = getPollCreator($poll_id);
    if ($creator == $_SESSION['uid']){
        return 1;
    }
    return 0;
}

// $query = "SELECT question, poll_id, total_votes, deadline, name AS creator 
// FROM polls NATURAL JOIN poll_created_by NATURAL JOIN users
// WHERE is_active = TRUE AND users.user_id = poll_created_by.creator";

function pollsFollowedBy()
{
    global $db;
    $query = "SELECT question, poll_id, is_active, total_votes, deadline, name AS creator
        FROM polls NATURAL JOIN poll_followed_by NATURAL JOIN users
            WHERE user_following = :userid";
    $statement = $db->prepare($query);
    $statement->bindValue(':userid', $_SESSION['uid']);
    $statement->execute();
	$results = $statement->fetchAll();
    $statement->closecursor();
    return $results;

}

function getQuestionCreator($question_id)
{
    global $db;
    $query = "SELECT creator FROM question_created_by WHERE question_id = :question_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':question_id', $question_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closecursor();

    return $result['creator'];
    
}

function isUserCreatorQuestion($question_id)
{
    $creator = getQuestionCreator($question_id);
    if ($creator == $_SESSION['uid']){
        return 1;
    }
    return 0;
}

function deletePoll($poll_id)
{
    echo "here";
    global $db;
    $query = "CALL deletePoll(:poll_id)";
    $statement = $db->prepare($query);
    $statement->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closecursor();
}


function deleteQuestion($question_id)
{
    global $db;
    $query = "CALL deleteQuestion(:question_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':question_id', $question_id);
    $statement->execute();
    $statement->closecursor();
}

function deleteResponse($response_id, $question_id)
{
    global $db;
    $query = "CALL deleteResponse(:response_id, :question_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':response_id', $response_id);
    $statement->bindValue(':question_id', $question_id);
    $statement->execute();
    $statement->closecursor();
}
?>

