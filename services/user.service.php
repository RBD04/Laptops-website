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
    $results = $wrapper->executeSingleRowQuery($query);
    $count = count($results);

    if ($count === 0) {
        $error_message = 'Authentication failed';
        echo $error_message;
    } else if ($count > 1) {
        $error_message = 'Please contact your administrator';
        echo $error_message;
    } else if ($count === 1) {
        session_start();
        $_SESSION['user'] = $results[0]['UserId'];
        $_SESSION['name'] = $results[0]['firstName'] . ' ' . $results[0]['lastName'];
        header('Location: ../pages/home.php');
        exit();
    }
}



function signup()
{
    $wrapper = new dbWrapper();
    $user = new User();

    $user->firstName = $_POST['firstName'];
    $user->lastName = $_POST['lastName'];
    $user->email = $_POST['email'];
    $user->phoneNumber = $_POST['phoneNumber'];
    $user->password = $_POST['password'];
    $user->birthday = $_POST['birthday'];
    $user->gender = $_POST['gender'];

    if (isset($user->firstName) && isset($user->lastName) && isset($user->email) && isset($user->phoneNumber) && isset($user->password)) {
        $query = `INSERT INTO user(firstName,lastName,email,phoneNumber,password,birthday,gender) 
                VALUES(` . "$user->firstName" . `,` . "$user->lastName" . `,` . "$user->email" . `,` . $user->phoneNumber . `,
                ` . "$user->password" . `,` . "$user->birthday" . `,` . "$user->gender" . `)`;

        $id = $wrapper->executeQueryAndReturnId($query);
    }
    createCart($id);

    echo '
        <script>
          alert("You have successfully registred, login now!");
          window.location="../pages/login.php";
        </script>                        ';
}

function alreadyExists()
{
}
