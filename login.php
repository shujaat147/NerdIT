<?php
// start session or resume
if (session_id() == '' || !isset($_SESSION)) {
  session_start();
}

// check if username is set and if it is takes to index.php coz no need to login already logged in.
if (isset($_SESSION["username"])) {
  header("location:index.php");
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/login.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
  <div class="login">
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
              echo '<li class="nav-item"><a class="nav-link selectedlink" href="login.php">Log In</a></li>';
              echo '<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>


    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="./img/login.jpg" alt="Tech Image" class="img-fluid">
        </div>
        <div class="col-md-6">
          <div class="form-border">
            <!-- Action takes to verify.php which verfies values entered by user. -->
            <form method="POST" action="./php/verify.php">
              <div class="form-title">Login</div>
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" autocomplete="on" class="form-control" id="email" name="username" placeholder="Enter your email">
              </div>
              <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="show-password">
                  <!-- current password because using for login otherwise console shows error. -->
                  <input type="password" autocomplete="current-password" class="form-control" id="password" name="pwd" placeholder="Enter your password">
                  <!-- Toggler to show password -->
                  <span class="toggle-password">
                    <img src="./img/eye.svg" alt="eye">
                  </span>
                </div>
              </div>
              <div class="form-button">
                <button type="submit" class="btn btn-primary">Login</button>
                <button type="reset" class="btn btn-danger">Reset</button>
              </div>
            </form>
          </div>
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

    <script>
      // Password toggler
      // DOMContentLoaded  used so code runs only after html is loaded.
      document.addEventListener("DOMContentLoaded", function() {
        //selects password input field
        const passwordInput = document.getElementById("password");
        const togglePassword = document.querySelector(".toggle-password");
        //selected toggler using toggle-password class.

        //when button is clicked this will be done/
        togglePassword.addEventListener("click", function() {
          //if else but using ?.
          passwordInput.type = passwordInput.type === "password" ? "text" : "password";
          //setting class to active to add styling
          this.classList.toggle("active");
        });
      });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>