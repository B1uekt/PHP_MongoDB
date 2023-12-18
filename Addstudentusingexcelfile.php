<?php 
require 'ConnectMongoDB.php';
require 'Classes/PHPExcel.php';

$collection = $database->selectCollection('sinhvien');
$collectionClass = $database->selectCollection('lop');
$count = $collection->countDocuments();
function getRandomClass($classList)
{
    $randomIndex = array_rand($classList);
    return $classList[$randomIndex];
}
function generateStudentID($chuoi_nam_hoc, $count) {

    $nam_hoc_arr = explode('-', $chuoi_nam_hoc);

    $nam_bat_dau_hoc = $nam_hoc_arr[0];

    $nam_bat_dau_2_chu_so_cuoi = substr($nam_bat_dau_hoc, -2);
    
    $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}41";
    if($count <9){
        $count++;
        $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}41000".$count;
    }
    else if($count >= 9 && $count < 99){
        $count++;
        $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}4100".$count;
    }
    else if($count >= 99 && $count < 998){
        $count++;
        $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}410".$count;
    }
    else{
        $ma_sinh_vien = "31{$nam_bat_dau_2_chu_so_cuoi}41".$count;
    }
    
    return $ma_sinh_vien;
}
if (isset($_POST['submit'])) {
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($_FILES["file"]["size"] > 5000000) {
        echo "File của bạn quá lớn. Chỉ cho phép tải lên file có kích thước tối đa 5MB.";
        $uploadOk = 0;
    }

    if ($fileType != "xls" && $fileType != "xlsx") {
        echo "Chỉ cho phép tải lên file Excel.";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        echo "Không thể tải lên file của bạn.";
    } else {
        
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            echo "File " . basename($_FILES["file"]["name"]) . " đã được tải lên thành công.";
            
            try {
                $objReader = PHPExcel_IOFactory::createReaderForFile($targetFile);
                $objReader->setLoadSheetsOnly('CNTT');
                $objExcel = $objReader->load($targetFile);
                $sheetData = $objExcel->getActiveSheet()->toArray(null, true, true, true);
                
                //print_r($sheetData);
                $getHighestRow = $objExcel->setActiveSheetIndex()->getHighestRow();

                $classList = $collectionClass->distinct('TENLOP');

                $className =  getRandomClass($classList);
                //var_dump($className);
                $documents = [];
                $flag = 1;
                echo($getHighestRow);
                for ($row = 2; $row <= $getHighestRow; $row++) {
                    //echo ($flag);
                    //echo($getHighestRow);
                    $tenNK = $sheetData[$row]['D'];
                    $cursor = $collectionNienkhoa->findOne(['TENNIENKHOA' =>  $tenNK]);
                    //var_dump($cursor);
                    if ($cursor) {
                        //var_dump($cursor);
                        $tenNganh = $sheetData[$row]['C'];
                        $cursor1 = $collectionNganh->findOne(['TENNGANH' =>  $tenNganh]);
                
                        if ($cursor1) {
                            $filter = [
                                '$and' => [
                                    ['MANGANH' => ['$regex' => $cursor1['MANGANH']]],
                                    ['MANK' => ['$regex' => $cursor['MANK']]]
                                ]
                            ];
                            
                            $classList = $collectionClass->findOne($filter);
                            if ($classList) {
                                $className = getRandomClass([$classList['TENLOP']]);
                                //echo "Lớp ngẫu nhiên: " . $className;
                                $cursor2 = $collectionLop->findOne(['TENLOP' =>  $className]);
                                $count = $collection->countDocuments();
                                $document = [
                                    "MASV" => generateStudentID($tenNK, $count),
                                    "HOTEN" => $sheetData[$row]['A'],
                                    "GIOITINH" => $sheetData[$row]['E'],
                                    "NGAYSINH" => $sheetData[$row]['B'],
                                    "DIACHI" => $sheetData[$row]['F'],
                                    "MATKHAU" => "password123",
                                    "TRANGTHAI" => "Hiện diện",
                                    "MALOP" => $cursor2['MALOP']
                                ];
                                //var_dump($document['MASV']);
                                $collectionSinhVien->insertOne($document);
                                //var_dump($flag);
                            } else {
                                $flag = 0;
                                
                                //echo "Không tìm thấy lớp phù hợp. \n";
                                echo"<h3>Error</h3>";
                                echo '<p style="color: red; font-size: 24px;">Không thể tìm thấy lớp hợp điều kiện ở dòng' . $row. " \n </p>";
                            }
                        } else {
                            $flag = 0;
                           //echo ($flag);
                            echo"<h3>Error</h3>";
                            echo '<p style="color: red; font-size: 24px;">Không tìm thấy dữ liệu cho tên ngành là: ' . $tenNganh . ' ở dòng ' . $row . " \n </p>";
                            break;
                        }
                    } else {
                        $flag = 0;
                        //echo ($flag);
                        echo"<h3>Error</h3>";
                        echo '<p style="color: red; font-size: 24px;">Không tìm thấy dữ liệu cho tên niên khóa là: ' . $tenNK . ' ở dòng ' . $row . " \n </p>";

                        
                        break;
                    }
                   
                }
            } catch (Exception $e) {
                
            }
            if($flag==0){
                //header("Location: quanlysinhvien.php?Wrong=1"); 
            }
            else{
                var_dump('đúng');
                header("Location: quanlysinhvien.php");
            }
        } else {
            echo "Có lỗi xảy ra khi tải lên file của bạn.";
        }
    }
    
}

?>
