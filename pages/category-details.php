<?php
require_once '../helpers/connection.php';
require_once '../helpers/categories.php';
require_once '../services/category.service.php';

session_start();

if (!isset($_SESSION) || !isset($_SESSION['admin']))
  header('Location: adminlogin.php');

if (array_key_exists('logout', $_POST)) {
  session_destroy();
  header("Refresh:0");
}
if(isset($_GET['categoryId']))
$category = getCategoryById($_GET['categoryId']);
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
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon" />

  <title>Laptops website</title>

  <!-- bootstrap core css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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

  <div class="hero_area">

    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="home.php">
            <span> Laptops website </span>
          </a>
          <?php
          if (isset($_SESSION['name']))
            if (isset($_SESSION['admin']))
              echo 'Welcome admin ' . $_SESSION['name'];
            else echo 'Welcome '
          ?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="home.php">Home </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="shop.php"> Shop </a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="contact.php">Contact Us <span class="sr-only">(current)</span>
                </a>
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
                  <li><span class="dropdown-item-text">No Items Available</span></li>
                  <li><a class="dropdown-item" href="#">First Item</a></li>
                  <li><a class="dropdown-item" href="#">Second Item</a></li>
                  <li><a class="dropdown-item" href="#">Third Item</a></li>
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
  <div class="container m-5">

    <div class="row">
      <div class="col-4">
        <h3 class="mb-5">Admin control panel</h3>
        <div class="list-group">
          <a class="list-group-item" href="add-product.php">Add product</a>
          <a class="list-group-item" href="product-details.php">Product details (dont press now)</a>
          <a class="list-group-item active" href="category-details.php" aria-current="true">Category details</a>
        </div>
      </div>
      <div id="form-container" class="col">
        <form class="mb-3" id="add-product" method="post">
          <div class="form-group">
            <h1 class="mb-3">Category details</h1>
            <label for="category"><?php echo isset($category) ? $category->categoryName.' Selected' : 'Insert new Category'; ?></label><br/>
            <input type="text" class="form-control mb-3" id="productName" name="category" value='<?php
                                                                                                  if (isset($category)) {
                                                                                                    echo $category->categoryName;
                                                                                                  } else  "" ?>' />
            <input name="categoryId" type="hidden" value='<?php
                                                          if (isset($category)) {
                                                            echo $category->categoryId;
                                                          } else  "" ?>' />
          </div>
          <?php
          if (isset($_POST['category']))
            echo updateCategory()
          ?>
          <button type="submit" class="btn btn-primary">Save</button>
          <a href="category-details.php" class="btn btn-primary">Refresh</a>
        </form>
        <?php echo $categoryMessage ?>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $categories = getCategories();
            if (count($categories) > 0) {
              foreach ($categories as $i => $category) {
                echo "<tr>
                <th scope='row'>" . $i + 1, "</th>" .
                  "<td>" . $category->categoryName . "</td>" .
                  "<td><a href='./category-details.php?categoryId=" . $category->categoryId . "'>edit</a></td>
              </tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php

    ?>


  </div>

  <!-- jQery -->
  <script src="../js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <!-- bootstrap js -->
  <script src="../js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- custom js -->
  <script src="../js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
  <!-- End Google Map -->
</body>

</html>