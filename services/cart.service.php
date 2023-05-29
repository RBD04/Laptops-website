<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/cart.php';

function createCart($id){
    $wrapper=new dbWrapper();

    if(isset($id)){    
        $query=`INSERT INTO cart(userId) VALUES($id)`;
        $wrapper->executeUpdate($query);
    }
    else{
        echo `<script>alert('Error inserting Cart')</script>`;
    }
}