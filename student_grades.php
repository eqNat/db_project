<?
include "utility_functions.php";
include "verifysession.php";

// Verify where we are from, employee.php or  emp_update_action.php.
 $q_eid = $_GET["eid"];
////////////////////////////////  Summary Section  ////////////////////////////////
//  total number of courses completed,
//   total credit hours earned, 
//   and the GPA
 // the sql string
 $sql = ("
 SELECT (SELECT COUNT(*) 
FROM enrolled 
WHERE studentid = '$q_eid' 
AND grade IS NOT NULL) numCourses
,(SELECT SUM(credits) 
FROM enrolled e 
JOIN section s ON e.crn = s.crn 
JOIN COURSE c on s.courseid = c.id 
WHERE studentid = '$q_eid' 
    AND grade IS NOT NULL) numCredits
,(SELECT (SUM(grade * credits) / SUM(credits))
FROM enrolled e 
JOIN section s ON e.crn = s.crn 
JOIN COURSE c on s.courseid = c.id 
WHERE studentid = '$q_eid'  )  gpa
FROM DUAL");

  // get student info view
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

 $studentid = is_null($values[0]) ? "NA" : $values[0];

 $numCoursesComplete = is_null($values[0]) ? "NA" : $values[0];
 $hours = is_null($values[1]) ? "NA" : $values[1];
 $gpa = is_null($values[2]) ? "NA" : $values[2];

 echo("
 <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Courses Completed: </h3><p style=\"margin:5\">$numCoursesComplete</p></div>
 <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Total Hours: </h3><p style=\"margin:5\">$hours</p></div>
 <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">GPA: </h3><p style=\"margin:5\">$gpa</p></div>
   "); 
 
oci_free_statement($cursor);

////////////////////////////////  Summary Section  ////////////////////////////////

  // the sql string
  $sql = "select * from v_student_section where studentid = '$q_eid'"; // get student info view
  // $sql = "select clientid, fname, lname, isadmin
  // from myclient where clientid = '$q_eid'";
 
  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if ($result == false){
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
while ($values = oci_fetch_array ($cursor)){
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