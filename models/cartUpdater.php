<?php 
class cartUpdater{
    public $productId;
    public $quantityToUpdate;

    function __construct($productId,$quantity)
    {
        $this->productId=$productId;
        $this->quantityToUpdate=$quantity;
    }

}