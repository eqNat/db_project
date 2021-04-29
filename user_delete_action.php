<?
require_once "verifysession.php";
require_once "utility_functions.php";

ini_set( "display_errors", 0);  

if ($isadmin == 0) {
    die("error: you must be an administrator to enter");
}

$eid = $_POST["eid"];

// Form the sql string and execute it.
$sql = "delete from myclient where clientid = '$eid'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Deletion Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i> 

  <form method=\"post\" action=\"user_management.php\">
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

// Record deleted.  Go back.
Header("Location:user_management.php");
?>
