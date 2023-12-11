<?php
    require 'vendor/autoload.php';
    require 'Classes/PHPExcel.php';

    use MongoDB\Client;     
    $mongoUri = "mongodb://localhost:27017";
    $client = new Client($mongoUri);
    $database = $client->selectDatabase('quanlysinhvien');
    $collection = $database->selectCollection('ketqua');

    if(isset($_POST['submit'])){
        $file = $_FILES['diem']['tmp_name'];

        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader -> setLoadSheetsOnly('diem');

        $objExcel = $objReader->load($file);
        $sheetData = $objExcel->getActiveSheet()->toArray('null',true,true,true);
        
        $getHighestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
        $documents = [];
        $MAHK = $_POST['hocky'];
        $MANHP = $_POST['lophp'];
        for($row = 2 ; $row <= $getHighestRow ; $row++){
            $document = [
                "MASV" => "".$sheetData[$row]['A'],
                "MAHK" => $MAHK,
                "MANHP" => $MANHP,
                "DIEMKT" => $sheetData[$row]['C'],
                "THI" =>$sheetData[$row]['D']
            ];
            $documents[] = $document;
        }
        $result = $collection->insertMany($documents);
        if ($result > 0) {
            header("Location: quanlyketqua.php");
            exit();
        } else {
            echo "Error";
        }
        $client->close();
    }
    
?>
