<?php

function validateCredentials($username, $password)
{
    global $collection;

    ;
    if ($username == 'admin123' && $password == '110297'){
        return true;
    }
    else {
        return false;
    }   
}


if (isset($_POST['submit'])) {

    $username = $_POST['sdt_dn'];
    $password = $_POST['mk_dn'];
    if (validateCredentials($username, $password)) {
        echo('Login successful, redirect to the desired page');
        header('Location: quanlygiangvien.php');
        exit();
    } else {
        echo('sai');
        header('Location: login.php?isWrong=1'); 
        exit();
    }
}
?>
