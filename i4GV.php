<?php 
require 'ConnectMongoDB.php';


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
