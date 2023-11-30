<?php
require 'vendor/autoload.php';

use MongoDB\Client;

$mongoUri = "mongodb://localhost:27017";

$client = new Client($mongoUri);


$database = $client->selectDatabase('ProjectCSDL'); 
$collection = $database->selectCollection('giangvien');
$collectionMajor = $database->selectCollection('khoa');
$count = $collection->countDocuments();


function generateIDProductCode() {
    global $count; // Sử dụng biến toàn cục để truy cập $count
    $result = 'GV00' . $count+1 ;
    
    return $result; // Trả về mã đơn hàng ngẫu nhiên
}
if (isset($_POST['submit'])) {
    // Get input values
    $GVID = generateIDProductCode();
    $GVname = $_POST['name'];
    $GVemail = $_POST['email'];
    $GVSDT = $_POST['sdt'];
    $GVbirthday = $_POST['birthday'];
    $GVMajor = $_POST['khoa'];
    $GVgender= $_POST['gender'];
    $majorData = $collectionMajor->findOne(['TENKHOA' => $GVMajor]);
    $data = [
        'MAGV' => $GVID,
        'TENGV' => $GVname,
        'NGAYSINH' => $GVbirthday,
        'GIOITINH' => $GVgender,
        'SDT' => $GVSDT,
        'EMAIL' => $GVemail,
        'MATKHAU' => 'password123',
        'MAKHOA' => $majorData['MAKHOA'],
        'TRANGTHAI' => 'Hiện diện',
    ];
    // Chèn một tài liệu mới vào collection
    $collection->insertOne($data);

    header("Location: quanlygiangvien.php"); // Thay đổi index.php thành trang bạn muốn chuyển hướng sau khi chèn dữ liệu
    exit();
}
?>