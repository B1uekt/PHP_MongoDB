<?php
  require 'vendor/autoload.php';
 
  use MongoDB\Client;     
  $mongoUri = "mongodb://localhost:27017";
  $client = new Client($mongoUri);
  $database = $client->selectDatabase('quanlysinhvien');
  $collection = $database->selectCollection('hocphan');

  $count = $collection->countDocuments([]);
  $count = $count + 1;
  $length = strlen(strval($count));

  $TENHP = $_POST['name'];
  $SOTINHCHI = $_POST['amount'];
  $TRANGTHAI = $_POST['status'];
  $MAHP = "HP";
    switch ($length) {
        case 1:
          $MAHP .= "00".$count;
          break;
        case 2:
          $MAHP .= "0".$count;
          break;
        case 3:
          $MAHP .= $count;
          break;
    }
    $newDocument = [
        'MAHP' => $MAHP,
        'TENHP' =>  $TENHP,
        'SOTINCHI' => $SOTINHCHI,
        'TRANGTHAI' => $TRANGTHAI
    ];
     
    $insertOneResult = $collection->insertOne($newDocument);
?>