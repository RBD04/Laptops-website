<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/cart.php';
require_once 'serialNumber.service.php';
require_once 'cartProduct.service.php';
require_once 'product.service.php';

function createCart($id)
{
    $wrapper = new dbWrapper();

    if (isset($id)) {
        $query = 'INSERT INTO cart(userId) VALUES(' . $id . ')';
        $wrapper->executeUpdate($query);
    } else {
        echo '<script>alert("Error inserting Cart")</script>';
    }
}

function getCurrentCart($userId)
{
    $wrapper = new dbWrapper();

    $query = 'SELECT cartId from cart WHERE userId="' . $userId . '" AND confirmed="0" ';

    $result = $wrapper->executeSingleRowQuery($query);
    $count = count($result);

    if ($count === 0) {
        return 'No record found';
    } else if ($count > 1) {
        return 'Please contact your administrator';
    } else if ($count === 1) {
        return $result[0]['cartId'];
    }
}

function addToCart($productId)
{
        
    if (isset($_SESSION['user'])) {
        $cartId = getCurrentCart($_SESSION['user']);

        $product = getProductById($productId);

        $quantity = $product->quantityAvailable-1;

        setSerialReserved($product->ProductId);

        addToCartProduct($cartId, $product->ProductId);

        updateProductQuantity($product->ProductId, $quantity);
        
    } else echo '<script>alert("You need to login first")</script>';
}

function cartConfirmed()
{
}
