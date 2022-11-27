<?php

// 1 atfirst start session and require the db file
session_start();
require_once'db-connection.php';

// 2 get users data by id
if (isset($_GET['user'])) {
    // 3 prevent sql injection
    $u_id = $_GET['user'];


    // 5 delete img from folder also
    $select_user = "SELECT * FROM user WHERE id=$u_id";
    $select_execute = $con->query($select_user);
    
    $user_data = $select_execute->fetch_object();// fetch data from object


    $path = 'includes/img/';
    // delete img from the folder by unlink()
    unlink($path.$user_data->profile);
    



    // 4 delete query and execute
    $delete_user = "DELETE FROM user WHERE id=$u_id";
    $delete_execute = $con->query($delete_user);




    if ($delete_execute) {
        header('Location:index.php');
    }

}






?>