<?php
require_once '../services/cart.service.php';
require_once '../services/category.service.php';
require_once '../services/product.service.php';
require_once '../helpers/cartItems.php';

session_start();

$categories = getCategories();
$cartProducts = getCartProducts();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($removeProduct)) {
    removeProductFromCart($cartProductId, $cartQuantity);
    header("Refresh:0");
    exit();
  }
  if (array_key_exists('logout', $_POST)) {
    session_destroy();
    header("Refresh:0");
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>Laptops website</title>

  <!--Bootstrap 5.2 style link-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="../css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />

</head>

<body class="sub_page">
  <!--Bootstrap 5.2 script section-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <div class="hero_area">

    <!-- header section strats -->
    <header class="header_section mb-4">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="home.php">
            <span>
              Laptops website
            </span>
          </a>
          <?php
          if (isset($_SESSION['name']))
            if (isset($_SESSION['admin']))
              echo 'Welcome admin ' . $_SESSION['name'];
            else echo 'Welcome ' . $_SESSION['name'];
          ?>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted" href="home.php">Home </a>
              </li>
              <li class="nav-item active">
                <a class="nav-link fw-bolder text-primary" href="shop.php"> Shop <span class="sr-only">(current)</span></a>
              </li>
              <?php if (isset($_SESSION['user'])) echo '
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted" href="account.php">Account</a>
              </li>' ?>
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted" href="contact.php">Contact Us</a>
              </li>
            </ul>
            <?php
            if (isset($_SESSION['name']))
              echo '
            <form method="post">
            <button class="btn btn-primary mx-2" type="submit" name="logout" value="logout">Logout</button>
            </form>
            '
            ?>
            <div class="user_option-box">
            <?php
                if (isset($_SESSION['admin']))
                  echo 'Admin page '
                ?>
              <a href="login.php">
                <i class="fa fa-user" aria-hidden="true"></i>
              </a>
              <div class="dropstart">
                <button type="button" class="bg-transparent border-0 ml-3" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-cart-plus" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu">
                  <?php renderCartItems($cartProducts) ?>
                </ul>
              </div>
              <a href="">
                <i class="fa fa-search" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- shop section -->
              <!--Search-->
              <div class="mx-auto text-center">
  <form class="search-form align-items-center" method="POST" action="#">
        <input type="text" name="search" placeholder="Search (Empty to refresh)" title="Enter search keyword">
        <button type="submit" title="Search" class="btn-primary"><i class="fa fa-search"></i></button>
      </form>
      </div>
        <!--Search End-->
                   <!--Categories Dropdown With Links-->
        <?php

      if(!(isset($_POST['search']))||$_POST['search'] == ""){
       
  echo '<div class="dropdown ms-3" style="position:fixed;">
  <a class="btn btn-primary p-2 m-0 rounded-pill dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
   Categories
    </a>
    <ul class="dropdown-menu">';
      
      foreach ($categories as $category) {
        echo ' <li><a class="dropdown-item " href="#' . $category->categoryId . '">' . $category->categoryName . '</a></li>';
      }
      }
      ?>
    </ul>
  </div>
  <!--End Categories Dropdown-->
  <?php
  if(!(isset($_POST['search']))||$_POST['search'] == ""){
  foreach ($categories as $category) {
    echo "<h1 id='" . $category->categoryId . "' class='display-4 m-5 text-center text-primary fw-bolder'>" . $category->categoryName . "</h1>";
    echo "<div class='container-lg justify-content-center text-center'>";
    echo "<div class='row col-12 p-5 mt-5' >";
    $products = getProductsByCategory($category->categoryId);
    foreach ($products as $product) {
      echo '
      <div class="col-lg-3 col-12 text-center" style="width: 20rem;">
        <div class=" box card m-2 text-center">
          <img src="' . $product->thumbnail . '" class="card-img-top d-sm-fluid" alt="..." style="height: 15rem; width: 100%">
          <div class="card-body">
            <h5 class="card-title text-primary">' . $product->productName . '</h5>
            <p class="card-text text-secondary fw-bolder">' . $product->price . '$</p>
              <a href="viewproduct.php?productId=' . $product->productId . '" class="btn btn-primary w-100 font-weight-bold">View</a>
          </div>
        </div>
      </div>';
    }
    echo "</div>";
    echo "</div>";
  }
  }else{
    $value = $_POST['search'];
    $q = "SELECT * FROM product WHERE productName LIKE '%".$value."%'";
    $res = mysqli_query($con,$q);
    $n = mysqli_num_rows($res);
    echo "<div class='container-lg justify-content-center text-center'>";
    echo "<div class='row col-12 p-5 mt-5' >";
    if($n > 0){
      for($i =0;$i<$n;$i++){
        $row = mysqli_fetch_assoc($res);
       echo' <div class="col-lg-3 col-12 text-center" style="width: 20rem;">
        <div class=" box card m-2 text-center">
          <img src="' . $row['thumbnail'] . '" class="card-img-top d-sm-fluid" alt="..." style="height: 15rem; width: 100%">
          <div class="card-body">
            <h5 class="card-title text-primary">' . $row['productName']. '</h5>
            <p class="card-text text-secondary fw-bolder">' . $row['price'] . '$</p>
              <a href="viewproduct.php?productId=' . $row['productId'] . '" class="btn btn-primary w-100 font-weight-bold">View</a>
          </div>
        </div>
      </div>';
      }
      echo "</div>";
      echo "</div>";
    }
    else if($n == 0){
      echo  "<p class='text-info text-center'>No results found for “".$value."”. Check the spelling or use a different word or phrase.</p>";
    }
   
  }
  
  ?>
  <!-- end shop section -->
  <!-- footer section -->
  <footer class="footer_section bg-primary">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-6 footer-col text-center">
          <div class="footer_detail">
            <h4>
              About
            </h4>
            <p>
              Necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with
            </p>
            <div class="footer_social justify-content-center">
              <a href="">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-twitter" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-instagram" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-6 footer-col text-center">
          <div class="footer_contact">
            <h4>
              Reach at..
            </h4>
            <div class="contact_link_box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  Location
                </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Call +01 1234567890
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  demo@gmail.com
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-info">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">Laptops website</a>
        </p>
      </div>
    </div>
  </footer>
  <!-- footer section -->

  <!-- Modal -->
  <div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ok, <?php echo $product ?> cart, what's next?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Continue Shopping</button>\
        </div>
      </div>
    </div>
  </div>

  <!-- jQery -->
  <script src="../js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script src="../js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- custom js -->
  <script src="../js/custom.js"></script>
</body>

</html>