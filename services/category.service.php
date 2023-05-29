<?php
require_once '../models/category.php';
require_once '../helpers/dbWrapper.php';

$categoryMessage = '';


function getCategories()
{
    $wrapper = new dbWrapper();

    $categories = [];

    $query = `SELECT * FROM category`;
    $result = $wrapper->executeQuery($query);

    for ($i = 0; $i < count($result); $i++) {
        $category = new Category();
        $category->categoryId = $result[$i]['categoryId'];
        $category->categoryName = $result[$i]['categoryName'];

        $categories[$i] = $category;
    }

    return $categories;
}

function updateCategory()
{
    $wrapper = new dbWrapper();

    $categoryName = $_POST['category'];
    $categoryId = $_POST['categoryId'];

    $updateQuery = `UPDATE category SET categoryName="$categoryName" WHERE categoryId="$categoryId"`;
    $insertQuery = `INSERT INTO category(categoryName) values("$categoryName")`;


    if (isset($categoryName)) {
        if (isset($categoryId) && $categoryId > 0) {
            $wrapper->executeUpdate($updateQuery);
            $categoryMessage = 'Category \'' . $_POST['category'] . '\' updated successfully';
        } else {
            $wrapper->executeUpdate($insertQuery);
            $categoryMessage = 'Category \'' . $_POST['category'] . '\' added successfully';
        }
    }
}
