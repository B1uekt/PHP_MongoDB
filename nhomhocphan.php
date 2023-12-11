<?php
    require 'vendor/autoload.php';
 
    use MongoDB\Client;     
    $mongoUri = "mongodb://localhost:27017";
    $client = new Client($mongoUri);
    $database = $client->selectDatabase('quanlysinhvien');
    $collection = $database->selectCollection('nhomhocphan');

    $ID = $_GET['MAHP'];
    $nhomhocphan = $collection->find(["MAHP" => $ID]);
    $resultArray = iterator_to_array($nhomhocphan);
    $jsonResult = json_encode($resultArray);
    echo $jsonResult;
?>