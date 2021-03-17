<?
include "verifysession.php";
include "utility_functions.php";

$sessionid =$_GET["sessionid"];

// Get values for the record to be added if from emp_add_action.php
$eid = $_POST["eid"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];

// display the insertion form.
echo("
  <form method=\"post\" action=\"user_add_action.php?sessionid=$sessionid\">
  Id (Required, up to 10 digits): <input type=\"text\" value = \"$eid\" size=\"10\" maxlength=\"10\" name=\"eid\"> <br /> 
  Firstname (Required): <input type=\"text\" value = \"$fname\" size=\"20\" maxlength=\"30\" name=\"fname\">  <br />
  Lastname (Required): <input type=\"text\" value = \"$lname\" size=\"20\" maxlength=\"30\" name=\"lname\">  <br />
  Student (Required): <input type=\"checkbox\" checked = \"$isstudent\" value = \"isstudent\" name=\"isstudent\" >  <br />
  Admin (Required): <input type=\"checkbox\" checked = \"$isadmin\" value = \"isadmin" name=\"isadmin\" >  <br />
  ");

echo(" 
  <input type=\"submit\" value=\"Add\">
  <input type=\"reset\" value=\"Reset to Original Value\">
  </form>
  <form method=\"post\" action=\"user_management.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
?>