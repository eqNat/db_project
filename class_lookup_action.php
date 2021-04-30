<?
require_once "utility_functions.php";
require_once "verifysession.php";

// capture values from search page
$semester = $_POST["semester"];
$subject = $_POST["subject"];
// parse the #### SP/FA/SU string
$semesterparts = explode(" ", $semester);

//echo($semester);
//echo($semesterparts[0]);  // year
//echo($semesterparts[1]);  // FA/SP/SU
//echo($subject);

$sql = "SELECT c.id, c.title, c.description, c.credits, c.subject, s.crn, 
               s.deadline, s.capacity, s.semester, 
               EXTRACT(HOUR FROM s.begin_time) AS beginhour, EXTRACT(minute FROM s.begin_time) AS beginminute,
               EXTRACT(HOUR FROM s.end_time) AS endhour, EXTRACT(minute FROM s.end_time) AS endminute,
               s.ismonday, s.istuesday, s.iswednesday, s.isthursday, s.isfriday
        FROM course c
        JOIN section s ON c.id = s.courseid
        WHERE extract(year from s.deadline) = '$semesterparts[0]'
        AND s.semester = '$semesterparts[1]'
        AND c.subject = '$subject'
        ORDER BY c.title ASC";

// execute sql
$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false)
{
  display_oracle_error_message($cursor);
  die("Query Failed.");
}

$semestername = "Summer";
if( $semesterparts[1] == "FA" )
  $semestername = "Fall";
if( $semesterparts[1] == "SP" )
  $semestername = "Spring";

// Display the query results
echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"tablestyle.css\">");
echo("<h2>$subject offerings during $semestername $semesterparts[0]</h2>");
echo("<table class=\"blueTable\">");
echo("<thead><tr>
  <th>Course Title</th>
  <th>Course Number</th>
  <th>Description</th>
  <th>Credits</th>
  <th>Section Number</th>
  <th>Capacity</th>
  <th>Scheduled</th>
  <th>Begin</th>
  <th>End</th>
</tr></thead>");

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor))
{
  // get values needed for table
  $courseid = $values[0];
  $title = $values[1];
  $description = $values[2];
  $credits = $values[3];
  $subject = $values[4];
  $crn = $values[5];
  $deadline = $values[6];
  $capacity = $values[7];
  $semester = $values[8];
  $begin_hour = $values[9];
  $begin_minute = $values[10];
  $end_hour = $values[11];
  $end_minute = $values[12];
  $ismonday = $values[13];
  $istuesday = $values[14];
  $iswednesday = $values[15];
  $isthursday = $values[16];
  $isfriday = $values[17];

  // build weekday schedule
  $scheduled_days = "";
  if( $ismonday == 1)
  {
  //  echo("is Monday");
    $scheduled_days = $scheduled_days."M";
  }
  if( $istuesday == 1)
  {
  //  echo("is Tuesday");
    $scheduled_days = $scheduled_days."T";
  }
  if( $iswednesday == 1)
  {
  //  echo("is Wednesday");
    $scheduled_days = $scheduled_days."W";
  }
  if( $isthursday == 1)
  {
  //  echo("is Thursday");
    $scheduled_days = $scheduled_days."Th";
  }
  if( $isfriday == 1)
  {
  //  echo("is Friday");
    $scheduled_days = $scheduled_days."F";
  }

  $begin_time = sprintf("%s:%-02s", $begin_hour, $begin_minute);
  $end_time = sprintf("%s:%-02s", $end_hour, $end_minute);

  // add table line
  echo("<tr>
          <td>$title</td>
          <td>$courseid</td>
          <td>$description</td>
          <td>$credits</td>
          <td>$crn</td>
          <td>$capacity</td>
          <td>$scheduled_days</td>
          <td>$begin_time</td>
          <td>$end_time</td>
        </tr>");
}
echo "</table>";





// add go back button to end of page
echo("<br/>
      <form method=\"post\" action=\"class_lookup.html\">
      <input type=\"submit\" value=\"Go Back\">
      </form>");
?>