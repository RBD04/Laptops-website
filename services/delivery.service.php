<?php
require_once '../helpers/dbWrapper.php';
require_once 'cart.service.php';
require_once '../models/delivery.php';

function setDelivery($cartId,$userId, $governorate, $city, $street, $building,$address,$price)
{
    $wrapper = new dbWrapper();
    $deliveryFees = 0;
    switch ($governorate) {
        case 'Beirout':
            $deliveryFees = 2;
            break;
        case 'Nabatiyeh':
            case 'Jouniyeh':
                case 'Baabda':
            $deliveryFees = 3;
            break;
        case 'Tripoli':
        case 'Bekaa':
            $deliveryFees = 4;
            break;
        case 'Akkar':
        case 'Baalback':
            $deliveryFees = 5;
            break;
    }
    $total=$price-$deliveryFees;
    $query='INSERT INTO delivery(cartId,userId,governorate,city,street,building,deliveryAddress,paymentStatus,deliveryFees,total)
            VALUES("'.$cartId.'","'.$userId.'","'.$governorate.'","'.$city.'","'.$street.'","'.$building.'","'.$address.'","waiting approval","'.$deliveryFees.'","'.$total.'")';
    $wrapper->executeQueryAndReturnId($query);

}
