<?php
require_once '../helpers/dbWrapper.php';
require_once 'user.service.php';

function addToCartProduct($cartId, $productId, $quantity)
{
    $wrapper = new dbWrapper();


    if (alreadyAdded($cartId, $productId)) {
        $newQuantity = getCartProductQuantity($cartId, $productId);
        $newQuantity = $newQuantity + $quantity;
        $query = 'UPDATE cartproduct SET quantity="' . $newQuantity . '" WHERE cartId = "' . $cartId . '" AND productId = "' . $productId . '"';
        $wrapper->executeUpdate($query);
    } else {
        $query = 'INSERT INTO cartproduct(cartId,productId,quantity) VALUES("' . $cartId . '","' . $productId . '",' . $quantity . ')';
        $wrapper->executeUpdate($query);
    }
}

function updateCartProduct($cartId, $productId, $quantity)
{
    $wrapper = new dbWrapper();

    if (alreadyAdded($cartId, $productId)) {
        $newQuantity = getCartProductQuantity($cartId, $productId);
        $newQuantity = $newQuantity - $quantity;
        $query = 'UPDATE cartproduct SET quantity="' . $newQuantity . '" WHERE cartId = "' . $cartId . '" AND productId = "' . $productId . '"';
        $wrapper->executeUpdate($query);
    }
}

function alreadyAdded($cartId, $productId)
{
    $wrapper = new dbWrapper();

    $query = 'SELECT * from cartproduct WHERE cartId="' . $cartId . '" AND productId="' . $productId . '"';

    $result = $wrapper->executeSingleRowQuery($query);
    $count = count($result);

    if ($count === 0) {
        return false;
    } else if ($count > 1) {
        return 'Please contact your administrator';
    } else if ($count === 1) {
        return true;
    }
}

function getCartProductQuantity($cartId, $productId)
{
    $wrapper = new dbWrapper();

    $query = 'SELECT quantity FROM cartproduct WHERE cartId="' . $cartId . '" AND productId="' . $productId . '"';

    $result = $wrapper->executeSingleRowQuery($query);
    $count = count($result);

    if ($count === 0) {
        return null;
    } else if ($count > 1) {
        return 'Please contact your administrator';
    } else if ($count === 1) {
        return $result[0]['quantity'];
    }
}

function setItemPrices($cartId, $productId, $price)
{
    $wrapper = new dbWrapper();

    $query = 'UPDATE cartproduct SET itemPrice=' . $price . ' WHERE cartId="' . $cartId . '" AND productId="' . $productId . '" AND quantity>0';
    $wrapper->executeUpdate($query);
}
