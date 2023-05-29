<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/serialNumber.php';

function addSerialNumber(){
    $wrapper=new dbWrapper();

    $serial=new serialNumber();

    $addSerialQuery=`INSERT INTO serialnumber(productId,serialNumber) values("`.$serial->productId.`","`.$serial->serialNumber.`")`;

    $wrapper->executeUpdate($addSerialQuery);

}
    
?>