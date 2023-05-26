<?php 
require_once 'connection.php';
require_once 'get-products.php';

$cartId=$_POST['cartId'];
$productId=$_POST['productId'];
$quantity=$_POST['quantity'];

$products=mysqli_fetch_assoc($productsResult);
$quantityAvailable=$products['quantityAvailable']-1;
$price=$products['price'];

$updateSerialNumbersQuery='UPDATE serialnumber SET status="reserved" WHERE productId="'.$productId.'" LIMIT .'.$quantity;

$updarteProductQuery='UPDATE product SET quantity="'.$quantityAvailable.'" WHERE productId="'.$productId.'"';

$addToCartProductQuery='INSERT INTO table cartproduct(cartId,productId,quantity) values('.$cartId.','.$productId.','.$quantity.')';

$updateCartQuery='UPDATE cart SET ';



?>