<?php
require 'ConnectMongoDB.php';
$collection = $database->selectCollection('ketqua');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST["rowId"];
    $maNHP = $_POST["maNHP"];
    $newDiemKT = floatval($_POST["newDiemKT"]);
    $newThi = floatval($_POST["newThi"]);
    $data = [
        '$set' => [ 
            'DIEMKT' => $newDiemKT,
            'THI' => $newThi,
        ],
    ];
    $condition = [
        'MASV' => $maSV,
        'MANHOMHP' => $maNHP,
    ];
    $result = $collection->updateOne($condition, $data);
}
?>