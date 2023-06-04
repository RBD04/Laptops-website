<?php
include "../helpers/connection.php";
session_start();
if (!(isset($_SESSION['user']) || isset($_SESSION['admin']))) {
    header("Location:../pages/home.php");
}
if (array_key_exists('logout', $_POST)) {
    session_destroy();
    header("Refresh:0");
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
    <div class="row">
        <h1 class="text-primary display-4 text-center my-3">Invoice</h1>
        <table class="text-center border border-dark shadow mx-auto col-10 my-3">
            <tr>
                <th class="text-center text-primary p-1">Product Name</th>
                <th class="text-center text-primary p-1">Ordered Quantity</th>
                <th class="text-center text-primary p-1">Unit Price</th>
            </tr>
            <?php
            $user = $_GET['x'];

            $q = "SELECT * FROM cart WHERE UserID='" . $user . "'";
            $res = mysqli_query($con, $q);
            $row = mysqli_fetch_assoc($res);
            $cartId = $row['cartId'];
            if ($res) {
                $q1 = "SELECT * FROM cartproduct NATURAL JOIN product WHERE cartId='" . $cartId . "'";
                $res1 = mysqli_query($con, $q1);
                $n = mysqli_num_rows($res1);
                $total = 0;
                for ($i = 0; $i < $n; $i++) {
                    $f = mysqli_fetch_assoc($res1);
                    $total += $f['quantity'] * $f['price'];
                    echo "<tr><td class='p-1'>" . $f['productName'] . "</td><td class='p-1'>" . $f['quantity'] . "</td><td class='p1'>" . $f['price'] . "$</td></th>";
                }
                echo "<tr><th colspan='2' class='text-light bg-primary text-center p-1'>Total Price</td><td class='bg-dark text-light'>$total$</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php
    $q2  = "SELECT * FROM user WHERE UserId='".$user."'";
    $res2  =mysqli_query($con,$q2);
    $get = mysqli_fetch_assoc($res2); 
    $FN = $get['firstName'];
    $LN = $get['lastName'];
    echo'
    <section class="contact_section layout_padding p-5">
        <form action="save-delivery.php" method="post">

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
                                <input name="firstName" type="text" placeholder="*First Name" value="'.$FN.'" readonly />
                            </div>
                            <div class="col">
                                <input name="lastName" type="text" placeholder="*Last Name" value="'.$LN.'" readonly />
                            </div>
                        </div>
                        <div>
                            <input name="city" type="text" placeholder="*City" required />
                        </div>
                        <div class="row">
                            <div class="col">
                                <input name="street" type="text" size="30" placeholder="*Street" required />
                            </div>
                            <div>
                            <input name="governorate" type="text" placeholder="Governorate" size="30"/>
                        </div>
                        </div>
                        <div>
                            <input name="building" type="text" placeholder="Building Name" size="30"/>
                        </div>
                        <div>
                        <input name="total" type="hidde" value="'.$total.'"/>
                    </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg bg-primary border border-primary font-weight-bold">
                                Finish Order
                            </button>
                        </div>
                </div>
            </div>
        </form>
    </section>
    </div>
    '?>
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