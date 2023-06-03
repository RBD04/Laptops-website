<?php
require_once '../services/product.service.php';
require_once '../services/cart.service.php';
require_once '../helpers/cartItems.php';

session_start();
$cartProducts = getCartProducts();
if (isset($_GET['productId']))
    $product = getProductById($_GET['productId']);
else header('Location: shop.php');

$Message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if (isset($quantity) && isset($add_to_cart)) {
        $Message = addToCart($product->ProductId, $quantity);
        if ($Message) {
            $Message = $product->productName . ' added successfully to cart<br/><a href="cart.php" class="fw-bolder fs-4 text-decoration-underline"><i class="fa fa-cart-plus" aria-hidden="true"> Go To Cart</i></a>';
        } else {
            $Message = 'Sorry, quantity requested is not available now!';
        }
    }

    if (isset($quantity) && isset($checkout)) {
        header('Location: checkout.php?quantity=' . $quantity . '?productId=' . $product->ProductId . '');
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

    <style>
        /* Hide the number input spinner controls */
        #quantityGroup input[type="number"]::-webkit-inner-spin-button,
        #quantityGroup input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

</head>

<body class="sub_page">

    <div class="hero_area">

        <!-- header section strats -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="home.php">
                        <span>
                            Laptops website
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
            <button class="btn btn-primary" type="submit" name="logout" value="logout">Logout</button>
            </form>
            '
                        ?>
                        <div class="user_option-box">
                            <a href="login.php">
                                <?php
                                if (isset($_SESSION['admin']))
                                    echo 'admin page '
                                ?>
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

    <!-- contact section -->

    <section class="p-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="img-box">
                        <img src="<?php echo $product->thumbnail ?>" class="img-thumbnail" alt="">
                    </div>
                    <div>
                        <h3 class="mt-5 mb-3">Product Reviews</h3>
                        <p><i class="fa fa-user" aria-hidden="true"></i> So Amazing</p>
                        <p><i class="fa fa-user" aria-hidden="true"></i> Nice product!</p>
                        <p><i class="fa fa-user" aria-hidden="true"></i> I bought it and I loved it so much I bought it and I loved it so much I bought it and I loved it so much I bought it and I loved it so much</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_container">
                        <div>
                            <h2 class="text-primary mb-5 text-center display-5 fw-bolder">
                                <?php echo $product->productName; ?>
                            </h2>
                        </div>
                        <form method="post">
                            <div>
                                <h3 class="mb-5 text-muted fw-light">
                                    <?php echo $product->description; ?>
                                </h3>
                            </div>
                            <div>
                                <h4 class="mb-5 text-muted fw-light">
                                    Price: <?php echo $product->price . '$'; ?>
                                </h4>
                            </div>
                            <label for="quantityGroup" class="text-muted fw-light">Quantity</label><br />
                            <div id="quantityGroup" class="btn-group mb-5" role="group" aria-label="Basic example">
                                <button type="button" id="reduce" onclick="quantityChange('reduce')" class="btn btn-primary">-</button>
                                <input type="number" name="quantity" id="quantity" style="width: 50px;" class="form-control text-center w-50" min="1" value="1" readonly />
                                <button type="button" id="add" onclick="quantityChange('add')" class="btn btn-primary">+</button>
                            </div>
                            <?php
                            if (isset($_SESSION['user'])) echo '<p class="text-primary fs-5">' . $Message . '</p><div class="text-white mb-5">
                            <button type="submit" name="add_to_cart" class="btn btn-primary w-100  font-weight-bold ">
                                Add to Cart
                            </button>
                        </div>
                        <div class="text-white">
                            <button type="submit" name="checkout" class="btn btn-primary w-100 font-weight-bold">
                                Buy it now
                            </button>

                        </div>';
                            else echo '<div class="text-white mb-5">
                            <button type="button" class="btn btn-primary w-100 font-weight-bold" data-toggle="modal" data-target="#exampleModal">
                                Add to Cart
                            </button>
                        </div>
                        <div class="text-white">
                        <button type="button" class="btn btn-primary w-100 font-weight-bold" data-toggle="modal" data-target="#exampleModal">
                                Buy it now
                            </button>

                        </div>'
                            ?>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-primary font-weight-bolder" id="exampleModalLabel">Please Login First</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p href="login.php" class="text-muted font-weight-bold" data-toggle="modal" data-target="#exampleModal">
                                                Logging in is an essential step to ensure a seamless and secure online shopping experience on our website.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Close</button>
                                            <a href="login.php" class="btn btn-primary font-weight-bold">Login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div>
                            <h3 class="mt-5 mb-3">Add a Review</h3>
                            <form method="post">
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="rating">Rating</label>
                                    <select name="rating" id="rating" class="form-control" required>
                                        <option value="">Select Rating</option>
                                        <option value="1">1 Star</option>
                                        <option value="2">2 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="5">5 Stars</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary font-weight-bold">Submit Review</button>
                                </div>
                            </form>
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
    </script>
</body>

</html>