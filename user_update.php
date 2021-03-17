<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
//verify_session($sessionid);

// Verify where we are from, employee.php or  emp_update_action.php.
if (!isset($_POST["update_fail"])) { // from employee.php
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
  $isstudent = $values[3];
  $isadmin = $values[4];
}
else { // from emp_update_action.php
  // Obtain values of the record to be updated directly.
  $eid = $values[0];
  $fname = $values[1];
  $lname = $values[2];
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
}

// Display the record to be updated.
echo("
  <form method=\"post\" action=\"user_update_action.php?sessionid=$sessionid\">
  Id (Read-only): <input type=\"text\" readonly value = \"$eid\" size=\"10\" maxlength=\"10\" name=\"eid\"> <br /> 
  Firstname (Required): <input type=\"text\" value = \"$fname\" size=\"20\" maxlength=\"30\" name=\"fname\">  <br />
  Lastname (Required): <input type=\"text\" value = \"$lname\" size=\"20\" maxlength=\"30\" name=\"lname\">  <br />
  Student (Required): <input type=\"checkbox\" checked = \"$isstudent\" value = \"isstudent\" name=\"isstudent\" >  <br />
  Admin (Required): <input type=\"checkbox\" checked = \"$isadmin\" value = \"isadmin\" name=\"isadmin\" >  <br />
  ");

echo("
  <input type=\"submit\" value=\"Update\">
  <input type=\"reset\" value=\"Reset to Original Value\">
  </form>

  <form method=\"post\" action=\"user_management.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");
?>