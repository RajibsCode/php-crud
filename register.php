
<?php

// 1 atfirst start session and require the db file
session_start();
require_once'db-connection.php';

// 2 start code for submit form
if (isset($_POST['register'])) {

// 4 set image path and make unique img name and extension
$path = 'includes/img/';
$extension = pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION);
$file_name = $_POST['firstname'].'_'.date('YmdHms').'.'.$extension;

// 5 use ternary operator for file_exists validation
$profile = (file_exists($_FILES['profile']['tmp_name'])) ? $file_name : null;

   // 3 set column name as key and input name as value in array
   $insert_data = [
    'fname' => $_POST['firstname'],
    'lname' => $_POST['lastname'],
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'contact' => $_POST['contact'],
    'gender' => $_POST['gender'],
    'adress' => $_POST['address'],
    'state' => $_POST['state'],
    'profile' => $profile,
    'hobbies' => implode(',',$_POST['hobbies']) // 4 implode() for values separate with comma
   ];

   // 7 take comma separate array_keys and values from array
   $columns = implode(',',array_keys($insert_data));
   $values = implode("','",array_values($insert_data));

   // 6 insert and execute query
   $sql = "INSERT INTO user ($columns) VALUES ('$values')";
   $insert = $con->query($sql);

   // 8 set condition for alert
   if ($insert) {

    // 9 then file upload to folder
    if (!is_null($profile)) {
        move_uploaded_file($_FILES['profile']['tmp_name'],$path.$file_name);
    }

    echo '<div class="alert alert-success" role="alert">
    Your data submitted successfully! Thank you for register.
    </div>';
   }else{
    echo '<div class="alert alert-danger" role="alert">
    Sorry For Server Error! Please try again.
    </div>';
    // 10 set header() if query failed
    header("refresh:3;url:register.php");
   }



//    echo "<pre>";
//    print_r($insert_data);
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
    <title>User Registration</title>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand me-auto" href="#">Users Data</a>
            <a class="btn btn-primary logout-button" href="login.php">Login Now</a>

          </div>
        </div>
      </nav>


    <div class="user-registration mt-5 mb-5">
        <h4>Register Now</h4>
        <a href="#">Already Have Account!</a>
        <form class="mt-3" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="firstname" class="form-label">First name</label>
          <input type="text" class="form-control" id="firstname" name="firstname" required="">
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Last name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required="">
        </div>   

        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required="">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Create Password</label>
          <input type="password" class="form-control" id="password" name="password" required="">
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact Number</label>
            <input type="tel" class="form-control" id="contact" name="contact" required="">
        </div>

        <div class="mb-3">
            <label class="form-label">Your Gender</label>
            <br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                <label class="form-check-label" for="female">Female</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control" id="address" rows="3" required=""></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">State</label>
            <select class="form-select" aria-label="Default select example" required="" name="state">
                <option selected>select</option>
                <option value="gj">Gujrat</option>
                <option value="dl">Delhi</option>
                <option value="rj">Rajasthan</option>
                <option value="mh">Maharashtra</option>
                <option value="sk">Sikkim</option>
                <option value="pb">Punjab</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Your Image</label>
            <input name="profile" class="form-control" type="file" required="">
        </div>

        <div class="mb-3">
            <label class="form-label">Hobbies</label>
            <br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="travel" value="travel" name="hobbies[]">
                <label class="form-check-label" for="travel">Travel</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="music" value="music" name="hobbies[]>
                <label class="form-check-label" for="music">Music</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="coding" value="coding" name="hobbies[]>
                <label class="form-check-label" for="coding">Coding</label>
            </div>
        </div>

        <button name="register" type="submit" class="btn btn-success">Create Account</button>
      </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>