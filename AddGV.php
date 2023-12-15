<?php
require 'ConnectMongoDB.php';
 
$collection = $database->selectCollection('giangvien');
$collectionMajor = $database->selectCollection('khoa');
$count = $collection->countDocuments();


function generateIDProductCode() {
    global $count; 
    $result = 'GV00' . $count+1 ;
    
    return $result; 
}
if (isset($_POST['submit'])) {
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

    $collection->insertOne($data);

    header("Location: quanlygiangvien.php"); 
    exit();
}
?>