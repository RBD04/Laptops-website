<?php
require_once '../helpers/connection.php';
require_once '../services/cart.service.php';
require_once '../helpers/cartItems.php';
session_start();

$cartProducts = getCartProducts();
// session_destroy(); //logout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($removeProduct)) {
    removeProductFromCart($cartProductId, $cartQuantity);
    header("Refresh:0");
    exit();
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

  <title>Tech Zone: User Orders page</title>
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

<body>
  <!--Bootstrap 5.2 script section-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- header section strats -->
    <header class="header_section">
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
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link fw-bolder text-primary" href="home.php">Home </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted" href="shop.php"> Shop </a>
              </li>
              <?php if (isset($_SESSION['user'])) echo '
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted" href="account.php">Account</a>
              </li>' ?>
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted" href="contact.php">Contact Us</a>
              </li>
            </ul>
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
    <!--Orders Section-->
    <h1 class="text-center m-5 text-primary display-6">My Orders</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <h2 class="text-center ">Approved</h2>
            
                <?php
                $q = "SELECT * FROM delivery WHERE userId='".$_SESSION['user']."' AND paymentStatus='approved'";
                $res = mysqli_query($con,$q);
                $n = mysqli_num_rows($res);
                if($n > 0){
                    echo '<table class="text-muted">
                    <tr>
                        <th class="p-3">Number</th><th class="p-3">Governorate</th><th class="p-3">City</th><th class="p-3">Street</th><th class="p-3">Building</th><th class="p-3">Fees</th><th class="p-3">Total</th><th>Date</th>
                    </tr>';
                    for($i=0;$i<$n;$i++){
                        $row = mysqli_fetch_assoc($res);
                        echo "<tr><td class='p-3'>".$row['deliveryId']."</td><td class='p-3'>".$row['governorate']."</td><td class='p-3'>".$row['city']."</td><td class='p-3'>".$row['street']."</td><td class='p-3'>".$row['building']."</td><td class='p-3'>".$row['deliveryFees']."</td><td class='p-3'>".$row['total']."$</td><td>".$row['deliveryDate']."</td><tr>";
                    }
                }else{
                   echo "<p class='text-center text-danger'>No Approved Orders yet</p>";
                }
                 ?>
            </table>
        </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-12">
            <h2 class="text-center">Pending Approval</h2>
            
                <?php
              
                $q = "SELECT * FROM delivery WHERE userId='".$_SESSION['user']."' AND paymentStatus !='approved'";
                $res = mysqli_query($con,$q);
                $n = mysqli_num_rows($res);
                if($n > 0){
                    echo '<table class="text-muted mx-auto">
                    <tr>
                        <th class="p-3">Number</th><th class="p-3">Governorate</th><th class="p-3">City</th><th class="p-3">Street</th><th class="p-3">Building</th><th class="p-3">Fees</th><th class="p-3">Total</th><th>Date</th>
                    </tr>';
                    for($i=0;$i<$n;$i++){
                        $row = mysqli_fetch_assoc($res);
                        echo "<tr><td class='p-3'>".$row['deliveryId']."</td><td class='p-3'>".$row['governorate']."</td><td class='p-3'>".$row['city']."</td><td class='p-3'>".$row['street']."</td><td class='p-3'>".$row['building']."</td><td class='p-3'>".$row['deliveryFees']."</td><td class='p-3'>".$row['total']."$</td><td>".$row['deliveryDate']."</td><tr>";
                    }
                }else{
                   echo "<p class='text-center text-danger'>All Your Orders Are Approved !</p>";
                }
                 ?>
            </table>
        </div>
        </div>
    </div>
    <!--Orders Section End-->
  <br>
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