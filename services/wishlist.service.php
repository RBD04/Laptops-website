<?php
require_once "../helpers/connection.php";
session_start();
if(isset($_SESSION['user'])){
$delete = "DELETE FROM wishlistproduct WHERE productId='".$_GET['x']."'";
$deleted = mysqli_query($con,$delete);
header("Location:../pages/wishlist.php")
;}
else{
    echo "No permission Granted !";
}
?>
