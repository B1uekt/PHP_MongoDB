<?php 
require 'vendor/autoload.php';

use MongoDB\Client;
    
$mongoUri = "mongodb://localhost:27017";
    
$client = new Client($mongoUri);
    
$database = $client->selectDatabase('ProjectCSDL'); 
$collectionGiangVien = $database->selectCollection('giangvien');

$MaGV = $_GET['MaGV'];

$giangVienInfo = $collectionGiangVien->findOne(['MAGV' => $MaGV]);
if ($giangVienInfo) {

    $collectionMajor = $database->selectCollection('khoa');
    $majorInfo = $collectionMajor->findOne(['MAKHOA' => $giangVienInfo['MAKHOA']]);


    $result = [
        'MAGV' => $MaGV,
        'TENGV' => $giangVienInfo['TENGV'],
        'EMAIL' => $giangVienInfo['EMAIL'],
        'TRANGTHAI' =>$giangVienInfo['TRANGTHAI'],
        'SDT' => $giangVienInfo['SDT'],
        'MajorName' => $majorInfo['TENKHOA'],

    ];

    echo json_encode($result);
}
?>
