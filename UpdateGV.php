<?php 
    require 'vendor/autoload.php';

    use MongoDB\Client;
    
    $mongoUri = "mongodb://localhost:27017";
    
    $client = new Client($mongoUri);
    
    
    $database = $client->selectDatabase('ProjectCSDL'); 
    $collectionGiangVien = $database->selectCollection('giangvien');
    $collectionMajor = $database->selectCollection('khoa');
    if (isset($_POST['submit'])) {
        $GVname = $_POST['name'];
        $GVemail = $_POST['email'];
        $GVSDT = $_POST['phone'];
        $GVMajor = $_POST['khoa'];
        $GVstatus = $_POST['status'];
        $majorData = $collectionMajor->findOne(['TENKHOA' => $GVMajor]);
        $GVMajorID = $collectionGiangVien->findOne(['MAKHOA'=> $majorData['MAKHOA']]);

        $data = [
            '$set' => [ // Sử dụng $set để chỉ cập nhật các trường cần thiết
                'TENGV' => $GVname,
                'SDT' => $GVSDT,
                'EMAIL' => $GVemail,
                'MAKHOA' => $GVMajorID['MAKHOA'],
                'TRANGTHAI' => $GVstatus,
            ],
        ];
        $result = $collectionGiangVien->updateOne(['TENGV' => $GVname], $data);
        header("Location: quanlygiangvien.php"); // Thay đổi index.php thành trang bạn muốn chuyển hướng sau khi chèn dữ liệu
        exit();
    }
?>