<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
//verify_session($sessionid);

// Suppress PHP auto warnings.
ini_set( "display_errors", 0);  

// Get the values of the record to be inserted.
$eid = trim($_POST["eid"]);
if ($eid == "") $eid = "NULL";

$id = $_POST["eid"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$pwd = "a";
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

echo($id);
echo($fname);
echo($lname);
echo($pwd);
echo($isstudent);
echo($isadmin);

// Form the insertion sql string and run it.
 $sql = "insert into myclient values ('$id', '$fname', '$lname', '$pwd', '$isstudent','$isadmin')";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Insertion Failed.</B> <BR />";

  display_oracle_error_message($cursor);
  
  die("<i> 

  <form method=\"post\" action=\"emp_add?sessionid=$sessionid\">

  <input type=\"hidden\" value = \"$id\" name=\"eid\">
  <input type=\"hidden\" value = \"$fname\" name=\"fname\">
  <input type=\"hidden\" value = \"$lname\" name=\"lname\">
  <input type=\"hidden\" value = \"$pwd\" name=\"pwd\">
  <input type=\"hidden\" value = \"$isstudent\" name=\"isstudent\">
  <input type=\"hidden\" value = \"$isadmin\" name=\"isadmin\">
  
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

// Record inserted.  Go back.
Header("Location:user_management.php?sessionid=$sessionid");
?>