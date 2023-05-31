<?php
require_once '../helpers/dbWrapper.php';

function addToCartProduct($cartId, $productId)
{
    $wrapper = new dbWrapper();


    if (alreadyAdded($cartId, $productId)) {
        $newQuantity=getAddToCartProductQuantity($cartId,$productId);
        $newQuantity=$newQuantity+1;
        $query='UPDATE cartproduct SET quantity="'.$newQuantity.'" ';
        $wrapper->executeUpdate($query);
    } else {
        $query = 'INSERT INTO cartproduct(cartId,productId,quantity) VALUES("' . $cartId . '","' . $productId . '",1)';
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

function getAddToCartProductQuantity($cartId,$productId){
    $wrapper=new dbWrapper();

    $query='SELECT quantity FROM cartproduct WHERE cartId="' . $cartId . '" AND productId="' . $productId . '"';
    
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
