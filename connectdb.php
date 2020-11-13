<?php

/************** CS Server Database Connections **************/
echo "CS Server ";
$host = 'usersrv01.cs.virginia.edu';
$dbname = 'jhf5my';

// user account
$username = 'jhf5my_a';
$password = 'aBcDe&12345';

// dev account
// $username = 'jhf5my_b';
// $password = 'aBcDe&12345';

// admin account
// $username = 'jhf5my';
// $password = 'aBcDe&12345';


/************** XAMPP Database Connections **************/
// echo "XAMPP ";
// $host = 'localhost:3306';
// $dbname = 'jhf5my';

// user acccount
// $username = 'user';
// $password = 'password';

// developer account
// $username = 'dev';
// $password = 'aBcDe&12345';

// admin account
// $username = 'jhf5my';
// $password = 'aBcDe&12345';





/******************************/
// db connection

$dsn = "mysql:host=$host;dbname=$dbname";
$db = "";

session_start();

/** connect to the database **/
try 
{
   $db = new PDO($dsn, $username, $password);   
   echo "<p>You are connected to the database $dbname </p>";
}
catch (PDOException $e)     // handle a PDO exception (errors thrown by the PDO library)
{
   // Call a method from any object, 
   // use the object's name followed by -> and then method's name
   // All exception objects provide a getMessage() method that returns the error message 
   $error_message = $e->getMessage();        
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)       // handle any type of exception
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}


$que

?>