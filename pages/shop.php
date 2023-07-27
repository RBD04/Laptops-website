<?php
require_once '../services/cart.service.php';
require_once '../services/category.service.php';
require_once '../services/product.service.php';
require_once '../helpers/cartItems.php';

session_start();

$categories = getCategoriesWithProductsAvailable();
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
function isExpired(DateTime $startDate, DateInterval $validFor)
{
  $now = new DateTime();

  $expiryDate = clone $startDate;
  $expiryDate->add($validFor);

  return $now > $expiryDate;
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

  <title>Tech Zone: Shopping Page</title>

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



  <!-- header section start -->
  <header class="header_section bg-light">
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
            <li class="nav-item">
              <a class="nav-link fw-bolder text-muted bg-light" href="home.php">Home </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link fw-bolder text-primary bg-light active" href="shop.php"> Shop </a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-bolder text-muted bg-light" href="contact.php">Contact Us</a>
            </li>
          </ul>



          <div class="user_option-box">
            <?php
            if (isset($_SESSION['admin']))
              echo 'Admin page '
            ?>
            <?php
            if (isset($_SESSION['user'])) {
              $q = "SELECT profilePicture FROM user WHERE userId='" . $_SESSION['user'] . "'";
              $res = mysqli_query($con, $q);
              if ($res) {
                $user = mysqli_fetch_assoc($res);
                $picture = $user['profilePicture'];
                if ($picture == NULL) {
                  echo '  <a href="login.php">
                      <i class="fa fa-user-o" aria-hidden="true"></i>
                    </a>';
                } else {
                  echo ' <a href="login.php">
                      <img src=' . $picture . ' alt="user" style="height: 1.5rem; width: 1.5rem; border-radius: 5rem; margin: 0.5rem 0 0.5rem 0;"/>
                    </a>';
                }
              }
            } else {
              echo ' <a href="login.php">
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
            <?php
            if (isset($_SESSION) && isset($_SESSION['user'])) {
              $q = "SELECT COUNT(wpId) AS count FROM wishlistproduct WHERE wishlistId ='" . $_SESSION['user'] . "'";
              $res = mysqli_query($con, $q);
              if ($res) {
                $row = mysqli_fetch_assoc($res);
                if ($row['count'] != 0) {
                  echo '
                  <a href="wishlist.php">
                  <i class="fa fa-heart-o" aria-hidden="true"><span class="position-absolute start-101 translate-middle badge rounded-pill bg-primary">' . $row['count'] . '</span></i></a>';
                } else {
                  echo '
                  <a href ="wishlist.php"><i class="fa fa-heart-o "></i></a>';
                }
              }
            } else {
              echo '<div class="btn-group dropstart bg-none">
                  <button class="btn border border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <i class="fa fa-heart-o"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li class="p-2 text-center text-primary">No Account</li>
                  </ul>
                </div>';
            }


            ?>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!-- end header section -->
  <!--Options Offcanvas Start-->
  <div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filters</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="mx-auto text-center">
        <form class="search-form" method="POST" action="#">
          <input type="text" name="search" placeholder="Search" title="Enter search keyword" style="border-radius: 10px 0 0 10px;" class="border-0">
          <button type="submit" title="Search" class="btn-primary border-0" style="border-radius: 0 10px 10px 0px;"><i class="fa fa-search"></i></button>
      </div>
      <?php
      if (!(isset($_POST['search'])) || $_POST['search'] == "" && !isset($_POST['price'])) {
        echo '<div class="dropdown mt-3 mx-auto text-center">
      <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Categories
      </button>
      <ul class="dropdown-menu">';

        foreach ($categories as $category) {
          echo ' <li><a class="dropdown-item " href="#' . $category->categoryId . '">' . $category->categoryName . '</a></li>';
        }
      }
      ?>
      </ul>
    </div>
    <br>
    <?php
    if (!(isset($_POST['search'])) || $_POST['search'] == "") {
      echo '<p class="m-2">Filter By Price:</p>
  <div>
    <input id="rangeInput" class="form-control" type="range" min="1" max="5000" oninput="amount.value=rangeInput.value" />
    <input id="amount" class="text-primary bg-light border-0 mt-1" type="number" value="100" name="price" min="1" max="5000" oninput="rangeInput.value=amount.value" />
  </div>
</form>
  </div>';
    } ?>
  </div>
  <!--Options Offcanvas End-->

  <!-- shop section -->


  <a style="position: fixed; border-radius: 0;" class="btn btn-primary border border-0  my-3 shadow-lg" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><i class="fa fa-arrow-left mx-2"></i>More</a>
  </ul>
  </div>
  <?php
  if (!(isset($_POST['search'])) || $_POST['search'] == "") {
    foreach ($categories as $category) {
      echo "<h1 id='" . $category->categoryId . "' class='display-6  p-2 text-center text-primary border border-primary bg-light shadow'>" . $category->categoryName . "</h1>";
      echo '<section class="shop_section layout_padding">';
      echo "<div class='row col-12 px-5' >";
      $products = getProductsByCategory($category->categoryId);
      foreach ($products as $product) {
        $startDate = new DateTime($product->dateAdded);
        $validFor = new DateInterval('P3D');
        $isExpired = isExpired($startDate, $validFor);
        if ($product->quantityAvailable > 0) {
          echo '<div class="col-sm-6 col-xl-3">
      <div class="box bg-light">
        <a href="viewproduct.php?productId=' . $product->productId . '">
          <div class="img-box">
            <img src="' . $product->thumbnail . '" alt="img";">
          </div>
          <div class="detail-box">
            <h6>
              ' . $product->productName . '
            </h6>
            <h6>
              Price:
              <span>
                $' . $product->price . '
              </span>
            </h6>
          </div>';

          if (!$isExpired) {
            echo '
          <div class="new bg-primary">
            <span>
              New
            </span>
          </div>';
          }
          echo '</a>
      </div>
    </div>';
        } else {
          echo '<div class="col-sm-6 col-xl-3">
      <div class="box">
        <a href="viewproduct.php?productId=' . $product->productId . '">
          <div class="img-box">
            <img src="' . $product->thumbnail . '" alt="img"">
          </div>
          <div class="detail-box">
            <h6>
              ' . $product->productName . '
            </h6>
            <h6>
              Price:
              <span>
                $' . $product->price . '
              </span>
            </h6>
          </div>
          <div class="new bg-danger">
            <span>
              Out Of Stock
            </span>
          </div>
          </a>
      </div>
    </div>';
        }
      }
      echo "</section>";
      echo "</div>";
    }
  } else {
    $value = $_POST['search'];
    $q = "SELECT * FROM product WHERE productName LIKE '%" . $value . "%'";
    $res = mysqli_query($con, $q);
    $n = mysqli_num_rows($res);
    echo "<p class='text-center display-6 text-primary mt-2'>Results for \"" . $value . "\"</p>";
    echo '<section class="shop_section layout_padding">';
    echo "<div class='row col-12 p-5 mt-5' >";
    if ($n > 0) {
      for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($res);
        $startDate1 = new DateTime($row['dateAdded']);
        $validFor1 = new DateInterval('P3D');
        $isExpired1 = isExpired($startDate1, $validFor1);
        echo '<div class="col-sm-6 col-xl-3">
      <div class="box">
        <a href="viewproduct.php?productId=' . $row['productId'] . '">
          <div class="img-box">
            <img src="' . $row['thumbnail'] . '" alt="">
          </div>
          <div class="detail-box">
            <h6>
             ' . $row['productName'] . '
            </h6>
            <h6>
              Price:
              <span>
                $' . $row['price'] . '
              </span>
            </h6>
          </div>';
        if (!$isExpired1) {
        }
        echo '<div class="new bg-primary">
            <span>
              New
            </span>
          </div>';
        echo '</a>
      </div>
    </div>';
      }
      echo "</div>";
      echo "</section>";
    } else if ($n == 0) {
      echo  "<p class='text-info text-center'>No results found for “" . $value . "”. Check the spelling or use a different word or phrase.<a href='shop.php' class='btn btn-primary ms-5 text-light'><i class='fa fa-arrow-up mx-1'></i>Back</a></p>";
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
  <script>
    let p = document.getElementById("price");
    let v = x.document.getElementById("priceFilter");
    p.innerHTML = v;
  </script>
</body>

</html>