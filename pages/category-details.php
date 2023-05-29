<?php
require_once '../helpers/connection.php';
require_once '../helpers/categories.php';
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
              echo 'Welcome ' . $_SESSION['name'].'(Administrator)';
          ?>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
      
            </ul>
            <?php
            if (isset($_SESSION['name']))
              echo '
            <form method="post">
            <button class="btn btn-primary" type="submit" name="logout" value="logout">Logout</button>
            </form>
            '
            ?>
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
            <label for="category">Category name</label>
            <input type="text" class="form-control mb-3" id="productName" name="category" value='<?php if (isset($category)) echo $category["categoryName"];
                                                                                                  else  "" ?>' />
            <input name="categoryId" type="hidden" value='<?php if (isset($category)) echo $category["categoryId"];
                                                          else  "" ?>' />
          </div>
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
            for ($i = 0; $i < $countCategories; $i++) {
              $row = mysqli_fetch_assoc($categoriesResult);
              echo "<tr>
            <th scope='row'>" . $i + 1, "</th>" .
                "<td>" . $row['categoryName'] . "</td>" .
                "<td><a href='./category-details.php?categoryId=" . $row['categoryId'] . "'>edit</a></td>
          </tr>";
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