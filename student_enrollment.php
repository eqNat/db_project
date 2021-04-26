<?
include "verifysession.php";
include "utility_functions.php";

// if ($isadmin == 0) {
//     die("Error: only administrators can view this page.");
// }

echo("
  <form method=\"post\" action=\"user_management.php\">
  Semester: <input type=\"text\" size=\"10\" maxlength=\"10\" name=\"q_semester\"> 
  Course Number: <input type=\"text\" size=\"20\" maxlength=\"30\" name=\"q_cnumber\"> 
  <input type=\"submit\" value=\"Submit\">
  </form>
  "); 

//Interpret the query requirements
//$q_semester = $_POST["q_semester"];
//$q_cnumber = strtoupper ($_POST["q_cnumber"]);
$whereClause = " 1 = 1 ";

if (isset($q_semester) and $q_semester != "") { 
  $whereClause .= " and UPPER(fname) like '%$q_semester%'"; 
}

if (isset($q_cnumber) and $q_cnumber != "") { 
  $whereClause .= " and UPPER(lname) like '%$q_cnumber%'"; 
}

// Form the query statement and run it.
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
echo "<table border=1>";
echo ("
  <tr>
    <th>Section</th> 
    <th>Course Number</th>
    <th>Title</th> 
    <th>Credits</th> 
    <th>Semester</th> 
    <th>Time</th>
    <th>Capacity</th>
    <th>Open Seats</th>
    <th>Enroll</th>
  </tr>");

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor)){
  $sId = $values[0];
  $cNumber = $values[1];
  $cTitle= $values[2];
  $credits = $values[3];
  $semester = $values[4];
  $time = $values[5];
  $capacity = $values[6];
  $seatsAvail = $values[7];

  echo("
    <tr>
      <td>$sId</td> 
      <td>$cNumber</td>
      <td>$cTitle</td>
      <td>$credits</td>
      <td>$semester</td>
      <td>$time</td>
      <td>$capacity</td>
      <td>$seatsAvail</td>
      <td><input type=\"checkbox\" value=\"$sId\"></td>
    </tr>"
  );
}
oci_free_statement($cursor);

echo "</table>";

echo("<br />
    <form method=\"post\" action=\"user_add.html\">
    <input type=\"submit\" value=\"Add A New User\">
    </form>
    <form method=\"post\" action=\"welcomepage.php\">
    <input type=\"submit\" value=\"Go Back\">
    </form> ")
?>