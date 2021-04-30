<?
require_once "verifysession.php";
require_once "utility_functions.php";

ini_set( "display_errors", 0);  


$sid = $_POST["sid"];
$crn = $_POST["crn"];
$grade = $_POST["grade"];

echo($sid);
echo($crn);
echo($grade);

// Form the sql string and execute it.
$sql = "
UPDATE enrolled
SET grade = $grade
WHERE studentid = $sid
    and crn = $crn";

    echo($sql);

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Update Failed.</B> <BR />";

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