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
    echo("Hello $fname $lname, welcome to my Website.<br/>");
  }

 

  if ($isadmin == 1){
    echo("
    <br/><br/>Admin<br/>  Click here to <a href='user_management.php?sessionid=$sessionid' tite='Logout'>Administer Students</a>
    ");
  }
  if ($isstudent == 1) {
    echo ("
    <br/><br/>Student<br/> Click here to <a href='table.html?sessionid=$sessionid' tite='Logout'>View Grades</a>
        ");
  }

  echo("
  <br/> <br/>Click here to <a href='change_password.php?sessionid=$sessionid'>Change Your Password</a>
  ");

  echo("
  <br/> <br/> Click here to <a href='logout_action.php?sessionid=$sessionid' tite='Logout'>Logout.</a>
  ");
}
?>
