<?
// include the verification PHP script
require_once "verifysession.php";
require_once "utility_functions.php";

// here we can generate the content of the welcome page
//
// https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php 
// I implemented endsWith()
    echo("<br>Logged in as $fname $lname<br/>");
?>
