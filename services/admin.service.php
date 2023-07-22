<?php
require_once '../helpers/dbWrapper.php';
function validateLogin()
{
    $wrapper = new dbWrapper();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = 'SELECT adminId,username FROM admin WHERE username="' . $username . '" AND password="' . $password . '"';
    $result = $wrapper->executeSingleRowQuery($query);
    $count = count($result);

    if ($count === 0) {
        return 'Authentication failed';
    } else if ($count > 1) {
        return 'Please contact your administrator';
    } else if ($count === 1) {
        $_SESSION['admin'] = $result[0]['adminId'];
        $_SESSION['name'] = $result[0]['username'];
        header('Location: ../pages/admin-home.php');
        exit();
    }
}
