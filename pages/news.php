<?php
require_once '../helpers/connection.php';

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

    <title>Tech Zone: Manage News</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../css/admin-style/icon.png" rel="icon">
    <link href="../css/admin-style/le-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
                    <span>News</span>
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
                <a class="nav-link collapsed text-primary" href="../pages/news.php">
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
            <h1>News</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">News</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <form action="" method="post" enctype="multipart/form-data">
            <section id="edit-posters" class="section ">
                <div class="row">
                    <p class="display-6 p-3">Poster 1</p>
                    <table>
                        <tr>
                            <td><input class="form-control" type="file" name="poster1"></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" name="title1" size="20" placeholder="title"></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" name="text1" size="100" placeholder="text"></td>
                        </tr>
                    </table>
                    <p class="display-6 p-3">Poster 2</p>
                    <table>
                        <tr>
                            <td><input class="form-control" type="file" name="poster2"></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" name="title2" size="20" placeholder="title"></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" name="text2" size="100" placeholder="text"></td>
                        </tr>
                    </table>
                    <p class="display-6 p-3">Poster 3</p>
                    <table>
                        <tr>
                            <td><input class="form-control" type="file" name="poster3"></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" name="title3" size="20" placeholder="title"></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" name="text3" size="100" placeholder="text"></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="text-center"><input class="btn btn-primary text-center text-light mx-1 my-3" type="submit" value="Update"><input class="btn btn-secondary text-center text-light mx-1 my-3" type="reset" value="Clear"></td>
                        </tr>
                    </table>
        </form>
        <?php
        if (isset($_POST['title1'])&&$_POST['title1'] != "" && isset($_POST['text1'])){
            if(!empty($_FILES['poster1'])){
            $dest = $_FILES['poster1']['name'];
            move_uploaded_file($_FILES['poster1']['tmp_name'],"../uploads/news/".$dest);
            }
            $q = "SELECT * FROM news WHERE posterId =1";
            $res = mysqli_query($con, $q);
            $n = mysqli_num_rows($res);
            if ($n != 1) {
                $subq = "INSERT INTO news(posterId,adminId,img,title,text) VALUES(1,".$_SESSION['admin'].",'".$dest."','".$_POST['title1']."','".$_POST['text1']."')";
                $res2 = mysqli_query($con,$subq);
                if($res2){
                    echo "<p class='text-success'>Poster 1 Updated !</p>";
                }
                else{
                    echo "<p class='text-danger>'Error Occured while Updating Poster 1 !</p>";
                }
                
            }
            else{
                $altq = "UPDATE news SET adminId='".$_SESSION['admin']."', img='".$dest."', title='".$_POST['title1']."', text='".$_POST['text1']."' WHERE posterId= 1";
                $res2 = mysqli_query($con,$altq);
                if($res2){
                    echo "<p class='text-success'>Poster 1 Updated !</p>";
                }
                else{
                    echo "<p class='text-danger>'Error Occured while Updating Poster 1 !</p>";
                }
            }
        }
        else{
            echo "<p>Poster 1 still intact !</p>";
        }
        if (isset($_POST['title2'])&& $_POST['title2'] != "" && isset($_POST['text2'])){
            if(!empty($_FILES['poster2'])){
            $dest = $_FILES['poster2']['name'];
            move_uploaded_file($_FILES['poster2']['tmp_name'],"../uploads/news/".$dest);
            }
            $q = "SELECT * FROM news WHERE posterId =2";
            $res = mysqli_query($con, $q);
            $n = mysqli_num_rows($res);
            if ($n != 1) {
                $subq = "INSERT INTO news(posterId,adminId,img,title,text) VALUES(2,".$_SESSION['admin'].",'".$dest."','".$_POST['title2']."','".$_POST['text2']."')";
                $res2 = mysqli_query($con,$subq);
                if($res2){
                    echo "<p class='text-success'>Poster 2 Updated !</p>";
                }
                else{
                    echo "<p class='text-danger>'Error Occured while Updating Poster 2 !</p>";
                }
                
            }
            else{
                $altq = "UPDATE news SET adminId='".$_SESSION['admin']."', img='".$dest."', title='".$_POST['title2']."', text='".$_POST['text2']."' WHERE posterId= 2";
                $res2 = mysqli_query($con,$altq);
                if($res2){
                    echo "<p class='text-success'>Poster 2 Updated !</p>";
                }
                else{
                    echo "<p class='text-danger>'Error Occured while Updating Poster 2 !</p>";
                }
            }
        }
        else{
            echo "<p>Poster 2 still intact !</p>";
        }
        if (isset($_POST['title3'])&&$_POST['title3'] != "" && isset($_POST['text3'])){
            if(!empty($_FILES['poster3'])){
            $dest = $_FILES['poster3']['name'];
            move_uploaded_file($_FILES['poster1']['tmp_name'],"../uploads/news/".$dest);
            }
            $q = "SELECT * FROM news WHERE posterId =3";
            $res = mysqli_query($con, $q);
            $n = mysqli_num_rows($res);
            if ($n != 1) {
                $subq = "INSERT INTO news(posterId,adminId,img,title,text) VALUES(3,".$_SESSION['admin'].",'".$dest."','".$_POST['title3']."','".$_POST['text3']."')";
                $res2 = mysqli_query($con,$subq);
                if($res2){
                    echo "<p class='text-success'>Poster 3 Updated !</p>";
                }
                else{
                    echo "<p class='text-danger>'Error Occured while Updating Poster 3 !</p>";
                }
                
            }
            else{
                $altq = "UPDATE news SET adminId='".$_SESSION['admin']."', img='".$dest."', title='".$_POST['title3']."', text='".$_POST['text3']."' WHERE posterId= 3";
                $res2 = mysqli_query($con,$altq);
                if($res2){
                    echo "<p class='text-success'>Poster 3 Updated !</p>";
                }
                else{
                    echo "<p class='text-danger>'Error Occured while Updating Poster 3 !</p>";
                }
            }
        }
        else{
            echo "<p>Poster 3 still intact !</p>";
        }
        ?>
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