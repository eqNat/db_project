<?
include "verifysession.php";
include "utility_functions.php";

$sessionid =$_GET["sessionid"];

// Get values for the record to be added if from emp_add_action.php
$eid = $_POST["eid"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
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

// display the insertion form.
echo("
  <form method=\"post\" action=\"user_add_action.php?sessionid=$sessionid\">
  Firstname (Required): <input type=\"text\" value = \"$fname\" size=\"20\" maxlength=\"30\" name=\"fname\">  <br />
  Lastname (Required): <input type=\"text\" value = \"$lname\" size=\"20\" maxlength=\"30\" name=\"lname\">  <br />
  Student (Required): <input type=\"checkbox\" checked = \"$isstudent\" value = \"isstudent\" name=\"isstudent\" >  <br />
  Admin (Required): <input type=\"checkbox\" checked = \"$isadmin\" value = \"isadmin\" name=\"isadmin\" >  <br />
  ");

echo(" 
  <input type=\"submit\" value=\"Add\">
  <input type=\"reset\" value=\"Reset to Original Value\">
  </form>
  <form method=\"post\" action=\"user_management.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
?>
