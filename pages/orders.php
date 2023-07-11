<?php
include "../helpers/connection.php";
require_once '../services/delivery.service.php';
require_once '../services/user.service.php';
session_start();
if (!isset($_SESSION) || !isset($_SESSION['admin']))
    header('Location: adminlogin.php');

if (array_key_exists('logout', $_POST)) {
    session_destroy();
    header('Location:../pages/shop.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve']) && isset($_POST['date' . $_POST['approve']])) {
        $deliveryId = $_POST['approve'];
        $date = $_POST['date' . $_POST['approve']];
        setDeliveryApproved($deliveryId, $date);
    }

    if(isset($_POST['received'])){
        $deliveryId=$_POST['received'];
        setDeliveryReceived($deliveryId);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Add Products</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--style CSS Files -->
    <link href="../css/admin-style/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/admin-style/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/admin-style/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../css/admin-style/quill/quill.snow.css" rel="stylesheet">
    <link href="../css/admin-style/quill/quill.bubble.css" rel="stylesheet">
    <link href="../css/admin-style/remixicon/remixicon.css" rel="stylesheet">
    <link href="../css/admin-style/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../css/admin-style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="../pages/admin-home.php" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">TechZone</span>
            </a>
            <?php
            if (isset($_SESSION['name']))
                if (isset($_SESSION['admin']))
                    echo 'Welcome ' . $_SESSION['name'] . ' ';
            ?>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->
        </nav><!-- End Icons Navigation -->
        <?php
        if (isset($_SESSION['admin']))
            echo 'Admin page '
        ?>
        <?php
        if (isset($_SESSION['name']))
            echo '
            <form method="post">
            <button class="btn btn-primary mx-3" type="submit" name="logout" value="logout">Logout</button>
            </form>
            '
        ?>

    </header><!-- End Header -->


    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="admin-home">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
        <a class="nav-link collapsed" href="../pages/add-product.php">
          <i class="bi bi-plus-square"></i>
          <span>Add Products</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="../pages/category-details.php">
          <i class="bi bi-ui-radios-grid"></i>
          <span>Manage Categories</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="../pages/user-details.php">
          <i class="bi bi-person-fill-gear"></i>
          <span>Manage Users</span>
        </a>
      </li>
      <li class="nav-item">
      <a class="nav-link collapsed" href="../pages/news.php">
            <i class="bi bi-newspaper"></i>
            <span>Manage News</span>
          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="../pages/stocks.php">
          <i class="bi bi-ui-checks-grid"></i>
          <span>View Stock</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed text-primary" href="../pages/orders.php">
          <i class="bi bi-card-checklist"></i>
          <span>View Orders</span>
        </a>
      </li>
            <!-- End Page Nav -->

        </ul>

    </aside>
    <!-- End Sidebar-->
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="pagetitle">
                            <h1>Orders and Deliveries</h1>
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active">Orders Section</li>
                                </ol>
                            </nav>
                        </div>
                        <!-- End Page Title -->
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <!--FIRST PART -->
                                <h2 class="accordion-header">
                                    <button class="accordion-button text-primary fw-bolder fs-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                        Reserved
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse  show">
                                    <div class="accordion-body">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">First Name</th>
                                                    <th scope="col">Last Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Phone Number</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $users = getUsers();
                                                $counter = 0;
                                                foreach ($users as $obj) {
                                                    if ($obj instanceof User) {
                                                        $products = getCartProductsFromUserId($obj->userId);
                                                        if (!empty($products)) {
                                                            $continue = false;
                                                            foreach ($products as $product) {
                                                                if ($product instanceof Product) {
                                                                    if ($continue) {
                                                                        echo '
                                                                        <tr>
                                                                <th></th>
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td> 

                                                                <td> ' . $product->productName . ' </td> 
                                                                <td> ' . $product->quantityAvailable . ' </td> 
                                                                <td> ' . $product->price . ' $</td> 
                                                                <td> ' . $product->price * $product->quantityAvailable . ' $</td> 
                                                            </tr>';
                                                                    } else {
                                                                        $counter++;
                                                                        echo '
                                                            <tr>
                                                                <th>' . $counter . '</th>
                                                                <td> ' . $obj->firstName . ' </td> 
                                                                <td> ' . $obj->lastName . ' </td> 
                                                                <td> ' . $obj->phoneNumber . ' </td> 
                                                                <td> ' . $obj->email . ' </td> 

                                                                <td> ' . $product->productName . ' </td> 
                                                                <td> ' . $product->quantityAvailable . ' </td> 
                                                                <td> ' . $product->price . ' $</td> 
                                                                <td> ' . $product->price * $product->quantityAvailable . ' $</td> 
                                                            </tr>
                                                            ';
                                                                    }
                                                                }
                                                                $continue = true;
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--END FIRST PART -->

                            <!--SECOND PART -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button text-primary collapsed fw-bolder fs-3" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        Requested Waiting Approval
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div style="overflow: auto;">
                                            <form method="post">
                                                <table class="table table-striped text-nowrap">

                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">First Name</th>
                                                            <th scope="col">Last Name</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Phone Number</th>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Price</th>
                                                            <th scope="col">Total Price</th>
                                                            <th scope="col">Governorate</th>
                                                            <th scope="col">City</th>
                                                            <th scope="col">Street</th>
                                                            <th scope="col">Building</th>
                                                            <th scope="col">Contact Number</th>
                                                            <th scope="col">Payment Status</th>
                                                            <th scope="col">Delivery Fees</th>
                                                            <th scope="col">Total</th>
                                                            <th scope="col">Set Delivery Date</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $users = getUsers();
                                                        $counter = 0;
                                                        foreach ($users as $obj) {
                                                            if ($obj instanceof User) {
                                                                $products = getAllDeliveriesWaitingApproval($obj->userId);

                                                                if (!empty($products)) {
                                                                    $continue = false;
                                                                    foreach ($products as $product) {
                                                                        if ($product instanceof DeliveryProduct) {
                                                                            if ($continue) {
                                                                                echo '
                                                                        <tr>
                                                                <th></th>
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td> 

                                                                <td> ' . $product->productName . ' </td> 
                                                                <td> ' . $product->quantityAvailable . ' </td> 
                                                                <td> ' . $product->price . ' $</td> 
                                                                <td> ' . $product->price * $product->quantityAvailable . ' $</td>
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td> 
                                                                <td></td>  
                                                                <td></td>  
                                                            </tr>';
                                                                            } else {
                                                                                $counter++;
                                                                                echo '
                                                            <tr>
                                                                <th>' . $counter . '</th>
                                                                <td> ' . $obj->firstName . ' </td> 
                                                                <td> ' . $obj->lastName . ' </td> 
                                                                <td> ' . $obj->phoneNumber . ' </td> 
                                                                <td> ' . $obj->email . ' </td> 

                                                                <td> ' . $product->productName . ' </td> 
                                                                <td> ' . $product->quantityAvailable . ' </td> 
                                                                <td> ' . $product->price . ' $</td> 
                                                                <td> ' . $product->price * $product->quantityAvailable . ' $</td> 
                                                                <td>' . $product->governorate . '</td> 
                                                                <td>' . $product->city . '</td> 
                                                                <td>' . $product->street . '</td> 
                                                                <td>' . $product->building . '</td> 
                                                                <td>' . $product->contactNumber . '</td> 
                                                                <td>' . $product->paymentStatus . '</td> 
                                                                <td>' . $product->deliveryFees . '</td> 
                                                                <td>' . $product->total . ' $</td> 
                                                                <td>
                                                                    <input name="date' . $product->deliveryId . '" type="date" /> 
                                                                </td> 
                                                                <td><button type="submit" value="' . $product->deliveryId . '" name="approve" class="btn btn-primary">Approve</button></td> 
                                                            </tr>
                                                            ';
                                                                            }
                                                                        }
                                                                        $continue = true;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END SECOND PART -->

                            <!--THIRD PART -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button text-primary fw-bolder collapsed fs-3" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        Approved Waiting Payment
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div style="overflow: auto;">
                                            <form method="post">
                                                <table class="table table-striped text-nowrap">

                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">First Name</th>
                                                            <th scope="col">Last Name</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Phone Number</th>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Price</th>
                                                            <th scope="col">Total Price</th>
                                                            <th scope="col">Governorate</th>
                                                            <th scope="col">City</th>
                                                            <th scope="col">Street</th>
                                                            <th scope="col">Building</th>
                                                            <th scope="col">Contact Number</th>
                                                            <th scope="col">Payment Status</th>
                                                            <th scope="col">Delivery Fees</th>
                                                            <th scope="col">Total</th>
                                                            <th scope="col">Delivery Date</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $users = getUsers();
                                                        $counter = 0;
                                                        foreach ($users as $obj) {
                                                            if ($obj instanceof User) {
                                                                $products = getAllDeliveriesApproved($obj->userId);

                                                                if (!empty($products)) {
                                                                    $continue = false;
                                                                    foreach ($products as $product) {
                                                                        if ($product instanceof DeliveryProduct) {
                                                                            if ($continue) {
                                                                                echo '
                                                                            <tr>
                                                                                <th></th>
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 

                                                                                <td> ' . $product->productName . ' </td> 
                                                                                <td> ' . $product->quantityAvailable . ' </td> 
                                                                                <td> ' . $product->price . ' $</td> 
                                                                                <td> ' . $product->price * $product->quantityAvailable . ' $</td>
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td>  
                                                                                <td></td>  
                                                                            </tr>';
                                                                            } else {
                                                                                $counter++;
                                                                                echo '
                                                                            <tr>
                                                                                <th>' . $counter . '</th>
                                                                                <td> ' . $obj->firstName . ' </td> 
                                                                                <td> ' . $obj->lastName . ' </td> 
                                                                                <td> ' . $obj->phoneNumber . ' </td> 
                                                                                <td> ' . $obj->email . ' </td> 

                                                                                <td> ' . $product->productName . ' </td> 
                                                                                <td> ' . $product->quantityAvailable . ' </td> 
                                                                                <td> ' . $product->price . ' $</td> 
                                                                                <td> ' . $product->price * $product->quantityAvailable . ' $</td> 
                                                                                <td>' . $product->governorate . '</td> 
                                                                                <td>' . $product->city . '</td> 
                                                                                <td>' . $product->street . '</td> 
                                                                                <td>' . $product->building . '</td> 
                                                                                <td>' . $product->contactNumber . '</td> 
                                                                                <td>' . $product->paymentStatus . '</td> 
                                                                                <td>' . $product->deliveryFees . '</td> 
                                                                                <td>' . $product->total . ' $</td> 
                                                                                <td>
                                                                                    ' . $product->deliveryDate . ' 
                                                                                </td> 
                                                                                <td><button type="submit" value="' . $product->deliveryId . '" name="received" class="btn btn-primary">Mark As Received</button></td> 
                                                                            </tr>
                                                                            ';
                                                                            }
                                                                        }
                                                                        $continue = true;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END THIRD PART -->

                            <!--FOURTH PART -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-bolder collapsed fs-3" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        Payment Received
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div style="overflow: auto;">
                                            <table class="table table-striped text-nowrap">

                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">First Name</th>
                                                        <th scope="col">Last Name</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Phone Number</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Total Price</th>
                                                        <th scope="col">Governorate</th>
                                                        <th scope="col">City</th>
                                                        <th scope="col">Street</th>
                                                        <th scope="col">Building</th>
                                                        <th scope="col">Contact Number</th>
                                                        <th scope="col">Payment Status</th>
                                                        <th scope="col">Delivery Fees</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col">Delivery Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $users = getUsers();
                                                    $counter = 0;
                                                    foreach ($users as $obj) {
                                                        if ($obj instanceof User) {
                                                            $products = getAllDeliveriesReceived($obj->userId);

                                                            if (!empty($products)) {
                                                                $continue = false;
                                                                foreach ($products as $product) {
                                                                    if ($product instanceof DeliveryProduct) {
                                                                        if ($continue) {
                                                                            echo '
                                                                            <tr>
                                                                                <th></th>
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 

                                                                                <td> ' . $product->productName . ' </td> 
                                                                                <td> ' . $product->quantityAvailable . ' </td> 
                                                                                <td> ' . $product->price . ' $</td> 
                                                                                <td> ' . $product->price * $product->quantityAvailable . ' $</td>
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td> 
                                                                                <td></td>  
                                                                            </tr>';
                                                                        } else {
                                                                            $counter++;
                                                                            echo '
                                                                            <tr>
                                                                                <th>' . $counter . '</th>
                                                                                <td> ' . $obj->firstName . ' </td> 
                                                                                <td> ' . $obj->lastName . ' </td> 
                                                                                <td> ' . $obj->phoneNumber . ' </td> 
                                                                                <td> ' . $obj->email . ' </td> 

                                                                                <td> ' . $product->productName . ' </td> 
                                                                                <td> ' . $product->quantityAvailable . ' </td> 
                                                                                <td> ' . $product->price . ' $</td> 
                                                                                <td> ' . $product->price * $product->quantityAvailable . ' $</td> 
                                                                                <td>' . $product->governorate . '</td> 
                                                                                <td>' . $product->city . '</td> 
                                                                                <td>' . $product->street . '</td> 
                                                                                <td>' . $product->building . '</td> 
                                                                                <td>' . $product->contactNumber . '</td> 
                                                                                <td>' . $product->paymentStatus . '</td> 
                                                                                <td>' . $product->deliveryFees . '</td> 
                                                                                <td>' . $product->total . ' $</td> 
                                                                                <td>
                                                                                    ' . $product->deliveryDate . ' 
                                                                                </td> 
                                                                            </tr>
                                                                            ';
                                                                        }
                                                                    }
                                                                    $continue = true;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--END FOURTH PART -->
                            </div>
                        </div>
                    </div>
                </div>
        </section>

    </main><!-- End #main -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!--JS Files -->
    <script src="../css/admin-style/apexcharts/apexcharts.min.js"></script>
    <script src="../css/admin-style/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../css/admin-style/chart.js/chart.umd.js"></script>
    <script src="../css/admin-style/echarts/echarts.min.js"></script>
    <script src="../css/admin-style/quill/quill.min.js"></script>
    <script src="../css/admin-style/simple-datatables/simple-datatables.js"></script>
    <script src="../css/admin-style/tinymce/tinymce.min.js"></script>
    <script src="../css/admin-style/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="../js/adminJS.js"></script>
    </script>
</body>

</html>