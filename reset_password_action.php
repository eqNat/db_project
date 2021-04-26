<?
require_once "utility_functions.php";

$eid =$_GET["eid"];

// Suppress PHP auto warning.
ini_set( "display_errors", 0);  


// Form the sql string and execute it.
$sql = "update myclient set password = 'a'  
where clientid = '$eid'";


$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Reset Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i> 

  <form method=\"post\" action=\"user_update\">

  <input type=\"hidden\" value = \"1\" name=\"update_fail\">
  <input type=\"hidden\" value = \"$eid\" name=\"eid\">
  <input type=\"hidden\" value = \"$fname\" name=\"fname\">
  <input type=\"hidden\" value = \"$lname\" name=\"lname\">
  <input type=\"hidden\" value = \"$isstudent\" name=\"isstudent\">
  <input type=\"hidden\" value = \"$isadmin\" name=\"isadmin\">
  
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

// Record updated.  Go back.
Header("Location:user_management.php");
?>
