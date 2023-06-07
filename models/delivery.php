<?php
class Delivery{
    public $deliveryId;
    public $cartId;
    public $userId;
    public $deliveryDate;
    public $governorate;
    public $city;
    public $street;
    public $building;
    public $contactNumber;
    public $paymentStatus;
    public $deliveryFees;
    public $total;
}

class DeliveryProduct extends Delivery{
    public $productId;
    public $categoryId;
    public $productName;
    public $description;
    public $price;
    public $quantityAvailable;
    public $thumbnail;
}