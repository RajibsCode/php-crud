
<?php
// 1 start session and require db file
session_start();
require_once 'db-connection.php';

// 9 another system for protect index page
if (!isset($_SESSION['user_data'])) {
  header('Location:login.php');
}

// 2 select query
$sql = "SELECT * FROM user";
$execute = $con->query($sql);

// 3 fetch_object() for get data use while loop for all data
while ($data = $execute->fetch_object()) {
  // 4 get al data in a array
  $users[] = $data;
}

// 6 make array for full form data for state
$states = [
  'gj' => 'Gujrat',
  'dl' => 'Delhi',
  'rj' => 'Rajasthan',
  'mh' => 'Maharashtra',
  'sk' => 'Sikkim',
  'pb' => 'Punjab',
];


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
            // 8 Dynamic logut button and protect index page
            if (isset($_SESSION['user_data'])) {
              echo '<a class="btn btn-danger logout-button" href="logout.php">Logout Now</a>';
            }else{
              echo '<a class="btn btn-primary logout-button" href="#">Login Now</a>';
              header("Location:login.php");
            }
            ?>

          </div>
        </div>
      </nav>

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Contact</th>
            <th scope="col">Gender</th>
            <th scope="col">Adress</th>
            <th scope="col">State</th>
            <th scope="col">Hobby</th>
            <th scope="col">Profile Image</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>

        <?php
          // for serial number
          $s=1;
          // 5 data show in table by loop
          foreach ($users as $user) {
        ?>
          <tr>
            <th scope="row"><?php echo $s; ?></th>
            <td><?php echo $user->fname; ?></td>
            <td><?php echo $user->lname; ?></td>
            <td><?php echo $user->email; ?></td>
            <td><?php echo $user->contact; ?></td>
            <td><?php echo $user->gender; ?></td>
            <td><?php echo $user->adress; ?></td>
            <?php // 7 use ternary operator for show state ?>
            <td><?php echo isset($states[$user->state]) ? $states[$user->state] : null; ?></td>
            <td><?php echo $user->hobbies; ?></td>
            <td><img src="<?php echo 'includes/img/' . $user->profile;?>" alt="img here" width="50px"></td>
            <td>
                <a href="update.php?user=<?php echo $user->id; ?>" class="btn btn-warning edit-button">Edit</a>
                <a href="delete.php?user=<?php echo $user->id; ?>" class="btn btn-danger delete-button" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
            </td>
          </tr>
        <?php
            // increase one by one serial number
            $s++;
          }
        ?>
        </tbody>
      </table>








    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>