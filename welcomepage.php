  <?
// include the verification PHP script
include "verifysession.php";

// here we can generate the content of the welcome page

// https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php 
// I implemented endsWith()
$from = "login.html";
if (substr(getenv("HTTP_REFERER"), -strlen($from)) === $from) {
echo("Hello $fname $lname, welcome to my Website.<br/>");
} else {
echo("Logged in as $fname $lname<br/>");
}

if ($isadmin == 1){
  echo("
  <br/><br/>Admin<br/>  Click here to <a href='user_management.php' tite='Logout'>Administer Students</a>
  ");
}
if ($isstudent == 1) {

  echo ("
  <br/><br/>Student<br/> Click here to <a href='student_grades.php' tite='Logout'>View Grades</a>
    ");
  echo "<br/><br/> Click here to <a href='class_lookup.html' tite='Logout'>Lookup Classes</a>";
  
  echo ("
  <br/><br/>Click here to <a href='student_info.php'>My Info</a>
  ");
  
  echo ("
  <br/><br/>Click here to <a href='student_enrollment.php'>Enroll in Classes</a>
  ");
}

echo("
<br/> <br/>Click here to <a href='change_password.html'>Change My Password</a>
");

echo("
<br/> <br/> Click here to <a href='logout_action.php' tite='Logout'>Logout.</a>
");
?>