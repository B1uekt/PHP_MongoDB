<?php
require 'ConnectMongoDB.php';
$collection = $database->selectCollection('ketqua');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST["rowId"];
    $maNHP = $_POST["maNHP"];
    $newDiemKT = $_POST["newDiemKT"];
    $newThi = $_POST["newThi"];
    $data = [
        '$set' => [ 
            'DIEMKT' => $newDiemKT,
            'THI' => $newThi,
        ],
    ];
    $condition = [
        'MASV' => $maSV,
        'MANHOMHP' => $maNHP,
        // Thêm các điều kiện khác nếu cần
    ];
    $result = $collection->updateOne($condition, $data);
    //header("Location: quanlygiangvien.php"); 
    //exit();
}
?>