<?php
require_once '../helpers/cartItems.php';
require_once '../services/cart.service.php';
require_once "../helpers/connection.php";
session_start();

$cartProducts = getCartProducts();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  if (isset($removeProduct)) {
    removeProductFromCart($cartProductId, $cartQuantity);
    header("Refresh:0");
    exit();
    
    if (array_key_exists('logout', $_POST)) {
      session_destroy();
      header("Refresh:0");
    }
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

  <title>Tech Zone: Wishlist</title>
  <!--Bootstrap 5.2 style link-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="../css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />

</head>

<body>
  <!--Bootstrap 5.2 script section-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
    <!-- header section strats -->
    <header class="header_section bg-light shadow-sm">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="home.php">
            <span>
              Tech Zone
            </span>
          </a>
          <?php
          if (isset($_SESSION['name']))
            echo 'Welcome ' . $_SESSION['name'];
          ?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted bg-light" href="home.php">Home </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted bg-light" href="shop.php">Shop</a>
              </li>
                <li class="nav-item active">
                  <a class="nav-link fw-bolder text-primary bg-light active" href="contact.php">Contact Us</a>
                </li>
</ul>
              <div class="user_option-box">
                <?php
              if (isset($_SESSION['admin']))
                echo 'Admin page '
                  ?>
                  <?php 
                  if(isset($_SESSION['user'])){
                    $q = "SELECT profilePicture FROM user WHERE userId='".$_SESSION['user']."'";
                    $res = mysqli_query($con,$q);
                    if($res){
                    $user = mysqli_fetch_assoc($res);
                    $picture = $user['profilePicture'];
                    if($picture == NULL){
                      echo'  <a href="login.php">
                      <i class="fa fa-user-o" aria-hidden="true"></i>
                    </a>';
                    }
                    else{
                      echo ' <a href="login.php">
                      <img src='.$picture.' alt="user" style="height: 1.5rem; width: 1.5rem; border-radius: 5rem; margin: 0.5rem 0 0.5rem 0;"/>
                    </a>';
                    }
                  }
                }
                  else{
                    echo' <a href="login.php">
                     <i class="fa fa-user-o" aria-hidden="true"></i>
                   </a>';
                   }
                  ?>
               

                <div class="dropstart">
                  <a class="ml-3" data-bs-toggle="dropdown">
                    <i class="fa fa-cart-plus text-muted" aria-hidden="true"></i>
                  </a>
                  <ul class="dropdown-menu">
                  <?php renderCartItems($cartProducts) ?>
                </ul>
              </div>

              <a href="">
                <i class="fa fa-heart-o text-primary" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
    <!--Whishlist Start-->
    <p class="text-primary display-6 text-lg-s text-center mt-5">My Wishlist</p>
    <h5 class="lead text-muted text-center display-4"><i class="fa fa-heart-o text-primary"></i></h5> 
    <div class="container-fluid">
        <div class="col-12">
        </div>
    </div>
    <!--Whishlist End-->
  <!-- jQery -->
  <script src="../js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script src="../js/bootstrap.js"></script>
  <!-- owl slider -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- custom js -->
  <script src="../js/custom.js"></script>
</body>

</html>