<?php
require_once 'connection.php';
session_start();
if (!isset($_SESSION) || !isset($_SESSION['user']))
  header('Location: adminlogin.php');

$query = "SELECT * FROM category";
$result = mysqli_query($con, $query);
$r = mysqli_num_rows($result);
mysqli_close($con);
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
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

  <title>Laptops website</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.php">
            <span> Laptops website </span>
          </a>
          
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="shop.php"> Shop </a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="contact.php">Contact Us <span class="sr-only">(current)</span>
                </a>
              </li>
            </ul>
            <div class="user_option-box">
              <a href="login.php">
                <i class="fa fa-user" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
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
  <div class="container m-5">
    <h1>Product Page</h1>
    <form method="post">
      <div class="form-group">
        <label for="productName">Product name</label>
        <input type="text" class="form-control" id="productName" name="productName" />
      </div>
      <div class="form-group">
        <label for="serialNumber">Serial Number</label>
        <input type="text" class="form-control" id="serialNumber" name="serialNumber" />
      </div>
      <div class="form-group">
        <label for="Category">Category</label>
        <select class="form-control" id="category" name="category">
          <?php
          for ($i = 0; $i < $r; $i++) {
            $row = mysqli_fetch_assoc($result);
            echo '<option value=' . $row['categoryId'] . '>' . $row['categoryName'] . '</option>';
          }
          ?>

        </select>
      </div>
      <div class="form-group">
        <label for="description">Descritpion</label>
        <textarea type="text" class="form-control" id="description" name="description"></textarea>
      </div>
      <div class="form-group">
        <label for="price">Price</label>
        <input type="text" class="form-control" id="price" name="price" />
      </div>
      <div class="form-group">
        <label for="thumbnail">Thumbnail</label>
        <input type="file" class="form-control-file" id="thumbnail" name="thumbnail" />
      </div>
      <div class="form-group">
        <label for="images">Images</label>
        <input type="file" class="form-control-file" id="images" name="images" multiple />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      <button type="reset" class="btn btn-primary">Reset</button>
    </form>
  </div>

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
  <!-- End Google Map -->
</body>

</html>