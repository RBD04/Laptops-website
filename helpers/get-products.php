<?php 
require_once('connection.php');

$categoryMessage = '';

$getProductsQuery = 'SELECT * FROM product NATURAL JOIN serialnumber WHERE status="available"';
$productsResult = mysqli_query($con, $getProductsQuery);
$countProducts = mysqli_num_rows($productsResult);

?>