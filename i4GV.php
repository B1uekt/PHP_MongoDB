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
    // Lấy thông tin từ bảng major
    $collectionMajor = $database->selectCollection('khoa');
    $majorInfo = $collectionMajor->findOne(['MAKHOA' => $giangVienInfo['MAKHOA']]);

    // Kết hợp thông tin từ cả hai bảng
    $result = [
        'MAGV' => $MaGV,
        'TENGV' => $giangVienInfo['TENGV'],
        'EMAIL' => $giangVienInfo['EMAIL'],
        'TRANGTHAI' =>$giangVienInfo['TRANGTHAI'],
        'SDT' => $giangVienInfo['SDT'],
        'MajorName' => $majorInfo['TENKHOA'],
        // Thêm các trường khác cần lấy từ các bảng khác nếu cần
    ];

    echo json_encode($result);
}
?>
