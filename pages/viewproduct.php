<?php
require_once '../helpers/connection.php';
require_once '../services/product.service.php';
require_once '../services/cart.service.php';
require_once '../helpers/cartItems.php';
require_once '../services/review.service.php';

session_start();
$cartProducts = getCartProducts();
if (isset($_GET['productId']))
    $product = getProductById($_GET['productId']);
else
    header('Location: shop.php');

$Message = '';
if(isset($_SESSION['user'])&&isset($_POST['wishlist'])){
    $msg = "";
    $found =0;
    $q1 = "SELECT productId FROM wishlistproduct WHERE wishlistId ='".$_SESSION['user']."'";
    $r1 = mysqli_query($con,$q1);
    $n = mysqli_num_rows($r1);
    for($i=0;$i<$n;$i++){
        $row  = mysqli_fetch_assoc($r1);
        if($row['productId'] == $_GET['productId']){
            $found = 1;
            break;
        }
    }
    if($found){ $msg = "Product already Exists In your Wishlist !";}
    else{
    $add = "INSERT INTO `wishlistproduct`(`wishlistId`, `productId`) VALUES ('".$_SESSION['user']."','".$_GET['productId']."')";
    $added = mysqli_query($con,$add);
    $msg = "Product Added To Your Wishlist !";
    }
    }
        


$reviews = getReviews($product->productId);
if (isset($_SESSION['user']))
    $user = getUserById($_SESSION['user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if (isset($quantity) && isset($add_to_cart)) {
        $Message = addToCart($product->productId, $quantity);
        if ($Message) {
            $Message = $product->productName . ' added successfully to cart<br/><a href="cart.php" class="fw-bolder fs-4 text-decoration-underline"><i class="fa fa-cart-plus" aria-hidden="true"> Go To Cart</i></a>';
        } else {
            $Message = 'Sorry, quantity requested is not available now!';
        }
    }

    if (isset($_POST['review'])&&isset($_SESSION['user'])) {
        if(isset($_POST['rating'])){
        $rating = $_POST['rating'];
      }
      else{$rating = 0;}
        addReview($_SESSION['user'], $product->productId, $comment, $rating);
    }

    if (isset($quantity) && isset($checkout)) {
        header('Location: checkout.php?quantity=' . $quantity . '?productId=' . $product->productId . '');
    }

    if (isset($logout)) {
        session_destroy();
        header("Refresh:0");
    }
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

    <title>Tech Zone: View Product Page</title>

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

    <style>
        /* Hide the number input spinner controls */
        #quantityGroup input[type="number"]::-webkit-inner-spin-button,
        #quantityGroup input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200&display=swap');

        html,
        body {
            height: 100%
        }


        .card {
            margin-top: 70px;
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            padding: 20px;
            width: 100%;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border-radius: 6px;
        }

        .comment-box {

            padding: 5px;
        }



        .comment-area textarea {
            resize: none;
            border: 1px solid #ad9f9f;
        }


        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #ffffff;
            outline: 0;
            box-shadow: 0 0 0 1px #007bff !important;
        }

        .send {
            color: #fff;
        }

        .send:hover {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }


        .rating {
            display: flex;
            margin-top: -10px;
            flex-direction: row-reverse;
            margin-left: -4px;
            float: left;
        }

        .rating>input {
            display: none
        }

        .rating>label {
            position: relative;
            width: 19px;
            font-size: 25px;
            color: #007bff;
            cursor: pointer;
        }

        .rating>label::before {
            content: "\2605";
            position: absolute;
            opacity: 0
        }

        .rating>label:hover:before,
        .rating>label:hover~label:before {
            opacity: 1
        }

        .rating>input:checked~label:before {
            opacity: 1
        }

        .rating:hover>input:checked~label:before {
            opacity: 0.4
        }

        .card .custom-rating>label:hover:before,
        .card .custom-rating>label:hover~label:before {
            opacity: 1;
        }

        .card .custom-rating>input:checked~label:before {
            opacity: 1;
        }
    </style>

</head>

<body class="sub_page">

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
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <li class="nav-item">
                  <a class="nav-link fw-bolder text-muted" href="contact.php">Contact Us</a>
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
              <?php
            if(isset($_SESSION)&&isset($_SESSION['user'])){
              $q = "SELECT COUNT(wpId) AS count FROM wishlistproduct WHERE wishlistId ='".$_SESSION['user']."'";
              $res = mysqli_query($con,$q);
              if($res){
                $row = mysqli_fetch_assoc($res);
                if($row['count'] != 0){
                  echo '
                  <a href="wishlist.php">
                  <i class="fa fa-heart-o" aria-hidden="true"><span class="position-absolute start-101 translate-middle badge rounded-pill bg-primary">'.$row['count'].'</span></i></a>';
                }
                else{
                echo '
                <a href ="wishlist.php"><i class="fa fa-heart-o "></i></a>';
                }
              }
            }
                else{
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
    </div>


    <section class="p-5 m-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="container-fluid">
                        <img src="<?php echo $product->thumbnail ?>" class="img-thumbnail"
                            style="height: auto; width: auto; max-height: 50em;" alt="">
                    </div>
                        <h3 class="mt-5 mb-3 text-muted">Product Reviews</h3>
                        <iframe src="reviewsIframe.php?x=<?php echo $product->productId?>"style="border: 2em;" height="300" width="500"></iframe>
                </div>
                <div class="col-md-6">
                    <div class="form_container">
                        <div>
                        <?php 
                        if($product->quantityAvailable>0){
                        echo'    <h2 class="text-primary mb-5 text-center display-5">'.$product->productName.'</h2>';}
                            else{
                                echo'<h2 class="text-primary mb-1 text-center display-5 fw-bolder">'.$product->productName.'</h2>';
                                echo'<p class="text-center fw-bolder lead text-danger">Out Of Stock</p>';
                            }
                            ?>
                        </div>
                        <form method="post">
                            <div>
                                <h3 class="mb-5 text-muted fw-light">
                                    <?php echo $product->description; ?>
                                </h3>
                            </div>
                            <div>
                                <h4 class="mb-5 text-muted fw-light">
                                    Price:
                                    <?php echo $product->price . '$'; ?>
                                </h4>
                            </div>
                            <label for="quantityGroup" class="text-muted fw-light">Quantity</label><br />
                            <div id="quantityGroup" class="btn-group mb-5" role="group" aria-label="Basic example">
                                <button type="button" id="reduce" onclick="quantityChange('reduce')"
                                    class="btn btn-primary">-</button>
                                <input type="number" name="quantity" id="quantity" style="width: 50px;"
                                    class="form-control text-center w-50" min="1" value="1" readonly />
                                <button type="button" id="add" onclick="quantityChange('add')"
                                    class="btn btn-primary">+</button>
                            </div>
                            <?php
                            //
                            //
                            //
                            //
                            if (isset($_SESSION['user'])) 
                            
                                echo '<p class="text-primary fs-5">' . $Message . '</p>
                               
                        <table class="container-fluid">
                                <tr>
                                <td width="50%" class="p-2">
                            <button type="submit" name="add_to_cart" class="btn btn-primary w-100  font-weight-bold ">
                                Add to Cart
                            </button>
                            </td>
                            <td width="50%" class="p-2">
                            <button type="submit" name="wishlist" class="btn btn-primary  w-100  font-weight-bold">
                            Add to Wishlist
                            </button>
                            </td>
                            <tr>
                        <td colspan="2" class="p-2">
                        <button type="submit" name="checkout" class="btn btn-primary  w-100 font-weight-bold">
                        Checkout Now
                    </button>
                    </td></tr></table>
                       ';
                            else
                            echo '<p class="text-primary fs-5">' . $Message . '</p>
                               
                            <table class="container-fluid">
                                    <tr>
                                    <td width="50%" class="p-2">
                                    <button type="button" class="btn btn-primary w-100 font-weight-bold" data-toggle="modal" data-target="#exampleModal">
                                    Add to Cart
                                    </button>
                                </td>
                                <td width="50%" class="p-2">
                                <button type="button" class="btn btn-primary w-100 font-weight-bold" data-toggle="modal" data-target="#exampleModal">
                                Add to Wishlist
                                </button>
                                </td>
                                <tr>
                            <td colspan="2" class="p-2">
                            <button type="button" class="btn btn-primary w-100 font-weight-bold" data-toggle="modal" data-target="#exampleModal">
                            Checkout Now
                            </button>
                        </td></tr>';
                        if(isset($_SESSION['user'])&&isset($_POST['wishlist'])){
                           
                                echo "<tr><td><p class='text-center'>$msg</p></td></tr>";
                        }
                        echo '</table>';
                           

                                    ?>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary font-weight-bolder"
                                                    id="exampleModalLabel">Please Login First</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p href="login.php" class="text-muted font-weight-bold" data-toggle="modal"
                                                    data-target="#exampleModal">
                                                    Logging in is an essential step to ensure a seamless and secure online
                                                    shopping experience on our website.
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary font-weight-bold"
                                                    data-dismiss="modal">Close</button>
                                                <a href="login.php" class="btn btn-primary font-weight-bold">Login</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <?php 
                                    if(isset($_SESSION)&&isset($_SESSION['user'])){
                                       echo' 
                            <div class="card">

                                <div class="row">                                      
                                    <div class="col-10">
                                        <form method="post">
                                            <div class="comment-box ml-2">

                                                <h4 class="text-muted">Add a Review</h4>

                                                <div class="rating">
                                                    <input type="radio" name="rating" value="5" id="5"><label
                                                        for="5">☆</label>
                                                    <input type="radio" name="rating" value="4" id="4"><label
                                                        for="4">☆</label>
                                                    <input type="radio" name="rating" value="3" id="3"><label
                                                        for="3">☆</label>
                                                    <input type="radio" name="rating" value="2" id="2"><label
                                                        for="2">☆</label>
                                                    <input type="radio" name="rating" value="1" id="1"><label
                                                        for="1">☆</label>
                                                </div>

                                                <div class="comment-area">

                                                    <textarea class="form-control" name="comment"
                                                        placeholder="what is your review?" rows="4"></textarea>

                                                </div>

                                                <div class="comment-btns mt-2">

                                                    <div class="row">

                                                        <div class="col-6">

                                                            <div class="pull-left">

                                                                <input type="reset" value="Clear"
                                                                    class="btn btn-outline-primary btn-sm" />

                                                            </div>

                                                        </div>

                                                        <div class="col-6">

                                                            <div class="pull-right">

                                                                <input type="submit" name="review" value="Add Review"
                                                                    class="btn btn-primary btn-sm" />

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                            </div>
                                        </form>
                                    </div>';}
                                    else{
                                            echo' 
                                 <div class="card">
     
                                     <div class="row">
     
                                        
                                   
                                           
                                         <div class="col-10">
                                             <form method="post">
                                                 <div class="comment-box ml-2">
     
                                                     <h4 class="text-muted">Add a Review</h4>
     
                                                     
     
                                                     <div class="comment-area">
     
                                                         <textarea disabled class="form-control" name="comment"
                                                             placeholder="what is your review?" rows="4"></textarea>
     
                                                     </div>
     
                                                     <div class="comment-btns mt-2">
     
                                                         <div class="row">
     
                                                             <div class="col-6">
     
                                                                 <div class="pull-left">
     
                                                                    <p class="text-danger ">Requires Membership</p>
     
                                                                 </div>
     
                                                             </div>
     
                                                             <div class="col-6">
     
                                                                 <div class="pull-right">
     
                                                                     <a href="login.php" class="btn btn-primary btn-sm">Login Now </a>
                                                                 </div>
     
                                                             </div>
     
                                                         </div>
     
                                                     </div>
     
     
                                                 </div>
                                             </form>
                                         </div>';
                                    }
                                    ?>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end contact section -->
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
                                Necessary, making this the first true generator on the Internet. It uses a dictionary of
                                over 200 Latin words, combined with
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
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
            </script>
        <!-- bootstrap js -->
        <script src="../js/bootstrap.js"></script>
        <!-- owl slider -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
        </script>
        <!-- custom js -->
        <script src="../js/custom.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>

        <script>
            const quantityChange = (action) => {
                let quantityInput = document.getElementById('quantity');
                let currentValue = parseInt(quantityInput.value);

                switch (action) {
                    case 'add':
                        quantityInput.value = currentValue + 1;
                        break;
                    case 'reduce':
                        if (currentValue > 1) {
                            quantityInput.value = currentValue - 1;
                        } else console.log('You can\'t add 0 items');
                        break;
                }
            }


            function disableInputsByClass(className) {
                var inputs = document.querySelectorAll('.' + className);
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].disabled = true;
                }
            }

            // Call the function to disable the inputs with the "disabled" class
            disableInputsByClass('disabled');
        </script>
    </body>

    </html>