<?
// include the verification PHP script
Include "verifysession.php";
include "utility_functions.php";

$sessionid =$_GET["sessionid"];

// Get values for the record to be added if from change_password_action.php
$opwn = $_POST["opwn"];
$npwd = $_POST["npwd"];
$cpwd = $_POST["cpwd"];
$isstudent = 0;
$isadmin = 0;

if(isset($_POST['isstudent']))
  {
    $isstudent = 1;
  }

  if(isset($_POST['isadmin']) )
  {
    $isadmin = 1;
  }

// display form
echo("
  <form method=\"post\" action=\"change_password_action.php?sessionid=$sessionid\">
   <label for=\"opwd\">Old Password:</label><input type=\"password\" value=\"$opwn\" name=\"opwd\" id=\"opwd\"><br/>
   <label for=\"npwd\">New Password:</label><input type=\"password\" value=\"$npwd\" name=\"npwd\" id=\"npwd\"><br/>
   <label for=\"cpwd\">Confirm Password:</label><input type=\"password\" value=\"$cpwd\" name=\"cpwd\" id=\"cpwd\"><br/>
   <input type=\"submit\" name=\"Submit\" value=\"Change Password\" />
  </form>
  ");
echo("
  <br/>
  <form method=\"post\" action=\"welcomepage.php?sessionid=$sessionid\">
   <input type=\"submit\" value=\"Go Back\">
  </form>
  ");
?>