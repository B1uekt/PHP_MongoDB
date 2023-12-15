<?php 
require 'ConnectMongoDB.php';

$MaClass = $_GET['MaClass'];

$ClassInfo = $collectionLop->findOne(['MALOP' => $MaClass]);
if ($ClassInfo) {

    $branchInfo = $collectionNganh->findOne(['MANGANH' => $ClassInfo['MANGANH']]);
    $gvInfo = $collectionGiangVien->findOne(['MAGV' => $ClassInfo['COVAN']]);
    $nkInfo = $collectionNienkhoa->findOne(['MANK' => $ClassInfo['MANK']]);


    $result = [
        'MALOP' => $MaClass,
        'TENLOP' => $ClassInfo['TENLOP'],
        'TENNGANH' => $branchInfo['TENNGANH'],
        'TENCOVAN' =>$gvInfo['TENGV'],
        'TENNIENKHOA' => $nkInfo['TENNIENKHOA'],
    ];

    echo json_encode($result);
}
?>