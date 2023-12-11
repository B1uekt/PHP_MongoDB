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

    $SOLUONG = $_POST['amount'];
    $N = intval($SOLUONG);
    $NGAYBD = $_POST['start'];
    $NGAYKT = $_POST['end'];
    $MAHP = $_POST['mahp'];
    $newDocument = []; 

    $tempstart = new DateTime($NGAYBD);
    $start = $tempstart->format('Y-m-d') . "T00:00:00.000+00:00";
    $startDate = new MongoDB\BSON\UTCDateTime(strtotime($start) * 1000);   
  
    $tempend = new DateTime($NGAYKT);
    $end = $tempend->format('Y-m-d') . "T00:00:00.000+00:00";
    $endDate = new MongoDB\BSON\UTCDateTime(strtotime($end) * 1000); 

    for ($i = 1; $i <= $N; $i++) {
        $MANHOMHP = "NH";
        switch ($length) {
            case 1:
            $MANHOMHP .= "00".$count;
            break;
            case 2:
            $MANHOMHP .= "0".$count;
            break;
            case 3:
            $MANHOMHP .= $count;
            break;
        }
    
        $data = [
            'MANHOMHP' => $MANHOMHP,
            'NGAYBD' => $startDate,
            'NGAYKT' => $endDate,
            'MAGV' => null,
            'MAHP' =>  $MAHP
        ];

        $newDocument[] = $data;
        $count++;
        $length = strlen(strval($count));

    } 
    $insertManyResult = $collection->insertMany($newDocument);
?>