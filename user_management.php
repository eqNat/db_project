<?
require_once "verifysession.php";
require_once "utility_functions.php";

if ($isadmin == 0) {
    die("Error: only administrators can view this page.");
}

echo("
<link rel=\"stylesheet\" type=\"text/css\" href=\"tablestyle.css\">
<h3>Student Search</h3>
  <form method=\"post\" action=\"user_management.php\">
  Id: <input type=\"text\" size=\"10\" maxlength=\"10\" name=\"q_id\"> 
  First Name: <input type=\"text\" size=\"20\" maxlength=\"30\" name=\"q_fname\"> 
  Last Name: <input type=\"text\" size=\"20\" maxlength=\"30\" name=\"q_lname\"> <br/>
  Student: <input type=\"checkbox\" size=\"20\" maxlength=\"30\" name=\"q_student\"> <br/>
  Admin: <input type=\"checkbox\" size=\"20\" maxlength=\"30\" name=\"q_admin\"> <br/><br/>
  <input type=\"submit\" value=\"Submit\">
  </form>
  "); 

//Interpret the query requirements
$q_id = $_POST["q_id"];
$q_fname = strtoupper ($_POST["q_fname"]);
$q_lname = strtoupper ($_POST["q_lname"]);
$q_student = $_POST["q_student"];
$q_admin = $_POST["q_admin"];
$whereClause = " 1 = 1 ";

if (isset($q_id) and trim($q_id) != "") { 
  $whereClause .= " and myclient.clientid = '$q_id'"; 
}

if (isset($q_fname) and $q_fname != "") { 
  $whereClause .= " and UPPER(fname) like '%$q_fname%'"; 
}

if (isset($q_lname) and $q_lname != "") { 
  $whereClause .= " and UPPER(lname) like '%$q_lname%'"; 
}

if (isset($q_student)) { 
  $whereClause .= " and studentid IS NOT NULL"; 
}

if (isset($q_admin)) { 
  $whereClause .= " and isadmin = 1"; 
}

// Form the query statement and run it.
$sql = "select myclient.clientid, fname, lname, isadmin, password, studentid
  from myclient " .
  "left join student on myclient.clientid = student.clientid " .
  "where $whereClause order by myclient.clientid";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.") ;
}

// Display the query results
echo "<table class=\"blueTable\">";
echo "<thead><tr> <th>Id</th> <th>Firstname</th> <th>Lastname</th> <th>Student ID</th> <th>Admin</th> <th>Update</th> <th>Delete</th> <th>Password Reset</th> <th>Password</th> </tr></thead>";

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor)){
  $eid = $values[0];
  $fname = $values[1];
  $lname = $values[2];
  $isadmin = $values[3];
  $password = $values[4];
  $studentid = is_null($values[5]) ? "NA" : $values[5];

  echo("<tr>" . 
    "<td>$eid</td> <td>$fname</td> <td>$lname</td><td>$studentid</td> <td>$isadmin</td> ".
    " <td> <A HREF=\"user_update.php?eid=$eid\">Update</A> </td> ".
    " <td> <A HREF=\"user_delete.php?eid=$eid\">Delete</A> </td> ".
    " <td> <A HREF=\"reset_password.php?eid=$eid\">Reset</A> </td> ".
    "<td>$password</td>".
    "</tr>");
}
oci_free_statement($cursor);

echo "</table>";

echo("<br />
    <form method=\"post\" action=\"user_add.html\">
    <input type=\"submit\" value=\"Add A New User\">
    </form>
?>
