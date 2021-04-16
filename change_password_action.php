<?
include "utility_functions.php";
include "verifysession.php";

// Suppress PHP auto warning.
ini_set( "display_errors", 0); 

// Obtain information for the record to be updated.
$opwd = $_POST["opwd"];
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

// Verify how we reach here
if(!isset($_POST["update_fail"])) 
{ // from welceomepage.php

  // validate input - existence
  if( strlen($opwd) == 0 || strlen($npwd) == 0 || strlen($cpwd) == 0 )
  {
    die("<form method=\"post\" action=\"change_password.html\">
    Passwords cannot be blank. Try again:
    <input type=\"submit\" value=\"Go Back\">
    </form>");
  }

  // validate input - new and confirm match
  if( strcmp($npwd, $cpwd) != 0 )
  {
    die("<form method=\"post\" action=\"change_password.html\">
    New and Confirm passwords do not match. Try again:
    <input type=\"submit\" value=\"Go Back\">
    </form>");
  }

  // check old password
  $sql = "select a.clientid from myclient a 
          join myclientsession b on a.clientid = b.clientid 
          where password = '$opwd' and sessionid = '$sessionid'";
  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  // test for query error
  if( $result == false )
  {
    display_oracle_error_message($cursor);
    die("Old Password Query Failed.");
  }

  // test if result returned
  if( ($values = oci_fetch_array($cursor)) != false)
  {
    oci_free_statement($cursor);

    // found the client
    $clientid = $values[0];
    
    // Form the sql string and execute it.
    $sql = "update myclient set password = '$npwd' 
            where clientid = '$clientid'";
    
    $result_array = execute_sql_in_oracle ($sql);
    $result = $result_array["flag"];
    $cursor = $result_array["cursor"];

    if( $result == false )
    {
      display_oracle_error_message($cursor);
      die("Update Query Failed.");
    }

    $values = oci_fetch_array ($cursor);
    oci_free_statement($cursor);
  }
  else 
  { // old password did not match
    die("<form method=\"post\" action=\"change_password.html\">
    Old password was incorrect. Try again:
    <input type=\"submit\" value=\"Go Back\">
    </form>");
  }

  //  update successful
  echo("
    <form method=\"post\" action=\"welcomepage.php\">
      Password update successful!
      <input type=\"submit\" value=\"Continue\">
    </form>
 ");
}
?>
