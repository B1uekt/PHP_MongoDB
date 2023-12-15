<?php 
    require 'ConnectMongoDB.php';
    $count = $collectionLop->countDocuments();
    function generateIDCode() {
        global $count; 
        $result = 'L00' . $count+1 ;
        
        return $result; 
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