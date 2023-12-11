<?php
require 'vendor/autoload.php';
 
use MongoDB\Client;     
$mongoUri = "mongodb://localhost:27017";
$client = new Client($mongoUri);
$database = $client->selectDatabase('quanlysinhvien');
$collection = $database->selectCollection('buoihoc');

$MANHOMHP = $_POST['MANHOMHP'];
$days = $_POST['day'];
$times = $_POST['time'];

$newDocuments = [];
foreach ($days as $index => $day) {
    if (isset($times[$index])) {
        $time = $times[$index];

        $document = [
            'MANHOMHP' => $MANHOMHP,
            'THU' => $day,
            'TIET' => $time
        ];

        $newDocuments[] = $document;
    }
}

$result = $collection->insertMany($newDocuments);
$resultArray = iterator_to_array($newDocuments);
$jsonResult = json_encode($resultArray);
echo $jsonResult;
?>