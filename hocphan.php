<?php
    require 'vendor/autoload.php';
 
    use MongoDB\Client;     
    $mongoUri = "mongodb://localhost:27017";
    $client = new Client($mongoUri);
    $database = $client->selectDatabase('quanlysinhvien');
    $collection1 = $database->selectCollection('damnhiem');
    $collection2 = $database->selectCollection('hocphan');

    $ID = $_GET['MAGV'];
    $nganh = $collection1->find(['MAGV' => $ID]);
    $in = [];
    foreach ($nganh as $data):
        array_push($in, $data['MAHP']);
    endforeach;
    $hocphan = $collection2->find(['MAHP' => ['$in' => $in]]);
    $resultArray = iterator_to_array($hocphan);
    $jsonResult = json_encode($resultArray);
    echo $jsonResult;
?>