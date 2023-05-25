<?php
require_once 'connection.php';

$isSuccessAdding = '';
$isSuccessAddingSerials;

if (isset($_POST) && isset($_POST['quantity'])) {
  $addProductQuery = 'INSERT INTO product(categoryId,productName,description,price,quantityAvailable) 
  values("' . $_POST['category'] . '","' . $_POST['productName'] . '","' . $_POST['description'] . '","' . $_POST['price'] . '","' . $_POST['quantity'] . '") ';
  $id;

  if (!mysqli_query($con, $addProductQuery)) {
    $isSuccessAdding = 'Error adding product';
    die("Error adding product");
  } else {
    $id = mysqli_insert_id($con);
    $isSuccessAdding = 'Product ' . $_POST['productName'] . ' Added successfully';
  }
  
  for ($i = 0; $i < $_POST['quantity']; $i++) {
    $addSerialNumberQuery = 'INSERT INTO serialnumber(productId,serialNumber) values("' . $id . '","' . $_POST['serial' . ($i + 1)] . '")';
    if (!mysqli_query($con, $addSerialNumberQuery)) {
      die("Error Adding serial Number" . ($i + 1));
      break;
    } else {
      $isSuccessAddingSerials = 'Serial numbers added successfully';
    }
  }

}

?>