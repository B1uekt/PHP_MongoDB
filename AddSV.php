<?php

require 'ConnectMongoDB.php';


$collection = $database->selectCollection('sinhvien');
$collectionClass = $database->selectCollection('lop');

function generateStudentID() {
    $prefix = "SV";
    $year = date("y");
    $uniqueNumber = mt_rand(1000, 9999);

    return $prefix . $year . $uniqueNumber;
}

// Kiểm tra tính duy nhất của mã số sinh viên

if (isset($_POST['submit'])) {
    // Get input values
    do {
        $newStudentID = generateStudentID();
        $existingStudent = $collection->findOne(['student_id' => $newStudentID]);
    } while (!empty($existingStudent));
    $SVname = $_POST['name'];
    $SVemail = $_POST['email'];
    $SVbirthday = $_POST['birthday'];
    $SVClass = $_POST['class'];
    $SVgender= $_POST['gender'];
    $SVaddress = $_POST['address'];
    var_dump($SVname);
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
