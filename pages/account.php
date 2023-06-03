<?php
require_once '../services/user.service.php';
require_once '../helpers/cartItems.php';


session_start();
$cartProducts = getCartProducts();
$successMsg = '';
if (isset($_SESSION['user']))
  $user = getUserById($_SESSION['user']);
else (header('Location: home.php'));

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['MS'])) {
  $successMsg = $_GET['MS'];
  switch ($successMsg) {
    case 1:
      $successMsg = 'Error Updating User';
      break;
    case 2:
      $successMsg = 'Error Uploading Profile Picture';
      break;
    case 3:
      $successMsg = 'Info Updated Successfully';
      break;
    case 4:
      $successMsg = 'Error! Password is Incorrect';
      break;
    case 5:
      $successMsg = 'Password Updated Successfully';
      break;
    default:
      $successMsg = null;
      break;
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  extract($_POST);
  if (isset($submit)) {
    $MSG = updateUser($_SESSION['user']);

    header('Location: account.php?MS=' . $MSG . '');
  }
  if (isset($removeProduct)) {
    removeProductFromCart($cartProductId, $cartQuantity);
    header("Refresh:0");
    exit();
  }
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
  <!--Bootstrap 5.2 links-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <title>Tech Zone</title>


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
  <!-- header section -->
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="home.php">
          <span>
            Tech Zone
          </span>
        </a>
        <?php
        if (isset($_SESSION['name']))
          echo 'Welcome ' . $_SESSION['name'];
        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""> </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link fw-bolder text-muted" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-bolder text-muted" href="shop.php"> Shop </a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-bolder text-primary" href="account.php">Account</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-bolder text-muted" href="contact.php">Contact Us</a>
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
              <i class="fa fa-user" aria-hidden="true"></i>
            </a>
            <div class="dropstart">
              <button type="button" class="bg-transparent border-0 ml-3" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
              </button>
              <ul class="dropdown-menu">
                <?php renderCartItems($cartProducts) ?>
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

  <!-- contact section -->


  <section>
    <div class="container">
      <div class="row text-center text-primary mt-3 mb-3">
        <h2 class="display-5 fw-bolder mb-2">
          Account
        </h2>
      </div>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value=<?php echo $user->UserId ?> />
        <div class="row mb-4">
          <div class="col-4">
            <label for="profilePicture">
              <small class="text-primary fs-6">Click Image Below To Upload Profile Picture</small>
              <img src=<?php echo $user->profilePicture ? $user->profilePicture : "../images/defaultProfile.jpg" ?> width="360px" height="380px " class="rounded float-left" alt="Profile Picture" id="profilePicturePreview">
              <input type="file" id="profilePicture" name="profilePicture" style="display: none;" onchange="handleProfilePicture(event)" disabled>
            </label>
          </div>
          <div class="col">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="firstName" class="text-primary fs-4">First Name</label>
                  <input type="text" class="form-control text-primary fs-5" id="firstName" name="firstName" value=<?php echo $user->firstName ?> disabled />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="lastName" class="text-primary fs-4">Last Name</label>
                  <input type="text" class="form-control text-primary fs-5" id="lastName" name="lastName" value=<?php echo $user->lastName ?> disabled />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="email" class="text-primary fs-4">Email</label>
                  <input type="text" class="form-control text-primary fs-5" id="email" name="email" value=<?php echo $user->email ?> disabled />
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="phoneNumber" class="text-primary fs-4">Phone Number</label>
                  <input type="text" class="form-control text-primary fs-5" id="phoneNumber" name="phoneNumber" value=<?php echo $user->phoneNumber ?> disabled />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="birthday" class="text-primary fs-4">Birthday</label>
                  <input type="date" class="form-control text-primary fs-5" id="birthday" name="birthday" value=<?php echo $user->birthday ?> disabled />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="currentPassword" class="text-primary fs-4">Current Password</label>
                  <input type="text" class="form-control text-primary fs-5" id="currentPassword" name="currentPassword" disabled />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="newPassword" class="text-primary fs-4">New Password</label>
                  <input type="text" class="form-control text-primary fs-5" id="newPassword" name="newPassword" disabled />
                </div>
              </div>
            </div>


          </div>
        </div>


        <div class="row mb-4 mt-4">
          <div class="col">
            <button type="button" class="btn btn-primary w-100 fs-5" id="edit" name="edit" onclick="editFields()">Edit</button>
          </div>
          <div class="col">
            <input type="submit" class="btn btn-primary fs-5 w-100" id="submit" name="submit" value="Save Changes" disabled />
            <p class="text-primary"><?php echo $successMsg   ?></p>
          </div>
        </div>
    </div>
    </form>
    </div>
    </div>
  </section>

  <!-- end contact section -->

  <!-- footer section -->
  <footer class="footer_section bg-primary">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-6 footer-col text-center">
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
          <a href="https://html.design/">Tech Zone</a>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
  <script>
    function editFields() {
      var inputs = document.getElementsByTagName("input");
      for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = false;
      }
      document.getElementById("submit").disabled = false;
    }

    function handleProfilePicture(event) {
      var input = event.target;
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById("profilePicturePreview").src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
</body>

</html>