<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/product.php';
require_once 'serialNumber.service.php';

function getProducts()
{
    $wrapper = new dbWrapper();

    $products = [];

    $query = `SELECT * FROM product`;
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

function getProductById()
{
    $wrapper = new dbWrapper();
    $products = getProducts();
    $product = new Product();

    $id = $_POST['productId'];
    
    if (isset($id)) {
        $getProductQuery = `SELECT * FROM product WHERE ProductId="$id"`;
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

    $query = `SELECT * FROM product NATURAL JOIN serialnumber WHERE status="available"`;
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

$isSuccessAdding = '';
$isSuccessAddingSerials = '';

function addProduct()
{
    $wrapper = new dbWrapper();
    $product = new Product();

    $product->categoryId = $_POST['category'];
    $product->productName = $_POST['productName'];
    $product->description = $_POST['description'];
    $product->price = $_POST['price'];
    $product->quantityAvailable = $_POST['quantity'];

    if (isset($product->quantityAvailable)) {
        if (!empty($_FILES['thumbnail']['name'])) {
            $destination = '../uploads/Thumbnails/' . $_FILES['thumbnail']['name'];
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $destination)) {
                echo '<script>alert("Successful");</script>';
            } else {
                echo '<script>alert("Failed");</script>';
            }
        } else {
            echo '<script>alert("false");</script>';
        }
    }

    $addProductQuery = `
    INSERT INTO product(categoryId,productName,description,price,quantityAvailable,thumbnail) 
        VALUES(` . "$product->categoryId" . `, ` . "$product->productName" . `,` . "$product->description" . `,
        ` . "$product->quantityAvailable" . `,"$destination" )`;
    $id = '';

    $id = $wrapper->executeQueryAndReturnId($addProductQuery);

    for ($i = 0; $i < $product->quantityAvailable; $i++) {
        addSerialNumber($id, $_POST['serial' . ($i + 1)]);
    }
}
