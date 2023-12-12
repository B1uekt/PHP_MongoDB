<?php 
    require 'vendor/autoload.php';

    use MongoDB\Client;
    
    $mongoUri = "mongodb://localhost:27017";
    
    $client = new Client($mongoUri);
    
    
    $database = $client->selectDatabase('ProjectCSDL'); 
    $collectionLop = $database->selectCollection('lop');
    $collectionNganh = $database->selectCollection('nganh');
    $collectionNienkhoa = $database->selectCollection('nienkhoa');
    $collectionGiangVien = $database->selectCollection('giangvien');
    if (isset($_POST['submit'])) {
        $ClassID = $_POST['malop'];
        $nameClass = $_POST['nameClass'];
        $branchName = $_POST['branch'];
        $nameCV = $_POST['nameCV'];
        $nienkhoa = $_POST['nienkhoa'];
        $Branch = $collectionNganh->findOne(['TENNGANH'=> $branchName]);
        $GV = $collectionGiangVien->findOne(['TENGV'=> $nameCV]);
        $NK = $collectionNienkhoa->findOne(['TENNK'=> $nienkhoa]);

        $data = [
            '$set' => [ 
                'TENLOP' => $nameClass,
                'MANGANH' => $Branch['MANGANH'],
                'COVAN' => $GV['MAGV'],
                'MANK' => $NK['MANIENKHOA'],
            ],
        ];
        $result = $collectionLop->updateOne(['MALOP' => $ClassID], $data);
        header("Location: quanlylop.php");
        exit();
    }
?>