<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/user.php';
require_once 'cart.service.php';

function getUsers()
{
    $wrapper = new dbWrapper();

    $getUsersQuery = "SELECT * FROM user";

    $results = $wrapper->executeQuery($getUsersQuery);

    $users = [];

    if (!empty($results)) {
        foreach ($results as $result) {
            $user = new User();
            $user->UserId = isset($result['UserId']) ? $result['UserId'] : null;
            $user->firstName = isset($result['firstName']) ? $result['firstName'] : null;
            $user->lastName = isset($result['lastName']) ? $result['lastName'] : null;
            $user->email = isset($result['email']) ? $result['email'] : null;
            $user->phoneNumber = isset($result['phoneNumber']) ? $result['phoneNumber'] : null;
            $user->birthday = isset($result['birthday']) ? $result['birthday'] : null;
            $user->gender = isset($result['gender']) ? $result['gender'] : null;
            $user->points = isset($result['points']) ? $result['points'] : null;
            $users[] = $user;
        }
        return $users;
    }
}


function validateLogin()
{
    $wrapper = new dbWrapper();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = 'SELECT UserId, firstName, lastName FROM user WHERE email="' . $email . '" AND password="' . $password . '"';
    $result = $wrapper->executeSingleRowQuery($query);
    $count = count($result);

    if ($count === 0) {
        return 'Authentication failed';
    } else if ($count > 1) {
        return 'Please contact your administrator';
    } else if ($count === 1) {
        $_SESSION['user'] = $result[0]['UserId'];
        $_SESSION['name'] = $result[0]['firstName'] . ' ' . $result[0]['lastName'];
        header('Location: ../pages/home.php');
        exit();
    }
}



function signup()
{
    $wrapper = new dbWrapper();
    if (alreadyExists($_POST['email'])) {
        return 'Email not valid! Please use another one';
    } else {
        $firstName = ($_POST['firstName']) ? $_POST['firstName'] : null;
        $lastName = ($_POST['lastName']) ? $_POST['lastName'] : null;
        $email = ($_POST['email']) ? $_POST['email'] : null;
        $phoneNumber = ($_POST['phoneNumber']) ? $_POST['phoneNumber'] : null;
        $password = ($_POST['password']) ? $_POST['password'] : null;
        $birthday = $_POST['birthday'];
        $gender = null;

        if (isset($firstName) && isset($lastName) && isset($email) && isset($phoneNumber) && isset($password)) {
            $query = 'INSERT INTO user(firstName,lastName,email,phoneNumber,password,birthday,gender) 
                VALUES("' . $firstName . '","' . $lastName . '","' . $email . '","' . $phoneNumber . '","' . $password . '",
                "' . $birthday . '","' . $gender . '")';
            echo $query;
            $id = $wrapper->executeQueryAndReturnId($query);
            createCart($id);

            echo '
                <script>
                    alert("You have successfully registred, login now!");
                    window.location="../pages/login.php";
                </script>                        ';
        } else return 'Error creating account';
    }
}

function alreadyExists($email)
{
    $wrapper = new dbWrapper();

    $query = 'SELECT email FROM user WHERE email="' . $email . '"';
    
    $result = $wrapper->executeSingleRowQuery($query);
    
    $count = count($result);
    
    return ($count > 0);
}
