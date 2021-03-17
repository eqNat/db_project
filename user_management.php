<?
include "verifysession.php";
include "utility_functions.php";

$sessionid =$_GET["sessionid"];

echo("
  <form method=\"post\" action=\"user_management.php?sessionid=$sessionid\">
  Id: <input type=\"text\" size=\"10\" maxlength=\"10\" name=\"q_id\"> 
  First Name: <input type=\"text\" size=\"20\" maxlength=\"30\" name=\"q_fname\"> 
  Last Name: <input type=\"text\" size=\"20\" maxlength=\"30\" name=\"q_lname\"> 
  <input type=\"submit\" value=\"Submit\">
  </form>
  <form method=\"post\" action=\"user_add.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Add A New User\">
  </form>
  "); 

  echo("got here");
//Interpret the query requirements
$q_id = $_POST["q_id"];
$q_fname = strtoupper ($_POST["q_fname"]);
$q_lname = strtoupper ($_POST["q_lname"]);

$whereClause = " 1 = 1 ";
echo($q_eid );
if (isset($q_id) and trim($q_id) != "") { 
  $whereClause .= " and clientid = '$q_id'"; 
}
echo("$whereClause");
if (isset($q_fname) and $q_fname != "") { 
  $whereClause .= " and UPPER(fname) like '%$q_fname%'"; 
}
echo("$whereClause");
if (isset($q_lname) and $q_lname != "") { 
  $whereClause .= " and UPPER(lname) like '%$q_lname%'"; 
}
echo("got here");
// Form the query statement and run it.
$sql = "select clientid, fname, lname
  from myclient where $whereClause order by clientid";

echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

// Display the query results
echo "<table border=1>";
echo "<tr> <th>Id</th> <th>Firstname</th> <th>Lastname</th> <th>Update</th> <th>Delete</th></tr>";

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor)){
  $eid = $values[0];
  $fname = $values[1];
  $lname = $values[2];
  echo("<tr>" . 
    "<td>$eid</td> <td>$fname</td> <td>$lname</td> ".
    " <td> <A HREF=\"user_update.php?sessionid=$sessionid&eid=$eid\">Update</A> </td> ".
    " <td> <A HREF=\"user_delete.php?sessionid=$sessionid&eid=$eid\">Delete</A> </td> ".
    "</tr>");
}
oci_free_statement($cursor);

echo "</table>";

echo("
<br />
<form method=\"post\" action=\"welcomepage.php?sessionid=$sessionid\">
<input type=\"submit\" value=\"Go Back\">
</form> 
")

?>