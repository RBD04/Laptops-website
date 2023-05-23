<?php 
require_once('connection.php');

$categoryMessage = '';

$getCategoriesQuery = "SELECT * FROM category";
$categoriesResult = mysqli_query($con, $getCategoriesQuery);
$countCategories = mysqli_num_rows($categoriesResult);

if (isset($_POST) && isset($_POST['category'])) {
    if (isset($_POST['categoryId']) && $_POST['categoryId'] > 0) {
      $updateCategoryQuery = 'UPDATE category SET categoryName="' . $_POST['category'] . '" WHERE categoryId=' . $_POST['categoryId'];
      if (mysqli_query($con, $updateCategoryQuery) === false) die("Error updating category");
      else {
        $categoryMessage = 'Category \'' . $_POST['category'] . '\' updated successfully';
      }
    } else {
      $addCategoryQuery = 'INSERT INTO category(categoryName) values("' . $_POST['category'] . '")';
      if (mysqli_query($con, $addCategoryQuery) === false) die("Error adding category");
      else {
        $categoryMessage = 'Category \'' . $_POST['category'] . '\' added successfully';
      }
    }
  }
?>