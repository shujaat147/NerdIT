<?php
// Common practice at the beginning of PHP scripts that need to use 
//session functionality to store and retrieve data across multiple page requests for 
//a particular user.
// if session not start starting session or resume
if (session_id() == '' || !isset($_SESSION)) {
  session_start();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NerdIT Shop</title>
  <link rel="stylesheet" href="./css/index.css" />
  <!-- bootstrap file  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
  <div class="Main">
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
            // if there is a username set for session then it will show this
            if (isset($_SESSION['username'])) {
              echo '<li class="nav-item"><a class="nav-link" href="account.php">My Account</a></li>';
              echo '<li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>';
            } 
            // else if will show this
            else {
              echo '<li class="nav-item"><a class="nav-link" href="login.php">Log In</a></li>';
              echo '<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>

    <img class="img-fluid" src="./img/nerdit.png" alt="banner">

    <div class="row" style="margin-top:10px;">
      <div class="sm-12">
        <footer style="margin-top:10px;">
          <p style="text-align:center; font-size:0.8em;">&copy; NerdIT Tech Shop. All Rights Reserved.</p>
        </footer>
      </div>
    </div>

  </div>
  <!-- for bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>