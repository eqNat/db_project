<?php
require_once "utility_functions.php";
require_once "verifysession.php";

// Suppress PHP auto warnings.
ini_set("display_errors", 0);

try
{// Add user to database
    $connection = oci_connect_local();

    {// Insert myclient record
        $sql_myclient = "insert into myclient values(
                         :clientid,
                         :fname,
                         :lname,
                         :password,
                         ".($_POST['isadmin'] ? "1" : "0").")";

        $stmt_myclient = oci_parse($connection, $sql_myclient);
        if (! $stmt_myclient)
        {// Throw an exception
            $error = oci_error($connection);
            throw new Exception($error['message']);
        }

        // If a bind fails...
        if (! (oci_bind_by_name($stmt_myclient, ':clientid', $_POST['eid'], 10)
            && oci_bind_by_name($stmt_myclient, ':fname', $_POST['fname'], 30)
            && oci_bind_by_name($stmt_myclient, ':lname', $_POST['lname'], 30)
            && oci_bind_by_name($stmt_myclient, ':password', $_POST['password'], 20)
        ) )
        {// ...Throw an exception
            $error = oci_error($stmt_myclient);
            throw new Exception($error['message']);
        }

        // We don't want to commit 'myclient' without 'student',
        // which is why we use 'OCI_NO_AUTO_COMMIT'
        if (! oci_execute($stmt_myclient, OCI_NO_AUTO_COMMIT))
        {// throw an exception
            $error = oci_error($stmt_myclient);
            throw new Exception($error['message']);
        }
    }

    if (isset($_POST["isstudent"]))
    {// Insert student record
        $sql_student = "insert into student values
            (student_id_seq.nextval,
            :age,
            :country,
            :admin_div,
            :city,
            :street,
            :apt_num,
            :zip,
            :clientid)";

        $stmt_student = oci_parse($connection, $sql_student);
        if (! $stmt_student)
        {// Throw an exception
            $error = oci_error($connection);
            throw new Exception($error['message']);
        }

        // If a bind fails...
        if (! (oci_bind_by_name($stmt_student, ':age', $_POST['age'], 3)
            && oci_bind_by_name($stmt_student, ':country', $_POST['country'], 30)
            && oci_bind_by_name($stmt_student, ':admin_div', $_POST['admin_div'], 30)
            && oci_bind_by_name($stmt_student, ':city', $_POST['city'], 30)
            && oci_bind_by_name($stmt_student, ':street', $_POST['street'], 30)
            && oci_bind_by_name($stmt_student, ':apt_num', $_POST['apt_num'], 10)
            && oci_bind_by_name($stmt_student, ':zip', $_POST['zip'], 9)
            && oci_bind_by_name($stmt_student, ':clientid', $_POST['eid'], 10)
        ) )
        {// ...Throw an exception
            $error = oci_error($stmt_student);
            throw new Exception($error['message']);
        }

        if (! oci_execute($stmt_student, OCI_NO_AUTO_COMMIT))
        {// Throw an exception
            $error = oci_error($stmt_student);
            throw new Exception($error['message']);
        }
    }
    oci_commit($connection);
}
catch (Exception $e)
{
    $_SESSION['user_add_error'] = $e->getMessage();
    oci_rollback($connection);
}
finally
{
    oci_close($connection);
    Header("Location:user_add.html");
    exit();
}

?>
