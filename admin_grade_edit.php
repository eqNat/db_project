<?
include "utility_functions.php";
include "verifysession.php";

echo("
  <form method=\"post\" action=\"admin_grade_edit_action.php\">
  Student ID (Required): <input type=\"text\" value = \"\" size=\"20\" maxlength=\"30\" name=\"studentId\">  <br />
  Section ID (Required): <input type=\"text\" value = \"\" size=\"20\" maxlength=\"30\" name=\"sectionId\">  <br />
  Grade (Required): <input type=\"text\" value = \"\" size=\"20\" maxlength=\"30\" name=\"grade\">  <br />
"); 

echo("
  <input type=\"submit\" value=\"Update\">
  <input type=\"reset\" value=\"Reset to Original Value\">
  </form>

  <form method=\"post\" action=\"user_management.php\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");
?>
