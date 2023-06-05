<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/cart.php';
require_once 'serialNumber.service.php';
require_once 'cartProduct.service.php';
require_once 'product.service.php';
require_once 'delivery.service.php';

function createCart($id)
{
    $wrapper = new dbWrapper();

    if (isset($id)) {
        $query = 'INSERT INTO cart(userId,confirmed) VALUES(' . $id . ',0)';
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

function setCartConfirmed($userId, $totalPrice, $finalPrice)
{
    $wrapper = new dbWrapper();

    $query = 'UPDATE cart SET confirmed=1, totalPrice="' . $totalPrice . '", finalPrice="' . $finalPrice . '" WHERE userId="' . $userId . '" AND confirmed="0"';
    $wrapper->executeUpdate($query);
}

function addToCart($productId, $quantity)
{

    if (isset($_SESSION['user'])) {
        $cartId = getCurrentCartId($_SESSION['user']);

        $product = getProductById($productId);

        if ($quantity > $product->quantityAvailable) {
            return false;
        } else {
            $newQuantity = $product->quantityAvailable - $quantity;

            setSerialReserved($product->ProductId, $quantity);

            addToCartProduct($cartId, $product->ProductId, $quantity);

            updateProductQuantity($product->ProductId, $newQuantity);
            return true;
        }
    } else echo '<script>alert("You need to login first")</script>';
}


function removeProductFromCart($productId, $quantity)
{

    if (isset($_SESSION['user'])) {
        $cartId = getCurrentCartId($_SESSION['user']);

        $product = getProductById($productId);

        $newQuantity = $product->quantityAvailable + $quantity;

        setSerialAvailable($product->ProductId, $quantity);

        updateCartProduct($cartId, $product->ProductId, $quantity);

        updateProductQuantity($product->ProductId, $newQuantity);
    } else echo '<script>alert("You need to login first")</script>';
}

function getCartProducts()
{
    $wrapper = new dbWrapper();
    $products = [];
    if (isset($_SESSION['user'])) {
        $cartId = getCurrentCartId($_SESSION['user']);
        $query = 'SELECT *
            FROM cartproduct 
            NATURAL JOIN product
            WHERE cartId="' . $cartId . '"
            AND quantity>0';


        $results = $wrapper->executeQuery($query);

        if (!count($results) == 0) {
            foreach ($results as $item) {
                $product = new Product();

                $product->ProductId = $item['productId'];
                $product->productName = $item['productName'];
                $product->description = $item['description'];
                $product->thumbnail = $item['thumbnail'];
                $product->price = $item['price'];
                $product->quantityAvailable = $item['quantity'];

                $products[] = $product;
            }
        } else $products = 'No Items Available';
    } else $products = 'No Items Available';

    return $products;
}

function cartConfirmed($governorate,$city,$street,$building,$address)
{

    if (isset($_SESSION['user'])) {
        $userId=$_SESSION['user'];
        $cartId = getCurrentCartId($userId);
        $products = getCartProducts();
        $totalPrice=0;
        $cartProductPrice=0;
        $discount=0;
        foreach ($products as $obj) {
            setItemPrices($cartId, $obj->ProductId, $obj->price);
            setSerialSoldOut($obj->ProductId);
            $cartProductPrice=getCartProductQuantity($cartId,$obj->ProductId)*$obj->price;
            $totalPrice+=$cartProductPrice;
        }

        $finalPrice=$totalPrice-$discount;
        setCartConfirmed($userId,$totalPrice,$finalPrice);
        setDelivery($cartId,$userId,$governorate,$city,$street,$building,$address,$finalPrice);

        createCart($userId);
    }
}
