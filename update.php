
<?php

// 1 atfirst start session and require the db file
session_start();
require_once'db-connection.php';

// 2 update - get users data by id
if (isset($_GET['user'])) {
  // 3 update - perevent sql injection
  $u_id = mysqli_real_escape_string($con,$_GET['user']);
  // 4 update - select and execute data by id
  $select_user = "SELECT * FROM user WHERE id=$u_id";
  $select_execute = $con->query($select_user);
  // 5 update - get data from execute by fetch_object()
  $user_data = $select_execute->fetch_object();


}else{
  header('Location:index.php');
}


// 8 update - form data update
if (isset($_POST['update'])) {
  // 4 set image path and make unique img name and extension
  $path = 'includes/img/';
  $extension = pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION);
  $file_name = $_POST['firstname'].'_'.date('YmdHms').'.'.$extension;

  // 5 use ternary operator for file_exists validation
  $profile = (file_exists($_FILES['profile']['tmp_name'])) ? $file_name : $user_data->profile;// 9 update - change null to current image


   // 3 set column name as key and input name as value in array
   $update_data = [
    // 10 update - input field prevent sql injection
    'fname' => mysqli_real_escape_string($con,$_POST['firstname']),
    'lname' => mysqli_real_escape_string($con,$_POST['lastname']),
    'email' => mysqli_real_escape_string($con,$_POST['email']),
    'password' => mysqli_real_escape_string($con,$_POST['password']),
    'contact' => mysqli_real_escape_string($con,$_POST['contact']),
    'gender' => mysqli_real_escape_string($con,$_POST['gender']),
    'adress' => mysqli_real_escape_string($con,$_POST['address']),
    'state' => mysqli_real_escape_string($con,$_POST['state']),
    'profile' => mysqli_real_escape_string($con,$profile),
    'hobbies' => mysqli_real_escape_string($con,implode(',',$_POST['hobbies'])) // 4 implode() for values separate with comma
   ];

  // 11 update - create update query and exicute
  $sql = "UPDATE user SET ";
  // use loop for full array set in $sql
  foreach ($update_data as $key => $value) {
    $sql .= "$key = '$value',";
  }

  $sql = rtrim($sql,',');// remove right side one extra comma from query
  $sql .= " WHERE id=".$u_id;

  $exec = $con->query($sql);

   // 12 update - set condition for update alert
   if ($exec) {

    // 9 then file upload to folder and delete current img from folder
    if (!is_null($profile)) {
        move_uploaded_file($_FILES['profile']['tmp_name'],$path.$file_name);
        // and delete previous photo from folder
        unlink($path.$user_data->profile);
    }

    echo '<div class="alert alert-success" role="alert">
    Your data Updated successfully!.
    </div>';

    header('Location:index.php');

   }else{
    echo '<div class="alert alert-danger" role="alert">
    Sorry For Server Error! Data not Updated.
    </div>';

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

            <?php
            // 1 update - dynamic logout button
            if (isset($_SESSION['user_data'])) {
              echo '<a class="btn btn-primary logout-button" href="index.php">Dashboard</a>
              <a class="btn btn-danger logout-button" href="logout.php">Logout</a>';
            }
            
            ?>
            

          </div>
        </div>
      </nav>



    <div class="user-registration mt-5 mb-5">
        <h4>Update User</h4>
        <form class="mt-3" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="firstname" class="form-label">First name</label>
          <input value="<?php echo $user_data->fname; ?>" type="text" class="form-control" id="firstname" name="firstname">
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Last name</label>
            <input value="<?php echo $user_data->lname; ?>" type="text" class="form-control" id="lastname" name="lastname">
        </div>   

        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input  value="<?php echo $user_data->email; ?>" name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Create Password</label>
          <input value="<?php echo $user_data->password; ?>" type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact Number</label>
            <input value="<?php echo $user_data->contact; ?>" type="tel" class="form-control" id="contact" name="contact">
        </div>

        <div class="mb-3">
            <label class="form-label">Your Gender</label>
            <br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male" 
                <?php // 6 update - dynamic checked attribute?>
                <?php if ($user_data->gender == 'male') {echo 'checked';} ?>
                >
                <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                <?php if ($user_data->gender == 'female') {echo 'checked';} ?>
                >
                <label class="form-check-label" for="female">Female</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control" id="address" rows="3"><?php echo $user_data->adress; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">State</label>
            <select class="form-select" aria-label="Default select example"  name="state">
                <option >select</option>
                <option
                <?php
                 // 6 update - dynamic selected attribute
                 if($user_data->state == 'gj') {echo 'selected';} ?>
                 value="gj">Gujrat</option>
                <option
                <?php if($user_data->state == 'dl') {echo 'selected';} ?> value="dl">Delhi</option>
                <option
                <?php if($user_data->state == 'rj') {echo 'selected';} ?> value="rj">Rajasthan</option>
                <option
                <?php if($user_data->state == 'mh') {echo 'selected';} ?> value="mh">Maharashtra</option>
                <option
                <?php if($user_data->state == 'sk') {echo 'selected';} ?> value="sk">Sikkim</option>
                <option
                <?php if($user_data->state == 'pb') {echo 'selected';} ?> value="pb">Punjab</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Your Image</label>
            <?php // 8 update - show current image  ?>
            <img src="<?php echo'includes/img/'.$user_data->profile; ?>" alt="" width="80px">
            <input name="profile" class="form-control" type="file">
        </div>

        <div class="mb-3">
            <label class="form-label">Hobbies</label>
            <br>
            <?php
            // 7 update - dynamic selected attribute
            $hobbies_arr = explode(',',$user_data->hobbies);// get hobbies without comma
            ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="travel" value="travel" name="hobbies[]"

                <?php if(in_array('travel',$hobbies_arr)){echo'checked';} ?>>

                <label class="form-check-label" for="travel">Travel</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="music" value="music" name="hobbies[]" 

                <?php if(in_array('music',$hobbies_arr)){echo'checked';} ?>>

                <label class="form-check-label" for="music">Music</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="coding" value="coding" name="hobbies[]"
                
                <?php if(in_array('coding',$hobbies_arr)){echo'checked';} ?>>

                <label class="form-check-label" for="coding">Coding</label>
            </div>
        </div>

        <button name="update" id="update" type="submit" class="btn btn-success">Update Your Data</button>
      </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>