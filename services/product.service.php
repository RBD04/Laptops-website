<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/product.php';
require_once 'serialNumber.service.php';

function getProducts()
{
    $wrapper = new dbWrapper();

    $products = [];

    $query = 'SELECT * FROM product';
    $result = $wrapper->executeQuery($query);

    for ($i = 0; $i < count($result); $i++) {
        $product = new Product();
        $product->ProductId = $result[$i]['ProductId'];
        $product->categoryId = $result[$i]['categoryId'];
        $product->productName = $result[$i]['productName'];
        $product->description = $result[$i]['description'];
        $product->quantityAvailable = $result[$i]['quantityAvailable'];
        $product->thumbnail = $result[$i]['thumbnail'];

        $products[$i] = $product;
    }

    return $products;
}

function getProductById($id)
{
    $wrapper = new dbWrapper();
    $product = new Product();

    if (isset($id)) {
        $getProductQuery = 'SELECT * FROM product WHERE ProductId="' . $id . '"';
        $result = $wrapper->executeQuery($getProductQuery);

        $product->ProductId = $result[0]['ProductId'];
        $product->categoryId = $result[0]['categoryId'];
        $product->productName = $result[0]['productName'];
        $product->description = $result[0]['description'];
        $product->quantityAvailable = $result[0]['quantityAvailable'];
        $product->thumbnail = $result[0]['thumbnail'];
    }

    return $product;
}

function getAvailableProducts()
{
    $wrapper = new dbWrapper();

    $products = [];

    $query = 'SELECT * FROM product NATURAL JOIN serialnumber WHERE status="available"';
    $result = $wrapper->executeQuery($query);

    for ($i = 0; $i < count($result); $i++) {
        $product = new Product();
        $product->ProductId = $result[$i]['ProductId'];
        $product->categoryId = $result[$i]['categoryId'];
        $product->productName = $result[$i]['productName'];
        $product->description = $result[$i]['description'];
        $product->quantityAvailable = $result[$i]['quantityAvailable'];
        $product->thumbnail = $result[$i]['thumbnail'];

        $products[$i] = $product;
    }

    return $products;
}



function addProduct()
{
    $wrapper = new dbWrapper();

    $message='';

    $categoryId = $_POST['category'];
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantityAvailable = $_POST['quantity'];

    if (isset($quantityAvailable)) {
        if (!empty($_FILES['thumbnail']['name'])) {
            $destination = '../uploads/Thumbnails/' . $_FILES['thumbnail']['name'];
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $destination)) {
                $message= 'Product added successfully';
            } else {
                $message= 'File upload error';
            }
            $addProductQuery = 'INSERT INTO product(categoryId,productName,description,price,quantityAvailable,thumbnail)
                                VALUES("'.$categoryId.'","'.$productName.'","'.$description.'","'.$price.'","'.$quantityAvailable.'","'.$destination.'")';
            $id = '';
            $id = $wrapper->executeQueryAndReturnId($addProductQuery);

            for ($i = 0; $i < $quantityAvailable; $i++) {
                addSerialNumber($id, $_POST['serial' . ($i + 1)]);
            }
        } else {
            $message= 'Error adding product';
        }
    }
    return $message;
}
