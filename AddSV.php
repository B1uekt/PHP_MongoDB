<?php

require 'ConnectMongoDB.php';


$collection = $database->selectCollection('sinhvien');
$collectionClass = $database->selectCollection('lop');
$count = $collection->countDocuments();
function generateStudentID($chuoi_nam_hoc, $count) {

    $nam_hoc_arr = explode('-', $chuoi_nam_hoc);

    $nam_bat_dau_hoc = $nam_hoc_arr[0];

    $nam_bat_dau_2_chu_so_cuoi = substr($nam_bat_dau_hoc, -2);
    
    $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}41";
    if($count <8){
        $count++;
        $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}41000".$count;
    }
    else if($count > 8 && $count < 98){
        $count++;
        $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}4100".$count;
    }
    else if($count > 98 && $count < 998){
        $count++;
        $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}410".$count;
    }
    else{
        $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}41".$count;
    }
    
    return $ma_sinh_vien;
}

if (isset($_POST['submit'])) {
    // Get input values
    
    $SVname = $_POST['name'];

    $SVbirthday = $_POST['birthday'];

    $SVClass = $_POST['class'];

    $SVgender= $_POST['gender'];

    $SVaddress = $_POST['address'];

    $temp = $collectionClass->findOne(['TENLOP' => $SVClass]);
    $result = $collectionNienkhoa->findOne(['MANK' => $temp['MANK']]);

    $newStudentID = generateStudentID($result['TENNIENKHOA'], $count);
    var_dump($newStudentID);
    $classData = $collectionClass->findOne(['TENLOP' => $SVClass]);
    $data = [
        'MASV' => $newStudentID,
        'HOTEN' => $SVname,
        'GIOITINH' => $SVgender,
        'NGAYSINH' => $SVbirthday,
        'DIACHI' => $SVaddress,
        'MATKHAU' => 'password123',
        'TRANGTHAI' => 'Hiện diện',
        'MALOP' => $classData['MALOP'], 
    ];
    $collection->insertOne($data);
    header("Location: quanlysinhvien.php"); // Thay đổi index.php thành trang bạn muốn chuyển hướng sau khi chèn dữ liệu
    exit();
}



?>
