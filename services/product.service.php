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
        $product->productId = $result[$i]['productId'];
        $product->categoryId = $result[$i]['categoryId'];
        $product->productName = $result[$i]['productName'];
        $product->description = $result[$i]['description'];
        $product->quantityAvailable = $result[$i]['quantityAvailable'];
        $product->thumbnail = $result[$i]['thumbnail'];
        $product->price = $result[$i]['price'];
        $product->dateAdded = $result[$i]['dateAdded'];

        $products[$i] = $product;
    }

    return $products;
}

function getProductById($id)
{
    $wrapper = new dbWrapper();
    $product = new Product();

    if (isset($id)) {
        $getProductQuery = 'SELECT * FROM product WHERE productId="' . $id . '"';
        $result = $wrapper->executeQuery($getProductQuery);

        $product->productId = $result[0]['productId'];
        $product->categoryId = $result[0]['categoryId'];
        $product->productName = $result[0]['productName'];
        $product->description = $result[0]['description'];
        $product->quantityAvailable = $result[0]['quantityAvailable'];
        $product->thumbnail = $result[0]['thumbnail'];
        $product->price = $result[0]['price'];
        $product->dateAdded = $result[$i]['dateAdded'];
    } else $product = null;

    return $product;
}

function getAvailableProducts()
{
    $wrapper = new dbWrapper();

    $products = [];

    $query = "SELECT * FROM product WHERE quantityAvailable > 0";
    $result = $wrapper->executeQuery($query);

    for ($i = 0; $i < count($result); $i++) {
        $product = new Product();
        $product->productId = $result[$i]['productId'];
        $product->categoryId = $result[$i]['categoryId'];
        $product->productName = $result[$i]['productName'];
        $product->description = $result[$i]['description'];
        $product->quantityAvailable = $result[$i]['quantityAvailable'];
        $product->thumbnail = $result[$i]['thumbnail'];
        $product->price = $result[$i]['price'];
        $product->dateAdded = $result[$i]['dateAdded'];

        $products[$i] = $product;
    }

    return $products;
}



function addProduct()
{
    $wrapper = new dbWrapper();

    $message = '';

    $categoryId = $_POST['category'];
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantityAvailable = $_POST['quantity'];

    if (isset($quantityAvailable)) {
        if (!empty($_FILES['thumbnail']['name'])) {
            $destination = '../uploads/Thumbnails/' . $_FILES['thumbnail']['name'];
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $destination)) {
                $message = 'Product added successfully';
            } else {
                $message = 'File upload error';
            }
            $addProductQuery = 'INSERT INTO product(categoryId,productName,description,price,quantityAvailable,thumbnail)
                                VALUES("' . $categoryId . '","' . $productName . '","' . $description . '","' . $price . '","' . $quantityAvailable . '","' . $destination . '")';
            $id = '';
            $id = $wrapper->executeQueryAndReturnId($addProductQuery);
        } else {
            $message = 'Error adding product';
        }
    }
    return $message;
}

function getProductsByCategory($id)
{
    $products = getAvailableProducts();
    $matchingProducts = [];

    foreach ($products as $product) {
        if ($product->categoryId == $id) {
            $matchingProducts[] = $product;
        }
    }

    return $matchingProducts;
}


function updateProductQuantity($productId, $quantity)
{
    $wrapper = new dbWrapper();

    $query = 'UPDATE product SET quantityAvailable="' . $quantity . '" WHERE productId="' . $productId . '" ';

    $wrapper->executeUpdate($query);
}
