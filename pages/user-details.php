<?php
require_once '../services/user.service.php';

session_start();

$users = getUsers();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scal.0" name="viewport">

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
  * Updated: Mar 09 2023 with Bootstrap v5
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
            echo 'Admin page ';
        ?>
        <?php
        if (isset($_SESSION['name']))
            echo '
            <form method="post">
            <button class="btn btn-primary m-3" type="submit" name="logout" value="logout">Logout</button>
            </form>
            ';
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
        <a class="nav-link collapsed text-primary" href="../pages/user-details.php">
          <i class="bi bi-person-fill-gear"></i>
          <span>Manage Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="view-products.php">
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
        <a class="nav-link collapsed" href="../pages/orders.php">
          <i class="bi bi-card-checklist"></i>
          <span>View Orders</span>
        </a>
      </li>
            <!-- End Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->


    <!-- End Page Title -->
    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>Manage Users</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Users Details</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped ms-auto me-auto container-fluid" style="vertical-align: middle;">
                        <tr>
                            <th class="text-primary text-center ">Number</th>
                            <th class="text-primary text-center">Profile</th>
                            <th class="text-primary text-center ">First Name</th>
                            <th class="text-primary  text-center">Last Name</th>
                            <th class="text-primary  text-center">Email</th>
                            <th class="text-primary  text-center">Phone</th>
                            <th class="text-primary  text-center">Birthday</th>
                            <th class="text-primary  text-center">Actions</th>
                        </tr>
                        <?php
                        foreach ($users as $key => $obj) {
                            echo '
                            <tr class="text-muted text-center">
                                <td >' . ++$key . '</td>
                                <td><img src="' . $obj->profilePicture . '" width="100px" height="100px" class="m-4" /></td>
                                <td>' . $obj->firstName . '</td>
                                <td>' . $obj->lastName . '</td>
                                <td>' . $obj->email . '</td>
                                <td>' . $obj->phoneNumber . '</td>
                                <td>' . $obj->birthday . '</td>
                                <td><button class="btn btn-primary">Edit</button></td>
                            </tr>
                            ';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!--JS Files-->
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
</body>

</html>