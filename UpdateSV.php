<?php 
    require 'ConnectMongoDB.php';

    if (isset($_POST['submit'])) {
        $SVID = $_POST['masv'];
        var_dump($SVID);
        $SVName = $_POST['name'];
        $SVClass = $_POST['class'];
        $SVBirthday = $_POST['birthday'];
        $SVAddress = $_POST['address'];
        $SVGender = $_POST['gender'];
        $SVstatus = $_POST['status'];
        $classData = $collectionLop->findOne(['TENLOP' => $SVClass]);

        $data = [
            '$set' => [ // Sử dụng $set để chỉ cập nhật các trường cần thiết
                'HOTEN' => $SVName,
                'GIOITINH' => $SVGender,
                'NGAYSINH' => $SVBirthday,
                'DIACHI' => $SVAddress,
                'TRANGTHAI' => $SVstatus,
                'MALOP' => $classData['MALOP'],
                
            ],
        ];
        $result = $collectionSinhVien->updateOne(['MASV' => $SVID], $data);
        header("Location: quanlysinhvien.php"); 
        exit();
    }
?>