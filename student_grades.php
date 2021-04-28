<?
require_once "utility_functions.php";
require_once "verifysession.php";

if ($isstudent == 0) {
  die("Error: only students can view this page.");
}
////////////////////////////////  Summary Section  ////////////////////////////////
//  total number of courses completed,
//   total credit hours earned, 
//   and the GPA
 // the sql string
 $sql = "select count(*)
         from enrolled e 
         join section s on e.crn = s.crn 
         join course c on s.courseid = c.id 
         where e.studentid = $studentid
         and e.grade is not null";

echo($sql);

// execute sql
 $result_array = execute_sql_in_oracle ($sql);
 $result = $result_array["flag"];
 $cursor = $result_array["cursor"];

 if ($result == false)
 {
   display_oracle_error_message($cursor);
   die("Query Failed.");
 }

// test if result returned
if( ($values = oci_fetch_array($cursor)) != false)
{
  oci_free_statement($cursor);
  echo "Made it here";
  echo( "<br>$studentid");
  echo( "<br>$values[0]");
  
  
}

 $numCoursesComplete = is_null($values[0]) ? "NA" : $values[0];
 $hours = is_null($values[1]) ? "NA" : $values[1];
 $gpa = is_null($values[2]) ? "NA" : $values[2];

 echo("
 <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Courses Completed: </h3><p style=\"margin:5\">$numCoursesComplete</p></div>
 <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Total Hours: </h3><p style=\"margin:5\">$hours</p></div>
 <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">GPA: </h3><p style=\"margin:5\">$gpa</p></div>
   "); 
 

////////////////////////////////  Summary Section  ////////////////////////////////

  // the sql string
  $sql = "select * from v_student_section where studentid = '$studentid'"; // get student info view
  // $sql = "select clientid, fname, lname, isadmin
  // from myclient where clientid = '$q_eid'";
 
  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if($result == false)
  {
    display_oracle_error_message($cursor);
    die("Query Failed.");
  }

// Display the query results
echo "<table border=1>";
echo ("<tr> 
  <th>Section Id</th> 
  <th>Number</th>
  <th>Title</th>
  <th>Semester</th>
  <th>Credits</th> 
  <th>Grade</th>
</tr>");

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor))
{
  $eid = $values[0];
  $number = $values[1];
  $title = $values[2];
  $semester = $values[3];
  $credits = $values[4];
  $grade = $values[4];

  echo("
    <tr>
      <td>$eid</td>
      <td>$number</td>
      <td>$title</td>
      <td>$semester</td>
      <td>$credits</td>
      <td>$grade</td>
    </tr>");
}
oci_free_statement($cursor);
echo "</table>";


echo("
<br/>
<form method=\"post\" action=\"welcomepage.php\">
<input type=\"submit\" value=\"Go Back\">
</form>
");
?>
