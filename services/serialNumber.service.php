<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/serialNumber.php';

function addSerialNumber($productId,$serialNumber){
    $wrapper=new dbWrapper();

    $addSerialQuery='INSERT INTO serialnumber(productId,serialNumber) values("'.$productId.'","'.$serialNumber.'")';

    $wrapper->executeUpdate($addSerialQuery);

}
    
function setSerialReserved($productId){
    $wrapper=new dbWrapper();

    $query='UPDATE serialnumber SET status="reserved" WHERE productId="'.$productId.'" AND status="available" LIMIT 1';

    $wrapper->executeUpdate($query);
}

?>