<?
include "utility_functions.php";
include "verifysession.php";

$q_eid = $_GET["eid"];

// Fetech the record to be deleted and display it
$sql = "select clientid, fname, lname, isstudent, isadmin
  from myclient where clientid = '$q_eid'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if (!($values = oci_fetch_array ($cursor))) {
  // Record already deleted by a separate session.  Go back.
  Header("Location:user_management.php");
}
oci_free_statement($cursor);

$eid = $values[0];
$fname = $values[1];
$lname = $values[2];
$isstudent =  $values[3];
$isadmin =  $values[4];

// Display the record to be deleted.
echo("
  <form method=\"post\" action=\"user_delete_action.php\">
  Id (Read-only): <input readonly type=\"text\" value = \"$eid\" size=\"10\" maxlength=\"10\" name=\"eid\"> <br /> 
  Firstname: <input type=\"text\" disabled value = \"$fname\" size=\"20\" maxlength=\"30\" name=\"fname\">  <br />
  Lastname: <input type=\"text\" disabled value = \"$lname\" size=\"20\" maxlength=\"30\" name=\"lname\">  <br />
  Student: <input disabled type=\"checkbox\" "); 
  
  if($isstudent == 1){
    echo(" checked ");
  }
  
  echo(" name=\"isstudent\" >  <br />
  Admin: <input disabled type=\"checkbox\" ");

  if($isadmin ==1){
    echo(" checked ");
  }
  
  echo(" name=\"isadmin\" >  <br />");  

echo("
  </select>  <input type=\"submit\" value=\"Delete\">
  </form>

  <form method=\"post\" action=\"user_management.php\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");
?>
