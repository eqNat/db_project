<?
include "utility_functions.php";
include "verifysession.php";

// Verify where we are from, employee.php or  emp_update_action.php.
if (!isset($_POST["reset_fail"])) { // from employee.php
  // Fetch the record to be updated.
  $q_eid = $_GET["eid"];

  // the sql string
  $sql = "select clientid, fname, lname, isstudent, isadmin
  from myclient where clientid = '$q_eid'";
 
  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Query Failed.");
  }

  $values = oci_fetch_array ($cursor);
  oci_free_statement($cursor);

  $eid = $values[0];
  $fname = $values[1];
  $lname = $values[2];
}
else { // from emp_update_action.php
  // Obtain values of the record to be updated directly.
  $eid = $values[0];
  $fname = $values[1];
  $lname = $values[2];  
}

echo("
<form method=\"post\" action=\"reset_password_action.php?eid=$eid\">
  Id: <input type=\"text\" readonly value = \"$eid\" size=\"10\" maxlength=\"10\" name=\"eid\"> <br /> 
  Firstname: <input type=\"text\" disabled value = \"$fname\" size=\"20\" maxlength=\"30\" name=\"fname\">  <br />
  Lastname: <input type=\"text\" disabled value = \"$lname\" size=\"20\" maxlength=\"30\" name=\"lname\">  <br />
  <br/>  <input type=\"submit\" value=\"Set Password To Default\">
  </form>

  <form method=\"post\" action=\"user_management.php\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");
?>
