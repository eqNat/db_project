<?
// include the verification PHP script
include "verifysession.php";

$sessionid = session_id();
if ($sessionid == "") { 
  // no active session - clientid is unknown
  echo("Invalid user!");
} 
else {
  // here we can generate the content of the welcome page
  echo("Hello, welcome to my Website.<br/>
  Click here to <a href='logout_action.php?sessionid=$sessionid' tite='Logout'>Logout.</a>
  ");

  echo("<br/>$isstudent");
  echo("<br/>$isadmin");



}
?>
