<?php
    require 'vendor/autoload.php';
 
    use MongoDB\Client;     
    $mongoUri = "mongodb://localhost:27017";
    $client = new Client($mongoUri);
    $database = $client->selectDatabase('quanlysinhvien');
    $collection = $database->selectCollection('nhomhocphan');

    $count = $collection->countDocuments([]);
    $count = $count + 1;
    $length = strlen(strval($count));

    $MANHOMHP = $_POST['MANHOMHP'];
    $NGAYBD = $_POST['start'];
    $NGAYKT = $_POST['end'];
    $MAGV = $_POST['giangvien'];

    $tempstart = new DateTime($NGAYBD);
    $start = $tempstart->format('Y-m-d') . "T00:00:00.000+00:00";
    $startDate = new MongoDB\BSON\UTCDateTime(strtotime($start) * 1000);   
  
    $tempend = new DateTime($NGAYKT);
    $end = $tempend->format('Y-m-d') . "T00:00:00.000+00:00";
    $endDate = new MongoDB\BSON\UTCDateTime(strtotime($end) * 1000); 
      

    $newDocument = []; 
    $filter = ['MANHOMHP' => $MANHOMHP];
    $data = [ '$set' => [
        'NGAYBD' => $startDate,
        'NGAYKT' => $endDate,
        'MAGV' => $MAGV
    ]];
    $updateOneResult = $collection->updateOne($filter, $data);

?>