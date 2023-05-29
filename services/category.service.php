<?php
require_once '../models/category.php';
require_once '../helpers/dbWrapper.php';

$categoryMessage = '';


function getCategories()
{
    $wrapper = new dbWrapper();
    $categories = [];

    $query = 'SELECT * FROM category';
    $results = $wrapper->executeQuery($query);

    if (!empty($results)) {
        foreach ($results as $result) {
            $category = new Category();
            $category->categoryId = isset($result['categoryId']) ? $result['categoryId'] : null;
            $category->categoryName = isset($result['categoryName']) ? $result['categoryName'] : null;

            $categories[] = $category;
        }
    } else {
        die('Error retrieving categories.');
    }

    return $categories;
}




function updateCategory()
{
    $wrapper = new dbWrapper();

    $categoryName = $_POST['category'];
    $categoryId = $_POST['categoryId'];

    $updateQuery = 'UPDATE category SET categoryName="'.$categoryName.'" WHERE categoryId="'.$categoryId.'"';
    $insertQuery = 'INSERT INTO category(categoryName) values("'.$categoryName.'")';


    if (isset($categoryName)) {
        if (isset($categoryId) && $categoryId > 0) {
            $wrapper->executeUpdate($updateQuery);
            echo 'Category \'' . $categoryName . '\' updated successfully. <br/>';
        } else {
            $wrapper->executeUpdate($insertQuery);
            echo 'Category \'' . $categoryName . '\' added successfully. <br/>';
        }
    }
}

function getCategoryById($id)
{
    $categories = getCategories();

    foreach ($categories as $category) {
        if ($category->categoryId == $id) {
            return $category;
        }
    }

    return null;
}
