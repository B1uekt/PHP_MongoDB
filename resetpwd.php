<?php
require 'ConnectMongoDB.php';

if(isset($_GET['magv'])){
    $MaGV = $_GET['magv'];
    $result = $collectionGiangVien->updateOne(['MAGV' => $MaGV], ['$set' => ['MATKHAU' => 'password123']]);
    header("Location: quanlygiangvien.php");
    exit();
}
else if(isset($_GET['masv'])){
    $MaSV = $_GET['masv'];
    $result = $collectionSinhVien->updateOne(['MASV' => $MaSV], ['$set' => ['MATKHAU' => 'password123']]);
    header("Location: quanlysinhvien.php");
    exit();
}
?>