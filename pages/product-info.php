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

    <title>Add Products</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
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
        </div><!-- End Logo -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->
        </nav><!-- End Icons Navigation -->
        <?php
            if (isset($_SESSION['name']))
                if (isset($_SESSION['admin']))
                    echo 'Welcome ' . $_SESSION['name'] . ' ';
            ?>
        <?php
        if (isset($_SESSION['admin']))
            echo '(Admin page) '
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
        <main class="p-5 m-5">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pagetitle">
                            <h1>Product Info</h1>
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="">Home</a></li>
                                </ol>
                            </nav>
                        </div><!-- End Page Title -->
                        <!--Product Info-->
                        <section>
                            <?php
                            $q = "SELECT * FROM product WHERE productId='".$_GET['x']."'";
                            $categoryId = $_GET['y'];        
                            $res = mysqli_query($con,$q);
                            if($res){
                                $row = mysqli_fetch_assoc($res);
                                echo'        <div class="conatiner-fluid">
                                <form method="post" enctype="multipart/form-data" class="row">
                                    <div class="col-lg-4 col-12">
                                        <div class="justify-content-center text-center">
                                            <label for="thumbnail">
                                                <img src="'.$row['thumbnail'].'"width="300rem" height="300rem "
                                                    class="mx-auto mt-3" alt="Profile Picture"
                                                    id="ThumbnailPreview">
                                                <input type="file" id="thumbnail" name="thumbnail"
                                                    style="display: none;" onchange="handleThumbnail(event)"
                                                    disabled>
                                                <p class="text-center lead text-muted">(Edit Thumbnail)</p>
                                                <hr>
                                                <p class="text-center text-secondary">Last Modified on: '.$row['dateAdded'].'</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-12">
                                        <table class="container">
                                            <tr>
                                                <td width=50% class="p-2">
                                                    <label for="id" class="text-primary fs-4">ID</label>
                                                    <input type="text" class="form-control text-primary fs-5"
                                                        id="Name" name="id" value="'.$row['productId'].'"disabled readonly />
                                                </td>
                                                <td width=50% class="p-2">
                                                    <label for="Name" class="text-primary fs-4">
                                                        Name</label>
                                                    <input type="text" class="form-control text-primary fs-5"
                                                        id="tName" name="name" value="'.$row['productName'].'"disabled/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width=50% class="p-2">
                                                    <label for="category" class="text-primary fs-4">Category</label>
                                                    <input type="text" class="form-control text-primary fs-5" id="category"
                                                        name="category" value="'.$_GET['y'].'"disabled readonly/>
                                                </td>
                                                <td width=50% class="p-2">
                                                    <label for="price" class="text-primary fs-4">Price</label>
                                                    <input type="text" class="form-control text-primary fs-5"
                                                        id="price" name="price" value="'.$row['price'].'"disabled />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" width=100% class="text-center p-2">
                                                    <label for="description" class="text-primary fs-4">Description</label>
                                                    <textarea cols="10" rows="5" class="form-control text-primary fs-5"
                                                        id="description" name="description">'.$row['description'].'</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width=50% class="p-2">
                                                    <label for="qtty available" class="text-primary fs-4">Current Quantity</label>
                                                    <input type="text" class="form-control text-primary fs-5"
                                                        id="qtty available" value="'.$row['quantityAvailable'].'" name="currentqtty" disabled />
                                                </td>
                                                <td width=50% class="p-2">
                                                    <label for="newqtty" class="text-primary fs-4">New
                                                        Quantity</label>
                                                    <input type="text" class="form-control text-primary fs-5"
                                                        id="newqtty" name="newquantity" value="'.$row['quantityAvailable'].'" disabled />
                                                </td>
                                            <tr width=100% class="p-2">
                                                <td class="text-center" colspan="2">
                                                    <button type="button" class="btn btn-primary  mx-2" id="edit"
                                                        name="edit" onclick="editFields()">Edit</button> <input
                                                        type="submit" class="btn btn-primary" id="submit" name="submit"
                                                        value="Save Changes" disabled /><a class="btn btn-primary mx-2" href ="product-info.php?x='.$_GET['x'].'&y='.$_GET['y'].'">Refresh</a>
                                                </td>
                                            </tr>
                                            </tr>
                                        </table>
                                        </form>

                                    </div>
                                </div>';
                            }
                             ?>
                             <?php
                             if(isset($_FILES['thumbnail']['name'])){
                                if(!empty($_FILES['thumbnail']['name'])){
                                    $destination  = $_FILES['thumbnail']['name'];
                                    move_uploaded_file($_FILES['thumbnail']['tmp_name'],"../uploads/Thumbnails/".$destination); 
                                }else{
                                    $destination = $row['thumbnail'];
                                }
                             }
                             if(isset($_POST['name'])&&isset($_POST['price'])&&isset($_POST['description'])&&isset($_POST['newquantity'])&&$_POST['name']!=""&&$_POST['price']!=""&&$_POST['description']!=""&&$_POST['newquantity']!=""){
                                $now = date("Y-m-d H:i:s",time()+60*60*3);
                                $q = "UPDATE `product` SET `productName`='".$_POST['name']."',`description`='".$_POST['description']."',`price`='".$_POST['price']."',`quantityAvailable`='".$_POST['newquantity']."',`thumbnail`='".$destination."',dateAdded='".$now."' WHERE productId='".$_GET['x']."'";
                                $res = mysqli_query($con,$q);
                                if($res){
                                    echo "<p class='text-center text-success'>changes made successfully !</p>";
                            }
                            $log = "INSERT INTO adminlog(adminId,productId) VALUES ('".$_SESSION['admin']."','".$_GET['x']."')";
                            $logDone = mysqli_query($con,$log);
                        }
                              ?>
                    
                        </section>

                        <!--Product Info End-->
        </main><!-- End #main -->
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
        <script>
    function editFields() {
      var inputs = document.getElementsByTagName("input");
      for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = false;
      }
      document.getElementById("submit").disabled = false;
    }
  </script>
        </script>
    </body>

    </html>