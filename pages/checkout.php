<?php
include "../helpers/connection.php";
require_once '../services/cart.service.php';
require_once '../services/user.service.php';
session_start();

if (!(isset($_SESSION['user']) || isset($_SESSION['admin']))) {
    header("Location:../pages/home.php");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);
    if (isset($governorate) && isset($street) && isset($address) && isset($building) && isset($contactNumber) && isset($city)) {
        cartConfirmed($governorate, $city, $street, $building, $contactNumber, $address);
    }
    if (array_key_exists('logout', $_POST)) {
        session_destroy();
        header("Refresh:0");
    }
}

$cartProducts = getCartProducts();
$userId = $_SESSION['user'];

$user = getUserById($userId);
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
                                <a class="nav-link fw-bolder text-muted" href="shop.php"> Shop <span class="sr-only">(current)</span></a>
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

    <!--Invoices-->
    <div class="container">
        <div class="row">
            <h1 class="text-primary display-4 text-center my-3">Invoice</h1>
            <table class="table">
                <tr>
                    <th class="text-primary p-1">Product</th>
                    <th class="text-primary p-1">Product Name</th>
                    <th class="text-primary p-1">Ordered Quantity</th>
                    <th class="text-primary p-1">Unit Price</th>
                </tr>
                <?php
                $total = 0;
                if (gettype($cartProducts) == 'string') {
                } else {
                    foreach ($cartProducts as $obj) {
                        $total += $obj->price * $obj->quantityAvailable;
                        echo '
                <tr>
                <td style="vertical-align: middle;"><img src="' . $obj->thumbnail . '" class="img-fluid" alt="Item Image" style="max-width: 100px; max-height: 100px;" /></td>
                <td style="vertical-align: middle;">' . $obj->productName . '</td>
                <td style="vertical-align: middle;">x ' . $obj->quantityAvailable . '</td>
                <td style="vertical-align: middle;">' . $obj->price . ' $</td>
                </tr>';
                    }
                }
                echo "
                <tr>
                <th colspan='2' class='text-light bg-primary text-center p-1' style='vertical-align: middle;'>Total Price</td>
                <td  colspan='2'  class='bg-dark text-light text-center' style='vertical-align: middle;'>" . $total . " $</td>
                </tr>
                ";

                ?>
            </table>
        </div>
    </div>
    <section class="contact_section layout_padding p-5">
        <form method="post">

            <div class="container">
                <div class="form_container">
                    <div class="text-center text-primary">
                        <h2 class="display-5 mb-2 mt-0">
                            Delivery Informations:
                        </h2>
                        <h5 class="text-muted lead text-center">Please Provide Required Informations</h5>
                    </div>
                    <form method="post">
                        <div class="row">
                            <div class="col">
                                <label for="firstName">First Name</label>
                                <input name="firstName" id="firstName" type="text" value="<?php echo $user->firstName ?> " readonly />
                            </div>
                            <div class="col">
                                <label for="firstName">Last Name</label>
                                <input name="lastName" type="text" value="<?php echo $user->lastName ?>" readonly />
                            </div>
                        </div>
                        <div>
                            <label for="contactNumber">*Contact Number</label>
                            <input name="contactNumber" id="contactNumber" type="text" placeholder="*Contact Number" value="<?php echo $user->phoneNumber ?>" required />
                        </div>
                        <div>
                            <label for="city">*City</label>
                            <input name="city" id="city" type="text" required />
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="street">*Street</label>
                                <input name="street" id="street" type="text" size="30" required />
                            </div>
                            <div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text btn-primary" for="inputGroupSelect01">Governorate</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01" name="governorate">
                                        <option>Choose...</option>
                                        <option value="Beirout">Beirout</option>
                                        <option value="Nabatiyeh">Nabatiyeh</option>
                                        <option value="Jouniyeh">Jouniyeh</option>
                                        <option value="Baabda">Baabda</option>
                                        <option value="Tripoli">Tripoli</option>
                                        <option value="Bekaa">Bekaa</option>
                                        <option value="Akkar">Akkar</option>
                                        <option value="Baalback">Baalback</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="building">*Building</label>
                            <input name="building" id="building" type="text" size="30" />
                        </div>
                        <div>
                            <label for="address">*Full Address</label>
                            <input name="address" id="address" type="text" />
                        </div>
                </div>
                <div class="text-center">
                    <?php if (gettype($cartProducts) == 'string') echo '                 
                       <a href="account.php" class="btn btn-primary btn-lg bg-primary border border-primary font-weight-bold">
                            Go to Orders    
                       </a>
                        ';
                        else echo'
                        <button type="submit" class="btn btn-primary btn-lg bg-primary border border-primary font-weight-bold">
                         Confirm Order
                        </button>' ?>
                    
                </div>
            </div>
            </div>
        </form>
    </section>
    </div>
    <!--Invoices-->

    <!-- footer section -->
    <footer class="footer_section bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 footer-col text-center">
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