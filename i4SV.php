<?php 
require 'vendor/autoload.php';

use MongoDB\Client;
    
$mongoUri = "mongodb://localhost:27017";
    
$client = new Client($mongoUri);
    
$database = $client->selectDatabase('ProjectCSDL'); 
$collectionSinhVien = $database->selectCollection('sinhvien');
$collectionLop = $database->selectCollection('lop');
$collectionNganh= $database->selectCollection('nganh');
$collectionMajor = $database->selectCollection('khoa');
$MaSV = $_GET['MaSV'];

$sinhvienInfo = $collectionSinhVien->findOne(['MASV' => $MaSV]);
if ($sinhvienInfo) {
    $Data = $collectionLop->findOne(['MALOP' => $sinhvienInfo['MALOP']]);
    $Nganh= $collectionNganh->findOne(['MANGANH' => $Data['MANGANH']]);
    $Khoa= $collectionMajor->findOne(['MAKHOA' => $Nganh['MAKHOA']]);
    // Kết hợp thông tin từ cả hai bảng
    $result = [
        'MASV' => $sinhvienInfo['MASV'],
        'TENSV' => $sinhvienInfo['HOTEN'],
        'TENLOP' => $Data['TENLOP'],
        'TENNGANH' =>$Nganh['TENNGANH'],
        'TENKHOA' => $Khoa['TENKHOA'],
        'NGAYSINH' =>$sinhvienInfo['NGAYSINH'],
        'DIACHI' => $sinhvienInfo['DIACHI'],
        'GIOITINH' => $sinhvienInfo['GIOITINH'],
        'TRANGTHAI' => $sinhvienInfo['TRANGTHAI'],
    ];

    echo json_encode($result);
}
?>
