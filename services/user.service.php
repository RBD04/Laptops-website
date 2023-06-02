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

function getUserById($id)
{
    $wrapper = new dbWrapper();
    $user = new User();

    if (isset($id)) {
        $query = 'SELECT * FROM user WHERE UserId="' . $id . '"';
        $result = $wrapper->executeQuery($query);

        $user->UserId = $result[0]['UserId'];
        $user->firstName = $result[0]['firstName'];
        $user->lastName = $result[0]['lastName'];
        $user->email = $result[0]['email'];
        $user->birthday = $result[0]['birthday'];
        $user->profilePicture = $result[0]['profilePicture'];
        $user->phoneNumber = $result[0]['phoneNumber'];

        return $user;
    } else $user = null;
    return $user;
}


function validateLogin()
{
    $wrapper = new dbWrapper();
    extract($_POST);

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
        extract($_POST);

        if (isset($firstName) && isset($lastName) && isset($email) && isset($phoneNumber) && isset($password)) {
            $query = 'INSERT INTO user(firstName,lastName,email,phoneNumber,password,birthday) 
                VALUES("' . $firstName . '","' . $lastName . '","' . $email . '","' . $phoneNumber . '","' . $password . '",
                "' . $birthday . '")';
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

function updateUser($id)
{
    $wrapper = new dbWrapper();

    extract($_POST);
    $destination;
    
    if (isset($firstName) && isset($lastName) && isset($email) && isset($phoneNumber)) {
        if (!empty($_FILES['profilePicture']['name'])) {
            
            $destination = '../uploads/ProfilePictures/' . $_FILES['profilePicture']['name'];
            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $destination)) {
                $message = 'Info updated successfully';
            } else {
                $message = 'File upload error';
            }
        }
        $query = 'UPDATE user SET firstName="' . $firstName . '",lastName="' . $lastName . '",email="' . $email . '",phoneNumber="' . $phoneNumber . '",birthday="' . $birthday . '",profilePicture="' . $destination . '" WHERE UserId=' . $id . '';
        $wrapper->executeUpdate($query);
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
