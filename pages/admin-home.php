<?php
require_once '../helpers/connection.php';
require_once '../services/category.service.php';
require_once '../services/product.service.php';

session_start();
if (!isset($_SESSION) || !isset($_SESSION['admin']))
  header('Location: adminlogin.php');

if (array_key_exists('logout', $_POST)) {
  session_destroy();
  header("Refresh:0");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin Page : TechZone</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../css/admin-style/icon.png" rel="icon">
  <link href="../css/admin-style/le-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
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
        <span class="d-none d-lg-block text-dark fw-bolder">TechZone</span>
      </a>
      <?php
      if (isset($_SESSION['name']))
        if (isset($_SESSION['admin']))
          echo 'Welcome ' . $_SESSION['name'] . ' ';
      ?>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <div class="search-bar mx-auto">
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
    </nav>
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
          <a class="nav-link" href="admin-home.php">
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
        <!-- End Blank Page Nav -->

      </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

      <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->

      <section class="section dashboard">
        <div class="row">

          <!-- Left side columns -->
          <div class="col-lg-12">
            <div class="row">
              <?php
              $q  = "SELECT COUNT(deliveryId) AS dnb FROM delivery WHERE deliveryDate LIKE '".date("Y-m-d")."'";
              $res = mysqli_query($con,$q);
              $row = mysqli_fetch_assoc($res);
              $new = $row['dnb'];
              $yesterday = time() - 60*60*24;
              $q1 = "SELECT COUNT(deliveryId) AS old FROM delivery WHERE deliveryDate LIKE '".date("Y-m-d","$yesterday")."'";
              $res1 = mysqli_query($con,$q1);
              $row1 = mysqli_fetch_assoc($res1);
              $old = $row1['old'];
              $change = $new - $old;
              $msg = "";
              $i = 0;
              if($change > 0){
                $i = ($change / $old )*100;
                $msg = "increase";
              }
             else if($change < 0){
                $i = ($change / $old )*100;
                $msg = "decrease";
              }
             else if($change == 0){
                $i = 0;
                $msg = "stable";
              }
            
             echo' <!-- Sales Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">


                  <div class="card-body">
                    <h5 class="card-title">Sales <span>| Today</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                      </div>
                      <div class="ps-3">
                        <h6>'.$new.'</h6>
                        <span class="text-success small pt-1 fw-bold">'.$i.'%</span> <span
                          class="text-muted small pt-2 ps-1">'.$msg.'</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div>';

              ?><!-- End Sales Card -->

              <!-- Revenue Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card revenue-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Revenue <span>| This Month</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-currency-dollar"></i>
                      </div>
                      <div class="ps-3">
                        <h6>$3,264</h6>
                        <span class="text-success small pt-1 fw-bold">8%</span> <span
                          class="text-muted small pt-2 ps-1">increase</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div><!-- End Revenue Card -->

              <!-- Customers Card -->
              <div class="col-xxl-4 col-xl-12">

                <div class="card info-card customers-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Customers <span>| This Year</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                      </div>
                      <div class="ps-3">
                        <h6>1244</h6>
                        <span class="text-danger small pt-1 fw-bold">12%</span> <span
                          class="text-muted small pt-2 ps-1">decrease</span>

                      </div>
                    </div>

                  </div>
                </div>

              </div><!-- End Customers Card -->
              <!-- Recent Sales -->
              <div class="col-12">
                <div class="card recent-sales overflow-auto">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Recent Sales <span>| Today</span></h5>

                    <table class="table table-borderless datatable">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Customer</th>
                          <th scope="col">Product</th>
                          <th scope="col">Price</th>
                          <th scope="col">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row"><a href="#">#2457</a></th>
                          <td>Brandon Jacob</td>
                          <td><a href="#" class="text-primary">At praesentium minu</a></td>
                          <td>$64</td>
                          <td><span class="badge bg-success">Approved</span></td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#">#2147</a></th>
                          <td>Bridie Kessler</td>
                          <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                          <td>$47</td>
                          <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#">#2049</a></th>
                          <td>Ashleigh Langosh</td>
                          <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                          <td>$147</td>
                          <td><span class="badge bg-success">Approved</span></td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#">#2644</a></th>
                          <td>Angus Grady</td>
                          <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                          <td>$67</td>
                          <td><span class="badge bg-danger">Rejected</span></td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#">#2644</a></th>
                          <td>Raheem Lehner</td>
                          <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                          <td>$165</td>
                          <td><span class="badge bg-success">Approved</span></td>
                        </tr>
                      </tbody>
                    </table>

                  </div>

                </div>
              </div><!-- End Recent Sales -->

              <!-- Top Selling -->
              <div class="col-12">
                <div class="card top-selling overflow-auto">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body pb-0">
                    <h5 class="card-title">Top Selling <span>| Today</span></h5>

                    <table class="table table-borderless">
                      <thead>
                        <tr>
                          <th scope="col">Preview</th>
                          <th scope="col">Product</th>
                          <th scope="col">Price</th>
                          <th scope="col">Sold</th>
                          <th scope="col">Revenue</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row"><a href="#"><img src="../css/admin-style/duct-1.jpg" alt=""></a></th>
                          <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                          <td>$64</td>
                          <td class="fw-bold">124</td>
                          <td>$5,828</td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#"><img src="../css/admin-style/duct-2.jpg" alt=""></a></th>
                          <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                          <td>$46</td>
                          <td class="fw-bold">98</td>
                          <td>$4,508</td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#"><img src="../css/admin-style/duct-3.jpg" alt=""></a></th>
                          <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                          <td>$59</td>
                          <td class="fw-bold">74</td>
                          <td>$4,366</td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#"><img src="../css/admin-style/duct-4.jpg" alt=""></a></th>
                          <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                          <td>$32</td>
                          <td class="fw-bold">63</td>
                          <td>$2,016</td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#"><img src="../css/admin-style/duct-5.jpg" alt=""></a></th>
                          <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                          <td>$79</td>
                          <td class="fw-bold">41</td>
                          <td>$3,239</td>
                        </tr>
                      </tbody>
                    </table>

                  </div>

                </div>
              </div><!-- End Top Selling -->

            </div>
          </div><!-- End Left side columns -->
        </div><!-- End Right side columns -->

      </section>

    </main><!-- End #main -->

    <!-- Vendor JS Files -->
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