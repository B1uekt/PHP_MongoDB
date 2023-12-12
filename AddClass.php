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
    $count = $collectionLop->countDocuments();
    function generateIDCode() {
        global $count; // Sử dụng biến toàn cục để truy cập $count
        $result = 'L00' . $count+1 ;
        
        return $result; // Trả về mã đơn hàng ngẫu nhiên
    }

    if (isset($_POST['submit'])) {
        $classID = generateIDCode();
        $className = $_POST['nameClass'];

        $Branchname = $_POST['branch'];
        $Nganh = $collectionNganh -> findOne(['TENNGANH' => $Branchname]);
        $BranchID = $Nganh['MANGANH'];

        $GVname = $_POST['nameCV'];
        $GV = $collectionGiangVien -> findOne(['TENGV' => $GVname]);
        $GVID = $GV['MAGV'];

        $NKname = $_POST['nienkhoa'];
        $NK = $collectionNienkhoa -> findOne(['TENNIENKHOA' => $NKname]);
        $NKID = $NK['MANK'];

        $data = [
            'MALOP' => $classID,
            'TENLOP' => $className,
            'MANGANH' => $BranchID,
            'COVAN' => $GVID,
            'MANK' => $NKID,
        ];
        $collectionLop->insertOne($data);

        header("Location: quanlylop.php");
        exit();
    }
?>