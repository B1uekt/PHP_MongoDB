<?php
require 'ConnectMongoDB.php';
if (isset($_POST['submit'])) {
    $hocphans = $_POST['hocphans'];
    $magv = $_POST['MAGV'];
    $error = false;
    $arrayTeached = $collectionDamNhiem->find(['MAGV' => $magv]);
    foreach ($arrayTeached as $teached) {
        if (in_array($teached['MAHP'], $hocphans)) {
            echo "<p>Học phần có mã " . $teached['MAHP'] . " đã được giảng dạy</p>";
            $error = true;
        } 
    }
    if($error == true){
        echo"<a href = \"quanlygiangvien.php\">Hãy chọn lại học phần</a>";
    }else{
        $documents = [];
        foreach ($hocphans as $index => $hocphan) {

            $document = [
                'MAGV' => $magv,
                'MAHP' => $hocphan
            ];

            $documents[] = $document;
        }
        $collectionDamNhiem->insertMany($documents);
        header("Location: quanlygiangvien.php"); 
        exit();
    }
}
?>