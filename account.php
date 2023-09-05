<?php

// session start/resume
if (session_id() == '' || !isset($_SESSION)) {
  session_start();
}
// if no username found means not logged in and redirect to index.php
if (!isset($_SESSION["username"])) {
  echo '<h1>Invalid Login! Redirecting...</h1>';
  // waits 3 sec then refreshes
  header("Refresh: 3; url=index.php");
}

// if type is admin goto admin.php
if ($_SESSION["type"] === "admin") {
  header("location:admin.php");
}

//conn file
include './php/config.php';

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Account</title>
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/account.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-0">
    <div class="container-fluid">
      <a class="navbar-brand" href="./index.php"><img class="logo" src="./img/logo.png" alt="NerdIT">NerdIT</a>
      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav text-center">
          <li class="nav-item">
            <a class="nav-link" href="./products.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./cart.php">View Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./orders.php">My Orders</a>
          </li>
          <?php
          if (isset($_SESSION['username'])) {
            echo '<li class="nav-item"><a class="nav-link selectedlink" href="account.php">My Account</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>';
          } else {
            echo '<li class="nav-item"><a class="nav-link" href="login.php">Log In</a></li>';
            echo '<li class="nav-item"><a class=" nav-link" href="register.php">Register</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="text-center">
      <h3><?php echo 'Hi ' . $_SESSION['fname']; ?>,</h3>
      <h4>Account Details</h4>
      <p>Here are your current details stored in the database. If you want to make any changes, simply enter the updated information in the provided text boxes and click the "Update" button.</p>
    </div>
  </div>

  <form method="POST" action="./php/update.php" class="mt-5">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">

          <div class="form-group row mb-2">
            <label for="fname" class="col-sm-3 col-form-label">First Name</label>
            <div class="col-sm-8">
              <?php
              $result = $mysqli->query('SELECT * FROM users WHERE u_id=' . $_SESSION['u_id']);

              if ($result === FALSE) {
                die(mysqli_error($mysqli));
              }

              if ($result) {
                $obj = $result->fetch_object();
                echo '<input type="text" id="fname" class="form-control" placeholder="' . $obj->fname . '" name="fname">';
              }
              ?>
            </div>
          </div>

          <div class="form-group row mb-2">
            <label for="lname" class="col-sm-3 col-form-label">Last Name</label>
            <div class="col-sm-8">
              <input type="text" id="lname" class="form-control" placeholder="<?php echo $obj->lname; ?>" name="lname">
            </div>
          </div>

          <div class="form-group row mb-2">
            <label for="address" class="col-sm-3 col-form-label">Address</label>
            <div class="col-sm-8">
              <input type="text" id="address" class="form-control" placeholder="<?php echo $obj->address; ?>" name="address">
            </div>
          </div>

          <div class="form-group row mb-2">
            <label for="city" class="col-sm-3 col-form-label">City</label>
            <div class="col-sm-8">
              <input type="text" id="city" class="form-control" placeholder="<?php echo $obj->city; ?>" name="city">
            </div>
          </div>

          <div class="form-group row mb-2">
            <label for="pin" class="col-sm-3 col-form-label">Pin Code</label>
            <div class="col-sm-8">
              <input type="text" id="pin" class="form-control" placeholder="<?php echo $obj->pin; ?>" name="pin">
            </div>
          </div>

          <div class="form-group row mb-2">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="email" id="email" class="form-control" placeholder="<?php echo $obj->email; ?>" name="email">
            </div>
          </div>

          <div class="form-group row mb-2">
            <label for="pwd" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-8">
              <input type="password" id="pwd" class="form-control" name="pwd">
            </div>
          </div>

          <div class="form-group justify-content-center text-center mt-2">
            <input type="submit" value="Update" class="btn btn-success px-5 fw-bold py-2">
            <input type="reset" value="Reset" class="btn btn-danger px-5 fw-bold py-2">
          </div>
        </div>
      </div>
  </form>






  <div class="row mt-4" style="background-color: white; color: black;">
    <div class="col-12">
      <footer>
        <p style="text-align:center; font-size:0.8em;">&copy; NerdIT Tech Shop. All Rights Reserved.</p>
      </footer>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>