<?php
require 'ConnectMongoDB.php';

$collectionMajor = $database->selectCollection('khoa');

$selectedClass = isset($_POST['selectedClass']) ? $_POST['selectedClass'] : '';

// Sử dụng $selectedBranch trong truy vấn MongoDB của bạn
$temp1 = $collectionLop->findOne(['TENLOP' => $selectedClass]);
$temp2 = $collectionNganh->findOne(['MANGANH' => $temp1['MANGANH']]);
$temp3 = $collectionMajor->findOne(['MAKHOA' => $temp2['MAKHOA']]);
$result = [
    'TENNGANH' => $temp2['TENNGANH'],
    'TENKHOA'=> $temp3['TENKHOA'],
];
echo json_encode($result); 
?>