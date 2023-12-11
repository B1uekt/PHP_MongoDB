<?php
    require 'vendor/autoload.php';

    use MongoDB\Client;     
    $mongoUri = "mongodb://localhost:27017";
    $client = new Client($mongoUri);

    $database = $client->selectDatabase('quanlysinhvien');
    $collectionNhp = $database->selectCollection('nhomhocphan');
    $collectionNhp = $database->selectCollection('nhomhocphan');
    $MANHOMHP = $_GET['MANHOMHP'];
    $pipeline = [
        [
            '$match' => [
                "MANHOMHP" =>  $MANHOMHP
            ]
        ],
        [
            '$lookup' => [
                'from' => 'giangvien',
                'localField' => 'MAGV',
                'foreignField' => 'MAGV',
                'as' => 'phancong'
            ]
        ],
        [
            '$unwind' => [
                'path' => '$phancong',
                'preserveNullAndEmptyArrays' => true
            ]
        ],
        [
            '$project' => [
                'MANHOMHP' => '$MANHOMHP',
                'STT' => '$STT', 
                'NGAYBD' => '$NGAYBD', 
                'NGAYKT' => '$NGAYKT', 
                'MAGV' => [
                    '$ifNull' => ['$phancong.MAGV', null]
                ] 
            ]
        ]
    ];
    $document = $collectionNhp->aggregate($pipeline);
    $resultArray = iterator_to_array($document);
    $jsonResult = json_encode($resultArray);
    echo $jsonResult;
?>