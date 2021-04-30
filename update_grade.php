<?
// include the verification PHP script
require_once "utility_functions.php";
require_once "verifysession.php";


// include "verifysession.php";
// include "utility_functions.php";

$sessionid =$_GET["sessionid"];

// Get values for the record to be added if from emp_add_action.php
$eid = $_GET["eid"];
$sql = "select e.crn, title 
FROM enrolled e
JOIN student s on e.studentid = s.studentid
JOIN section sc on sc.crn = e.crn
JOIN course c on sc.courseid = c.id
where s.clientid = '$eid'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.") ;
}

echo("
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  margin: auto;
  width: 400px;
  border-radius: 5px;
  border-width:1px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>

<div>
<form method=\"post\" action=\"update_grade_action.php\">
    <label for=\"sid\">Student Id:</label>
    <input placeholder=\"Enter Student ID\" type=\"text\" id=\"sid\" name=\"sid\"><br><br>
    <label for=\"crn\">CRN:</label>
    <input placeholder=\"Enter CRN\" type=\"text\" id=\"crn\" name=\"crn\"><br><br>
    <label for=\"grade\">Grade:</label>
    <select name=\"grade\" id=\"grade\">
        <option value=\"4\">A</option>
        <option value=\"3\">B</option>
        <option value=\"2\">C</option>
        <option value=\"1\">D</option>
        <option value=\"0\">F</option>
    </select><br><br>
    <input type=\"submit\" value=\"Submit\">
</form>
</div>
");
?>