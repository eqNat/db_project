<?
include "utility_functions.php";
include "verifysession.php";

// Verify where we are from, employee.php or  emp_update_action.php.
 $q_eid = $_GET["clientid"];

  // the sql string
  $sql = "select * from v_student_info where clientid = '$clientid'"; // get student info view
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
  $isGraduate = $values[4];
  $status = $values[5];

  $type = "UnderGraduate";  
  if($isGraduate == 1){
    $type = "Graduate";
  }

  $stat = "Good";  
  if($status == 1){
    $stat = "Probation";
  }

  echo("
   <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">ID: </h3><p style=\"margin:5\">$eid</p></div>
   <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Name: </h3><p style=\"margin:5\">$name</p></div>
   <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Age: </h3><p style=\"margin:5\">$age</p></div>
   <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Address: </h3><p style=\"margin:5\">$address</p></div>
   <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Type: </h3><p style=\"margin:5\">$type</p></div>
   <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Status: </h3><p style=\"margin:5\">$stat</p></div>
    "); 
  
?>
