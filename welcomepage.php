<?
// include the verification PHP script
include "verifysession.php";

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

  if($isadmin == 1){
    echo("
      Click here to <a href='user_management.php?sessionid=$sessionid' tite='Logout'>do admin stuff.</a>
    ");
  }
  echo("<BR>
    <a href='change_password.html'>Change Password</a>
  ");
}
?>
