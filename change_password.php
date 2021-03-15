<?
// include the verification PHP script
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

echo("<FORM name=\"login\" method=\"POST\" action=\"login_action.php\">
        User ID: <INPUT type=\"text\" name=\"clientid\" size=\"8\" maxlength=\"20\"> <br />
        Password: <input type=\"password\" name=\"password\" size=\"20\">
        <INPUT type=\"submit\" name=\"submit\" value=\"Login\">
      </FORM>");

?>