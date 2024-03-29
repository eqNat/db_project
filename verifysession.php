<?
require_once "utility_functions.php";

session_start();
$sessionid = session_id();

$clientid = "";
$fname = "";
$lname = "";
$isadmin = 0;
$isstudent = 0; 
$studentid = 0; 

$connection = oci_connect_local();

if($connection == false){
  $e = oci_error(); 
  echo $e['message']."<BR>";
  exit();
} 
// connection OK - validate current sessionid 
if (!isset($sessionid) or ($sessionid=="")) { 
    // no session to maintain 
    echo("sessionid is empty");
    exit();
}
// lookup the sessionid in the session table to get the clientid 

$sql = "select a.clientid, b.fname, b.lname, b.isadmin, c.studentid " .
       "from myclientsession a " .
       "join myclient b on a.clientid = b.clientid " .
       "left join student c on b.clientid = c.clientid " .
       "where sessionid='$sessionid'";  

$cursor = oci_parse($connection, $sql);
if($cursor == false){
    echo "parse failed<br>";
    $e = oci_error($connection);  
    echo $e['message']."<BR>";
    // query failed - login impossible
    exit();
}

$result = oci_execute($cursor);
if ($result == false){
    echo "execute failed<br>";
    $e = oci_error($cursor);  
    echo $e['message']."<BR>";
    exit();
}

if ($values = oci_fetch_array ($cursor)){
  // found the sessionid          
  $clientid = $values[0];
  $fname = $values[1];
  $lname = $values[2];
  $isadmin = $values[3];
  $isstudent = is_null($values[4]) ? 0 : 1;
  $studentid = is_null($values[4]) ? 0 : $values[4];
} 
else { 
  // invalid sessionid 
  echo ("Error: session not fount");
  exit();
} 
oci_free_statement($cursor);
oci_close($connection);

echo("Logged in as $fname $lname<br/>");
echo ("<nav>");

if ($isadmin == 1){
  echo("<a href='user_management.php' tite='Logout'>Administer Students</a> | ");
}
if ($isstudent == 1) {

  echo ("<a href='student_grades.php' tite='Logout'>View Grades</a> | ");
  echo "<a href='class_lookup.html' tite='Logout'>Lookup Classes</a> | ";
  
  echo ("<a href='student_info.php'>Student Info</a> | ");
  
  echo ("<a href='student_enrollment.html'>Enroll</a> | ");
}

echo("<a href='change_password.html'>Change My Password</a> | ");

echo("<a href='logout_action.php' tite='Logout'>Logout.</a>");
echo("</nav>");

?>
