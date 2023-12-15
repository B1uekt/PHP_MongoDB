<?php 
    require 'ConnectMongoDB.php';

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