<?php
require 'vendor/autoload.php';

use MongoDB\Client;

$mongoUri = "mongodb://localhost:27017";

$client = new Client($mongoUri);


$database = $client->selectDatabase('ProjectCSDL'); 
$collection = $database->selectCollection('taikhoan'); 

function validateCredentials($username, $password)
{
    global $collection;

    // Check if the user exists
    $user = $collection->findOne(['Taikhoan' => $username, 'Matkhau' => $password]);
    if ($user === null) {
        return false;
    }
    else {
        return true;
    }   
    //if ($user) {
        // User exists, check the password
        //if (password_verify($password, $user['password'])) {
            // Password is correct
            //return true;
        //} else {
            // Incorrect password
            //return false;
        //}
    //} else {
        // User does not exist
        //return false;
    //}
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get input values
    $username = $_POST['sdt_dn'];
    $password = $_POST['mk_dn'];
    if (validateCredentials($username, $password)) {
        echo('Login successful, redirect to the desired page');
        // Login successful, redirect to the desired page
        //header('Location: dashboard.php'); // Replace 'dashboard.php' with your actual dashboard page
        exit();
    } else {
        echo('sai');
        //Login failed, redirect back to login page with error parameter
        header('Location: login.php?isWrong=2'); // Change 'login.php' to your login page
        exit();
    }
}
?>
