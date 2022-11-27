<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "php_crud";
// 2 call the function for work error
mysqli_report(MYSQLI_REPORT_STRICT);

try {
    // 1 database connection
    $con = new mysqli($servername,$username,$password,$db);
    date_default_timezone_set('Asia/Dhaka');
} catch (Exception $ex) {
    // 3 show error if connection failed
    echo "Dtabase Connection Error :" . $ex->getMessage();
}



?>