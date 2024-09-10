<?php
error_reporting(0);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schedulling_meeting";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if($conn)
    {
        // echo "Successful";
    }
    else
    {
        echo "Failed..!".mysqli_connect_error();
    }
?>

