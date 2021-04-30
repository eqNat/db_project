<?php
require_once "utility_functions.php";
require_once "verifysession.php";

// Suppress PHP auto warnings.
//ini_set("display_errors", 0);

try
{// Enroll student
    $connection = oci_connect_local();

    $i = 0;
    foreach ($_POST['crn'] as $crn)
    {
        if (strlen($crn) == 0)
            continue;

        $i++;
        if (! is_numeric($crn))
            throw new Exception("input $i: $crn is not an int");

        $crn_int = intval($crn);

        $stmt = oci_parse($connection, 'begin :r := enroll(:s_id, :s_crn); end;');
        if (! $stmt)
        {// Throw an exception
            $error = oci_error($connection);
            throw new Exception($error['message']);
        }

        // If a bind fails...
        if (! (oci_bind_by_name($stmt, ':s_id', $studentid, 10)
            && oci_bind_by_name($stmt, ':s_crn', $crn_int, 10)
            && oci_bind_by_name($stmt, ':r', $r, 1)
        ) )
        {// ...Throw an exception
            $error = oci_error($stmt);
            throw new Exception($error['message']);
        }

        if (! oci_execute($stmt, OCI_NO_AUTO_COMMIT))
        {// throw an exception
            $error = oci_error($stmt);
            die($error['message']);
            throw new Exception($error['code']);
        }

        if ($r)
            switch ($r) {
            case 1:
                    throw new Exception("input $i: Section does not exist");
                    break;
            case 2:
                    throw new Exception("input $i: Prerequisite courses are not met");
                    break; 
            case 3:
                    throw new Exception("input $i: Section passed deadline");
                    break; 
            case 4:
                    throw new Exception("input $i: Current Section times overlap");
                    break; 
            case 5:
                    throw new Exception("input $i: Class is done or currently enrolled for");
                    break; 
            case 6:
                    throw new Exception("input $i: Section at max capacity");
                    break;
            default:
                    // this should never show
                    die("error: unspecified error: $r");
            }
    }
    oci_commit($connection);
    $_SESSION['enrollment_status'] = "Successfully enrolled";
}
catch (Exception $e)
{
    $_SESSION['enrollment_status'] = $e->getMessage();
    oci_rollback($connection);
}
finally
{
    oci_close($connection);
    Header("Location:student_enrollment.html");
    exit();
 }
?>
