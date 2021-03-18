<?
// include the verification PHP script
include "verifysession.php";

if ($sessionid == "") { 
  // no active session - clientid is unknown
  echo("Invalid user!");
} 
else {
  // here we can generate the content of the welcome page

  // https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php 
  // I implemented endsWith()
  $from = "login.html";
  if (substr(getenv("HTTP_REFERER"), -strlen($from)) === $from) {
    echo("Hello, welcome to my Website.<br/>");
  }

  echo("
  Click here to <a href='logout_action.php?sessionid=$sessionid' tite='Logout'>Logout.</a>
  ");

  echo("<br/>$isstudent");
  echo("<br/>$isadmin");

  if ($isadmin == 1){
    echo("<BR>
      Click here to <a href='user_management.php?sessionid=$sessionid' tite='Logout'>do admin stuff.</a>
    ");
  }
  if ($isstudent == 1) {
    echo ("<BR>
      <a href='table.html?sessionid=$sessionid' tite='Logout'>View Grades</a>
        ");
  }

  echo("<BR>
    <a href='change_password.html'>Change Password</a>
  ");
}
?>
