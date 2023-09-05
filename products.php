<?php
// start session or resume/
if (session_id() == '' || !isset($_SESSION)) {
  session_start();
}

// conn file
include './php/config.php';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>products</title>
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/products.css" />
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
            <a class="nav-link selectedlink" href="./products.php">Products</a>
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
            echo '<li class="nav-item"><a class=" nav-link" href="register.php">Register</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- marquee (scrollin area of text) like animation using keyframes. -->
  <div class="marquee mt-md-4 mt-0">
    <div class="marquee-content">
      <img src="./img/logo.png" alt="Company Logo" class="logo">
      <span class="discount-text">New arrivals! Explore our latest collection.</span>
      <span class="discount-text">Get <b>10% off</b> on $1000 spend! Limited time offer.</span>
      <img src="./img/logo.png" alt="Company Logo" class="logo">
      <span class="discount-text">New arrivals! Explore our latest collection.</span>
      <span class="discount-text">Get <b>10% off</b> on $1000 spend! Limited time offer.</span>
      <img src="./img/logo.png" alt="Company Logo" class="logo">
      <span class="discount-text">New arrivals! Explore our latest collection.</span>
      <span class="discount-text">Get <b>10% off</b> on $1000 spend! Limited time offer.</span>
      <img src="./img/logo.png" alt="Company Logo" class="logo">
      <span class="discount-text">New arrivals! Explore our latest collection.</span>
      <span class="discount-text">Get <b>10% off</b> on $1000 spend! Limited time offer.</span>
      <img src="./img/logo.png" alt="Company Logo" class="logo">
    </div>
  </div>

  <div class="container mt-4">
    <?php
    // initialize an array for product categorys.
    // multi dimensional array
    $productCategories = array();

    // gets the products from database by mysqli object.
    $result = $mysqli->query('SELECT * FROM products');

    if ($result) {
      // result gets the objects of each row and assigns to obj 
      while ($obj = $result->fetch_object()) {
        // extract category from product code
        // category variable initialized
        $category = '';

        // strpos finds index of second string in first if not found then says false
        if (strpos($obj->product_code, 'WATCH') !== false) {
          $category = 'Watches';
        } elseif (strpos($obj->product_code, 'PHONE') !== false) {
          $category = 'iPhones';
        } elseif (strpos($obj->product_code, 'TABLET') !== false) {
          $category = 'iPads';
        }

        // Add the category to the productCategories array
        // if category is not empty
        if (!empty($category)) {
          // [] multidimentional
          //obj of that specific is added to product categories.
          $productCategories[$category][] = $obj;
        }
      }
    }

    // display products grouped by category
    // for each to iterate productCategories which has products grouped by their categories
    foreach ($productCategories as $category => $products) {
      //'as' used to assign each element of array to a variable
      //=> used to associate the products of array to category which is key.

      $categoryClass = strtolower($category);
      echo '<h2 class="category category-' . $categoryClass . '">' . $category . '</h2>';
      //gutters are the padding between your columns.
      echo '<div class="row row-cols-1 row-cols-md-3 g-4">';

      //foreach is used for array iterating here $array as $value.
      foreach ($products as $product) {
        echo '<div class="col">';
        echo '<div class="card h-100">';
        echo '<img class="card-img-top product-image" src="img/products/' . $product->product_img_name . '" alt="Product Image">';
        echo '<div class="card-body d-flex flex-column">';
        echo '<h5 class="card-title">' . $product->product_name . '</h5>';
        echo '<p class="card-text"><strong>Product Code:</strong> ' . $product->product_code . '</p>';
        echo '<p class="card-text"><strong>Description:</strong> ' . $product->product_desc . '</p>';
        echo '<p class="card-text"><strong>Units Available:</strong> ' . $product->qty . '</p>';
        echo '<p class="card-text"><strong>Price (Per Unit):</strong> ' . $currency . $product->price . '</p>';

        if ($product->qty > 0) {
          //  query parameters are appended with updatecart.php to do tasks in it using get.
          // ? seperated url from parameters
          echo '<a href="./php/update-cart.php?action=add&p_id=' . $product->p_id . '" class="btn btn-dark mt-auto">Add to Cart</a>';
        } else {
          echo '<p class="text-danger text-center mt-4"><b>Out Of Stock!</b></p>';
        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
      }

      echo '</div>';
    }
    ?>
  </div>

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