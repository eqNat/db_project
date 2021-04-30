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
$sql = "SELECT count(*), sum(c.credits), SUM(e.grade * c.credits) / SUM(c.credits)
        FROM enrolled e 
        JOIN section s ON e.crn = s.crn 
        JOIN course c ON s.courseid = c.id
        WHERE e.studentid = $studentid
        AND e.grade IS NOT NULL";

// execute sql
 $result_array = execute_sql_in_oracle ($sql);
 $result = $result_array["flag"];
 $cursor = $result_array["cursor"];

 if ($result == false)
 {
   display_oracle_error_message($cursor);
   die("Query Failed.");
 }

// get results
$values = oci_fetch_array($cursor);
oci_free_statement($cursor);

$numCoursesComplete = is_null($values[0]) ? "NA" : $values[0];
$hours = is_null($values[1]) ? "NA" : $values[1];
$gpa = is_null($values[2]) ? "NA" : $values[2];
$gpa_f = number_format($gpa, 2);

echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"tablestyle.css\">");
echo("<div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Courses Completed: </h3><p style=\"margin:5\">$numCoursesComplete</p></div>
      <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">Total Hours: </h3><p style=\"margin:5\">$hours</p></div>
      <div style=\"display:flex;align-items:center\"><h3 style=\"margin:5\">GPA: </h3><p style=\"margin:5\">$gpa_f</p></div>"); 

////////////////////////////////  Table Section  ////////////////////////////////

// the sql string
$sql = "select * from v_student_section where studentid = $studentid"; // get student info view
 
$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($result == false)
{
  display_oracle_error_message($cursor);
  die("Query Failed.");
}

// Display the query results
echo("<table class=\"blueTable\">");
echo("<thead><tr>
  <th>Course Title</th>
  <th>Course Number</th>
  <th>Section Number</th>
  <th>Credits</th> 
  <th>Semester</th>
  <th>Grade</th>
</tr></thead>");

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor))
{
  // get values needed for table
  $crn = $values[1];
  $courseid = $values[2];
  $title = $values[3];
  $semester = $values[4];
  $credits = $values[5];
  $grade = is_null($values[6]) ? -1 : $values[6];

  // convert grade number to a letter grade for display
  $grade_letter = "";
  switch($grade) 
  {
    case 0:
        $grade_letter = "F";
        break;
    case 1:
        $grade_letter = "D";
        break;
    case 2:
        $grade_letter = "C";
        break;
    case 3:
        $grade_letter = "B";
        break;
    case 4:
        $grade_letter = "A";
        break;
  }

  // add table line
  echo("<tr>
          <td>$title</td>
          <td>$courseid</td>
          <td>$crn</td>
          <td>$credits</td>
          <td>$semester</td>
          <td>$grade_letter</td>
        </tr>");
}
echo "</table>";
// free cursor
oci_free_statement($cursor);

?>
