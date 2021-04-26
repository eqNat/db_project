<?

session_start();

require_once "utility_functions.php";

// Get the client id and password and verify them
$clientid = $_POST["clientid"];
$password = $_POST["password"];

$sql = "select clientid " .
       "from myclient " .
       "where clientid='$clientid'
         and password ='$password'";

echo($sql."<BR>");

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];
echo ($cursor);
if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if($values = oci_fetch_array ($cursor)){
  oci_free_statement($cursor);

  // found the client
  $clientid = $values[0];
  echo "clientid $clientid <br>";

  // check if the session exists
  $sessionid = session_id();

  $sql = "select sessionid from myclientsession where sessionid = '$sessionid'";

  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];
  echo ($cursor);
  echo ("made it here<br>");

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Session Query Failed.");
  }

  if (! oci_fetch_array($cursor)) {
      // create a new session for this client

      // store the link between the sessionid and the clientid
      // and when the session started in the session table
    echo "<br>$sessionid<br>";
    echo "inserting session";
      $sql = "insert into myclientsession " .
        "(sessionid, clientid, sessiondate) " .
        "values ('$sessionid', '$clientid', sysdate)";

      $result_array = execute_sql_in_oracle ($sql);
      $result = $result_array["flag"];
      $cursor = $result_array["cursor"];

    echo "inserted session";

      if ($result == false){
        display_oracle_error_message($cursor);
        die("Failed to create a new session");
      }
      // insert OK - we have created a new session
  }
  header("Location:welcomepage.php");
  exit();
} else { 
  // client username not found
    $_SESSION["error"] = "ERROR";
    header("Location:login.html");
    exit();
} 
?>