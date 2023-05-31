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

function getCurrentCartId($userId)
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

function addToCart($productId, $quantity)
{

    if (isset($_SESSION['user'])) {
        $cartId = getCurrentCartId($_SESSION['user']);

        $product = getProductById($productId);

        if ($quantity > $product->quantityAvailable) {
            return 'Sorry, quantity requested is not available now!';
        } else {
            $newQuantity = $product->quantityAvailable - $quantity;

            setSerialReserved($product->ProductId, $quantity);

            addToCartProduct($cartId, $product->ProductId, $quantity);

            updateProductQuantity($product->ProductId, $newQuantity);
            return $product->productName . ' added to cart successfully';
        }
    } else echo '<script>alert("You need to login first")</script>';
}

function getCartProducts()
{
    $wrapper = new dbWrapper();
    $products = [];
    if (isset($_SESSION['user'])) {
        $cartId = getCurrentCartId($_SESSION['user']);
        $query = 'SELECT *
            FROM product 
            NATURAL JOIN cartproduct
            NATURAL JOIN cart
            WHERE cartId="' . $cartId . '"
            AND confirmed=0';


        $results = $wrapper->executeQuery($query);

        foreach ($results as $result) {
            $product = new Product();

            $product->ProductId = $result['ProductId'];
            $product->productName = $result['productName'];
            $product->description = $result['description'];
            $product->thumbnail = $result['thumbnail'];
            $product->price = $result['price'];
            $product->quantityAvailable = $result['quantity'];

            $products[] = $product;
        }
    } else $products='No items available';

    return $products;
}

function cartConfirmed()
{
    $query = 'UPDATE cart
            SET confirmed=1
            ';
}
