<?
include "utility_functions.php";
include "verifysession.php";

// Verify where we are from, employee.php or  emp_update_action.php.
 $q_eid = $_GET["eid"];

  // the sql string
  $sql = ''; // get student info view
  // $sql = "select clientid, fname, lname, isadmin
  // from myclient where clientid = '$q_eid'";
 
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
  $name = $values[1];
  $age= $values[2];
  $address = $values[3];
  $type = $values[4];
  $status = $values[5];

  echo("
    <h3>ID: </h3><p>\"$eid\"</p><br/>
    <h3>Name: </h3><p>\"$name\"</p>
    <h3>Age: </h3><p>\"$age\"</p>
    <h3>Age: </h3><p>\"$address\"</p>
    <h3>Type: </h3><p>\"$type\"</p>
    <h3>Status: </h3><p>\"$status\"</p>
    "); 
  
    echo("
    <form method=\"post\" action=\"user_management.php\">
    <input type=\"submit\" value=\"Go Back\">
    </form>
  ");
?>
