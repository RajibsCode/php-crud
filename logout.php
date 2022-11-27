<?php
// 1 atfirst session start
session_start();

// 2 can use this unset for dismiss session and logout
// unset($_SESSION['user_data']);

// 4 total session distroy 
session_destroy();

// 3 redirect after logout
header('Location:login.php');


?>