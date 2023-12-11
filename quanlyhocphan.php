<!DOCTYPE html>
<html>
<?php
    session_start();
    require 'vendor/autoload.php';

    use MongoDB\Client;     
    $mongoUri = "mongodb://localhost:27017";
    $client = new Client($mongoUri);

    $database = $client->selectDatabase('quanlysinhvien');
    $collection1 = $database->selectCollection('hocphan');
    $collection2 = $database->selectCollection('nhomhocphan');
    $collection3 = $database->selectCollection('chitietnganh');
    $collection4 = $database->selectCollection('nganh');
    if(isset($_REQUEST['filter']) && $_REQUEST['filter'] == 'filter'){
        $_SESSION['hocphan'] = $_REQUEST;
        if(!empty($_SESSION['hocphan'])){
            $query = [];
            foreach($_SESSION['hocphan'] as $field => $value){
                if(!empty($value)){
                    switch($field){
                        case 'nganh':
                            $nganh = $collection3->find(['MANGANH' => $value]);
                            $in = [];
                            foreach ($nganh as $data):
                                array_push($in, $data['MAHP']);
                            endforeach;
                            $query["MAHP"]['$in'] = $in;
                            break;
                        case 'tenhp':
                            $regex = new MongoDB\BSON\Regex($value);
                            $query["TENHP"]['$regex'] = $regex;
                            break;
                    }
                }
            }
        }
    }
    if(!empty($query)){
        $document = $collection1->find($query);
    }else{
        $document = $collection1->find();
    }
    $all_nganh = $collection4->find();
?>
    <head>
        <title>Quản lý học phần</title>
        <!--CSS link-->
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/grid.css">
        <link rel="stylesheet" href="css/stylemanage.css">
        <!--Font link-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <!--Icon link-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="js/ajax.js"></script>
    </head>
    <body>
        <div class="model-0 hide" id = "addinfor">
            <div class="model-inner-0">  
                <div class="model-header-0 d-flex">
                    <div class="header-form"><h3>THÊM HỌC PHẦN</h3></div>
                    <i class="fa fa-window-close"></i>
                </div>
                <div class="model-body-0">
                    <form id = "formHocphan">
                        <label for="name">Tên học phần</label><br>
                        <input class="name" type="text" id="name" name="name" value=""><br>
                        <label for="amount">Số tính chỉ</label><br>
                        <input class="name" type="text" id="amount" name="amount" value=""><br>
                        <label for="status">Trạng thái</label><br>
                        <select class ="name" name="status" id="status">
                            <option value="Active">Active</option>
                            <option value="Passive">Passive</option>
                        </select>
                        <button class="submit" type="submit" onclick="changeData('formHocphan','themhocphan.php')">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-2 nav float-left">
            <?php include "nav.html" ?>
        </div>
        <div class="col-10" style="margin-left:16.66%">
            <h2><i class="fa fa-gear"></i>QUẢN LÝ HỌC PHẦN</h2>
            
            <div class="new-p my-3">
                <a id="btn-addinfor" href="#"><i class="fa fa-plus-circle" style="margin-right: 10px;"></i>THÊM HỌC PHẦN</a>   
            </div>
            
            <div class="my-4 sort-search d-flex">     
                <form class="col-6" action="">
                    <div class="search d-flex">
                        <input type="text" name="tenhp" placeholder="&#160;&#160;&#160;Search here">
                        <select name="nganh" id="nganh">
                            <option value="">Chọn ngành</option>
                        <?php foreach ($all_nganh as $data): ?>
                            <option value=<?php echo $data['MANGANH']; ?>><?php echo $data['TENNGANH']; ?></option>
                        <?php endforeach; ?>
                        </select>     
                        <button type="submit" value="filter" name="filter"><span class="material-symbols-outlined">search</span></button>
                    </div>
                </form>    
            </div>
            <div class="container-fluid all-p">
                <div class="container-fluid row-title d-flex my-3">
                    <div class="col-2 text-center title">MAHP</div>
                    <div class="col-2 text-center title">Tên học phần</div>
                    <div class="col-2 text-center title">Số tính chỉ</div>
                    <div class="col-2 text-center title">Trạng thái</div>
                    <div class="col-2 text-center title">Số nhóm học phần</div>
                    <div class="col-2 text-center title">ACTION</div>
                </div>
                <?php foreach ($document as $data): ?>
                    <div class="conatiern-fluid row-order d-flex">
                        <div class="col-2 text-center product"><p><?php echo $data['MAHP']; ?></p></div>
                        <div class="col-2 text-center product"><p><?php echo $data['TENHP']; ?></p></div>
                        <div class="col-2 text-center product"><p><?php echo $data['SOTINCHI']; ?></p></div>
                        <div class="col-2 text-center product"><p><?php echo $data['TRANGTHAI']; ?></p></div>
                        <?php
                            // Truy vấn số lượng nhóm lớp học phần
                            $pipeline = [
                                [
                                    '$match' => ['MAHP' => $data['MAHP']] 
                                ],
                                [
                                    '$count' => 'totalRecords' 
                                ]
                            ];
                            $totalRecord = $collection2->aggregate($pipeline)->toArray();
                            if($totalRecord != null){
                        ?>
                            <div class="col-2 text-center product"><p><?php echo $totalRecord[0]->totalRecords; ?></p></div>
                        <?php }else{ ?>
                            <div class="col-2 text-center product"><p>0</p></div>
                        <?php } ?>
                        <div class="col-2 text-center order btn-de-up">
                            <button class="btn but-update" onclick="moHocPhan('<?php echo $data['MAHP']; ?>')">MỞ</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <script>
            function toggleDropdown(){
                var dropdown = document.querySelector('.dropdown-button');
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                } else {
                    dropdown.classList.add('show');
                }
            }
        </script>
        <script>
            var dropdown = document.getElementsByClassName("dropdown-btn");
            var i;
            
            for (i = 0; i < dropdown.length; i++) {
              dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                  dropdownContent.style.display = "none";
                } else {
                  dropdownContent.style.display = "block";
                }
              });
            }

            var modal = document.getElementById('addinfor');
            var btn = document.getElementById('btn-addinfor');
            var icon = document.querySelector('#addinfor i');
           
            btn.onclick = function () {
                modal.style.display = 'block';
            };

            icon.onclick = function () {
                modal.style.display = 'none';
            };

            function moHocPhan(MAHP){
                window.location.href = 'monhomhocphan.php?MAHP='+MAHP;
            }
           
        </script>
    </body>
</html>