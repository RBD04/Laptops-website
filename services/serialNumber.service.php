<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/serialNumber.php';

function addSerialNumber($productId,$serialNumber){
    $wrapper=new dbWrapper();

    $addSerialQuery='INSERT INTO serialnumber(productId,serialNumber) values("'.$productId.'","'.$serialNumber.'")';

    $wrapper->executeUpdate($addSerialQuery);

}
    
function setSerialReserved($productId,$quantity){
    $wrapper=new dbWrapper();

    $query='UPDATE serialnumber SET status="reserved" WHERE productId="'.$productId.'" AND status="available" LIMIT '.$quantity.'';

    $wrapper->executeUpdate($query);
}

function setSerialAvailable($productId,$quantity){
    $wrapper=new dbWrapper();

    $query='UPDATE serialnumber SET status="available" WHERE productId="'.$productId.'" AND status="reserved" LIMIT '.$quantity.'';

    $wrapper->executeUpdate($query);
}

?>