<?php
// if session not start starting session or resume.
if (session_id() == '' || !isset($_SESSION)) {
  session_start();
}
//if username is already has a value then
if (isset($_SESSION["username"])) {
  // Takes the user to index page again because already logined with a account.
  header("location:index.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/register.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>


<body class="register">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-0" style="overflow:hidden">
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
            echo '<li class="nav-item"><a class="nav-link" href="account.php">My Account</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>';
          } else {
            echo '<li class="nav-item"><a class="nav-link" href="login.php">Log In</a></li>';
            echo '<li class="nav-item"><a class="selectedlink nav-link" href="register.php">Register</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>



  <div class="container">
    <div class="row">
      <div class="col-md-6 order-md-1">
        <div class="form-border" style="height: 100%;">
          <form method="POST" action="./php/insert.php">
            <!-- action redirects the form data to insert.php which enters data in database. -->
            <h2 class="form-title">Register</h2>
            <div class="form-group">
              <label for="firstName" class="form-label">First Name</label>
              <!-- autocomplete to add values automatically by brower that are used prev. -->
              <input type="text" required autocomplete="on" class="form-control" name="fname" placeholder="Enter your first name">
            </div>
            <div class="form-group">
              <label for="lastName" class="form-label">Last Name</label>
              <input type="text" required autocomplete="on" class="form-control" name="lname" placeholder="Enter your last name">
            </div>
            <div class="form-group">
              <label for="address" class="form-label">Address</label>
              <input type="text" required autocomplete="on" class="form-control" name="address" placeholder="Enter your address">
            </div>
            <div class="form-group">
              <label for="city" class="form-label">City</label>
              <input type="text" required autocomplete="on" class="form-control" name="city" placeholder="Enter your city">
            </div>
            <div class="form-group">
              <label for="pinCode" class="form-label">Pin Code</label>
              <input type="text" required autocomplete="on" class="form-control" name="pin" placeholder="Enter your pin code">
            </div>
            <div class="form-group">
              <label for="email" class="form-label">Email</label>
              <input type="email" required autocomplete="on" class="form-control" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <!-- telling browser to not show prev values and if removes shows a error on console. -->
              <input type="password" autocomplete="new-password" required class="form-control" name="pwd" placeholder="Enter your password">
            </div>

            <div class="form-button">
              <button type="submit" class="btn btn-primary">Register</button>
              <button type="reset" class="btn btn-danger">Reset</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6 order-md-2">
        <br>
        <img src="./img/register.jpg" alt="Tech Image" class="img-fluid">
      </div>
    </div>
  </div>

  <div class="row" style="margin-top:10px; background-color: white;color:black">
    <div class="small-12">
      <footer style="margin-top:10px;">
        <p style="text-align:center; font-size:0.8em;">&copy; NerdIT Tech Shop. All Rights Reserved.</p>
      </footer>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>