
<?php

// 1 atfirst start session and require the db file
session_start();
require_once'db-connection.php';

// 2 start code foir submit form
if (isset($_POST['login'])) {

  // 3 prevent sql injection with mysqli_real_escape_string()
  $email = mysqli_real_escape_string($con,$_POST['email']);
  $password = mysqli_real_escape_string($con,$_POST['password']);

  // 4 set and execute query
  $sql = "SELECT * FROM user WHERE email = '$email' AND password ='$password'";
  $execute = $con->query($sql);

  // 5 set condition for login
  if ($execute->num_rows > 0) {

    // 7 set data in session by fetch_object()
    $_SESSION['user_data'] = $execute->fetch_object();
    // echo "<pre>";
    // print_r($_SESSION);

    // 6 redirect after login
    header("Refresh:1, url=index.php");

  }

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./includes/css/style.css">
    <title>User Login</title>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand me-auto" href="#">Users Data</a>
            <a class="btn btn-success logout-button" href="register.php">Register Now</a>

          </div>
        </div>
      </nav>




    <div class="user-registration mt-5 mb-5">
        <h4>Login Now</h4>
        <a href="register.php">OR Register An Account!</a>

        <?php
          // 8 alert show
          if (isset($_SESSION['user_data'])) {

              echo '<div class="alert alert-success" role="alert"> Welcome ' . $_SESSION['user_data']->fname .' Thanks For Login!</div>'; // show data from session

          }elseif (isset($execute) && $execute->num_rows < 1) {

            echo '<div class="alert alert-danger" role="alert">Email Or Password in invalid</div>';
          }
        ?>
        
        <form class="mt-3" method="post">
          
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Enter Password</label>
          <input type="password" class="form-control" id="password" name="password">
        </div>

        <button name="login" type="submit" class="btn btn-success">Login Now</button>
      </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>