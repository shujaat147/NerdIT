<?php
// session start/resume
if (session_id() == '' || !isset($_SESSION)) {
 session_start();
}
//if there is no username means not logged in goto index.php
if (!isset($_SESSION["username"])) {
 header("location:index.php");
}
// if type is not admin goto index.php
if ($_SESSION["type"] != "admin") {
 header("location:index.php");
}

include './php/config.php';
?>

<!doctype html>
<html lang="en">

<head>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>My Orders</title>
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

 <div class="container mt-4">
  <form method="post" name="update-quantity" action="./php/admin-update.php">
   <h2 class="text-white">Welcome back Admin!</h2>
   <p class="text-white">Enter new quantity and new price in the text box provided, and if you want to remove from the current price/quantity, add a '-' sign before entering the value.</p>
   <?php
   $productCategories = array();

   // Fetch products from the database
   $result = $mysqli->query('SELECT * FROM products');
   if ($result) {
    while ($obj = $result->fetch_object()) {
     // Extract category from product code
     $category = '';

     if (strpos($obj->product_code, 'WATCH') !== false) {
      $category = 'Watches';
     } elseif (strpos($obj->product_code, 'PHONE') !== false) {
      $category = 'iPhones';
     } elseif (strpos($obj->product_code, 'TABLET') !== false) {
      $category = 'iPads';
     }

     // Add the category to the productCategories array
     if (!empty($category)) {
      $productCategories[$category][] = $obj;
     }
    }
   }

   // Display products by category
   foreach ($productCategories as $category => $products) {
    $categoryClass = strtolower(str_replace(' ', '-', $category));
    echo '<h2 class="category category-' . $categoryClass . '">' . $category . '</h2>';
    echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
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
     echo '<div class="mt-auto text-center">';
     echo '<input type="hidden" name="product_id[]" value="' . $product->p_id . '">';
     echo '<p><strong>New Quantity:</strong></p>';
     echo '<input type="number" name="quantity[]" class="form-control">';
     echo '<p><strong>New Price:</strong></p>';
     echo '<input type="number" step=".01" name="price[]" class="form-control">';
     echo '</div>';
     echo '</div>';
     echo '</div>';
     echo '</div>';
    }
    echo '</div>';
   }
   ?>
   <div class="text-center mt-4">
    <input type="submit" class="btn btn-success px-5 py-2" value="Update">
   </div>
  </form>
 </div>



 <div class="row mt-4 pt-2 pb-0" style="background-color: white; color: black;">
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