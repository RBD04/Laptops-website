<?php
require_once "../helpers/connection.php";
$delete = "DELETE FROM wishlistproduct WHERE productId='".$_GET['x']."'";
$deleted = mysqli_query($con,$delete);
header("Location:../pages/wishlist.php");
?>
