<?php 
require_once 'connection.php';
require_once 'get-products.php';

$cartId=$_POST['cartId'];
$productId=$_POST['productId'];
$quantity=$_POST['quantity'];

$getProductQuery=`SELECT * FROM product WHERE ProductID="$productId"`;
$getCartQuery=`SELECT * FROM product WHERE cartId="$cartId"`;

mysqli_query($con,$getProductQuery);
mysqli_query($con,$getCartQuery);

$products=mysqli_fetch_assoc($productsResult);
$quantityAvailable=$products['quantityAvailable']-1;
$price=$products['price'];

$updateSerialNumbersQuery=`UPDATE serialnumber SET status="reserved" WHERE productId="$productId" LIMIT "$quantity"`;

$updateProductQuery='UPDATE product SET quantity="'.$quantityAvailable.'" WHERE productId="'.$productId.'"';

$addToCartProductQuery='INSERT INTO cartproduct(cartId,productId,quantity) values('.$cartId.','.$productId.','.$quantity.')';

$updateCartQuery='UPDATE cart SET ';



?>