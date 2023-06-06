<?php
require_once '../helpers/dbWrapper.php';
require_once 'cart.service.php';
require_once '../models/delivery.php';

function getAllDeliveriesFullInfo(){
    
}


function getAllDeliveries(){
    $wrapper=new dbWrapper();

    $query='SELECT * FROM delivery';

    $results = $wrapper->executeQuery($query);

    $deliveries = [];

    if (!empty($results)) {
        foreach ($results as $result) {
            $delivery = new Delivery();
            $delivery->deliveryId = isset($result['deliveryId']) ? $result['deliveryId'] : null;
            $delivery->cartId = isset($result['cartId']) ? $result['cartId'] : null;
            $delivery->userId = isset($result['userId']) ? $result['userId'] : null;
            $delivery->deliveryDate = isset($result['deliveryDate']) ? $result['deliveryDate'] : null;
            $delivery->governorate = isset($result['governorate']) ? $result['governorate'] : null;
            $delivery->city = isset($result['city']) ? $result['city'] : null;
            $delivery->street = isset($result['street']) ? $result['street'] : null;
            $delivery->building = isset($result['building']) ? $result['building'] : null;
            $delivery->contactNumber=isset($result['contactNumber']) ? $result['contactNumber'] : null;
            $delivery->paymentStatus = isset($result['paymentStatus']) ? $result['paymentStatus'] : null;
            $delivery->deliveryFees = isset($result['deliveryFees']) ? $result['deliveryFees'] : null;
            $delivery->total = isset($result['total']) ? $result['total'] : null;

            $deliveries[] = $delivery;
        }
        return $deliveries;
    }
}

function setDelivery($cartId,$userId, $governorate, $city, $street, $building,$contactNumber,$address,$price)
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
    $query='INSERT INTO delivery(cartId,userId,governorate,city,street,building,contactNumber,deliveryAddress,paymentStatus,deliveryFees,total)
            VALUES("'.$cartId.'","'.$userId.'","'.$governorate.'","'.$city.'","'.$street.'","'.$building.'","'.$contactNumber.'","'.$address.'","waiting approval","'.$deliveryFees.'","'.$total.'")';
    $wrapper->executeUpdate($query);

}
