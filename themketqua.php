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
        if($sheetData[1]['A'] == 'MSSV' && $sheetData[1]['B'] == 'Tên' && $sheetData[1]['C'] == 'Điểm KT' && $sheetData[1]['D'] == 'Điểm thi'){
            for($row = 2 ; $row <= $getHighestRow ; $row++){
                $document = [
                    "MASV" => "".$sheetData[$row]['A'],
                    "MAHK" => $MAHK,
                    "MANHOMHP" => $MANHP,
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
        }else{
            echo"<h4>Error</h4>";
            echo"<p>File của bạn định dạng không đúng</p>";
            echo"<a href = \"quanlyketqua.php\">Hãy chỉnh sửa lại định dạng tệp theo quy định</a>";
        }
    }  
?>
