<?php
$db_hostname = 'localhost';
$db_database = 'laptops-website';
$db_username = 'root';
$db_password = 'root';


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'laptops-website');

$con = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>