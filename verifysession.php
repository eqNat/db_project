<?
session_start();
$sessionid = session_id();;

$clientid = "";
$fname = "";
$lname = "";
$isadmin = 0;
$isstudent = 0; 

$connection = oci_connect ("gq024", "ycanmf", "gqiannew2:1521/pdborcl");

if($connection == false){
  $e = oci_error(); 
  echo $e['message']."<BR>";
  $sessionid=""; 
} 
else {   
  // connection OK - validate current sessionid 
  if (!isset($sessionid) or ($sessionid=="")) { 
    // no session to maintain 
    $sessionid=""; 
  }
  else{ 
    // lookup the sessionid in the session table to get the clientid 

    $sql = "select a.clientid, b.fname, b.lname, b.isadmin, b.studentid " .
           "from myclientsession a " .
           "join myclient b on a.clientid = b.clientid " .
           "where sessionid='$sessionid'";  

    $cursor = oci_parse($connection, $sql);
    if($cursor == false){
      $e = oci_error($connection);  
      echo $e['message']."<BR>";
      // query failed - login impossible
      $sessionid="";
    }
    else{       
      $result = oci_execute($cursor);
      if ($result == false){
        $e = oci_error($cursor);  
        echo $e['message']."<BR>";
        $sessionid="";
      }
      else{
        if($values = oci_fetch_array ($cursor)){
          // found the sessionid          
          $clientid = $values[0];
          $fname = $values[1];
          $lname = $values[2];
          $isadmin = $values[3];
          $isstudent = is_null($values[4]) ? 0 : 1;
        } 
        else { 
          // invalid sessionid 
          $sessionid = ""; 
        } 
      } 
      oci_free_statement($cursor);
    }
  } 
  oci_close($connection);
} 
?>
