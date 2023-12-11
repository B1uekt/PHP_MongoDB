<!DOCTYPE html>
<?php
 session_start();
 require 'vendor/autoload.php';

 use MongoDB\Client;     
 $mongoUri = "mongodb://localhost:27017";
 $client = new Client($mongoUri);

 $database = $client->selectDatabase('quanlysinhvien');
 $collectionNhp = $database->selectCollection('nhomhocphan');
 $collectionHp = $database->selectCollection('hocphan');
 $MAHP = $_GET['MAHP'];
 if(isset($_REQUEST['filter']) && $_REQUEST['filter'] == 'filter'){
    $_SESSION['nhomhocphan'] = $_REQUEST;
    if(!empty($_SESSION['nhomhocphan'])){
        $match = [];
        foreach($_SESSION['nhomhocphan'] as $field => $value){
            if(!empty($value)){
                switch($field){
                    case 'start':
                        $startDate = new MongoDB\BSON\UTCDateTime(strtotime($value.'T00:00:00.000+00:00') * 1000);
                        $match['NGAYBD']['$gte'] = $startDate;
                        break;
                    case 'end':
                        $endDate = new MongoDB\BSON\UTCDateTime(strtotime($value.'T23:59:59.999+00:00') * 1000);
                        $match['NGAYKT']['$lte'] = $endDate;
                        break;
                    case 'manhomhp':
                        $regex = new MongoDB\BSON\Regex($value);
                        $match['MANHOMHP']['$regex'] = $regex;
                        break;
                }
            }
        }
    }
}
$match["MAHP"] = $MAHP;
$pipeline = [
    [
        '$match' => $match
    ],
    [
        '$lookup' => [
            'from' => 'giangvien',
            'localField' => 'MAGV',
            'foreignField' => 'MAGV',
            'as' => 'phancong'
        ]
    ],
    [
        '$unwind' => [
            'path' => '$phancong',
            'preserveNullAndEmptyArrays' => true
        ]
    ],
    [
        '$project' => [
            'MANHOMHP' => '$MANHOMHP',
            'STT' => '$STT', 
            'NGAYBD' => '$NGAYBD', 
            'NGAYKT' => '$NGAYKT', 
            'TENGV' => [
                '$ifNull' => ['$phancong.TENGV', null]
            ]
        ]
    ]
];
$document = $collectionNhp->aggregate($pipeline);
$pipeline2 = [
    [
        '$match' => ['MAHP' => $MAHP]
    ],
    [
        '$lookup' => [
            'from' => 'damnhiem',
            'localField' => 'MAHP',
            'foreignField' => 'MAHP',
            'as' => 'damnhiem'
        ]
    ],
    [
        '$unwind' => '$damnhiem' 
    ],
    [
        '$lookup' => [
            'from' => 'giangvien',
            'localField' => 'damnhiem.MAGV',
            'foreignField' => 'MAGV',
            'as' => 'giangvien'
        ]
    ],
    [
        '$unwind' => '$giangvien' 
    ],
    [
        '$project' => [
            'MAGV' => '$giangvien.MAGV',
            'TENGV' => '$giangvien.TENGV'
        ]
    ]
];
$document1 = $collectionHp->aggregate($pipeline2);
?>
<html>
    <head>
        <title>Nhóm học phần</title>
        <!--CSS link-->
        <link rel="stylesheet" href="css/grid.css">
        <link rel="stylesheet" href="css/stylemanage.css">
        <link rel="stylesheet" href="css/nav.css">
        <!--Font link-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <!--Icon link-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <script src="js/ajax.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    </head>
    <body>
        <div class="model-0 hide">
            <div class="model-inner-0">  
                <div class="model-header-0 d-flex">
                    <div class="header-form"><h3>CẬP NHẬT THÔNG TIN</h3></div>
                    <i class="fa fa-window-close"></i>
                </div>
                <div class="model-body-0">
                    <h3 id = "stt">Nhóm </h3>
                    <form id="formSua">
                        <label for="start">Ngày bắt đầu</label><br>
                        <input class="name" type="date" id="start"  name="start"/><br>
                        <label for="end">Ngày kết thúc</label><br>
                        <input class="name" type="date" id="end" name="end"/><br>
                        <label for="giangvien">Giảng viên</label>
                        <select class = "name" name="giangvien" id="giangvien">
                        <option value="">Chọn giảng viên</option>
                        <?php foreach ($document1 as $data): ?>
                            <option value="<?php echo $data['MAGV']; ?>"><?php echo $data['TENGV']; ?></option>
                        <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="MANHOMHP" name="MANHOMHP"/>
                        <button class="submit" type="button" onclick="changeData('formSua','suanhomhocphan.php')">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="model-0 hide" id = "addinfor">
            <div class="model-inner-0">  
                <div class="model-header-0 d-flex">
                    <div class="header-form"><h3>MỞ NHÓM HỌC PHẦN</h3></div>
                    <i class="fa fa-window-close"></i>
                </div>
                <div class="model-body-0">
                    <form id="formThem">
                        <label for="amount">Số lượng nhóm học phần</label><br>
                        <input class="name" type="amount" name="amount" value=""><br>
                        <label for="start">Ngày bắt đầu</label><br>
                        <input class="name" type="date"  name="start"/><br>
                        <label for="start">Ngày kết thúc</label><br>
                        <input class="name" type="date"  name="end"/><br>
                        <input type="hidden" name="mahp" value = "<?php echo $_GET['MAHP']; ?>">
                        <button class="submit" type="button" onclick="changeData('formThem','themnhomhocphan.php')">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="model-0 hide" id="thoiKB">
            <div class="model-inner-0">  
                <div class="model-header-0 d-flex">
                    <div class="header-form"><h3>TẠO THỜI KHÓA BIỂU</h3></div>
                    <i class="fa fa-window-close"></i>
                </div>
                <div class="model-body-0">
                    <form id="formTKB">
                        <div id="scheduleItems">
                                <div class="date">
                                    <label for="day">Ngày</label>
                                    <select class="select" id="day" name="day[]" required>
                                        <option value="">Chọn ngày</option>
                                        <option value="Thứ 2">Thứ 2</option>
                                        <option value="Thứ 3">Thứ 3</option>
                                        <option value="Thứ 4">Thứ 4</option>
                                        <option value="Thứ 5">Thứ 5</option>
                                        <option value="Thứ 6">Thứ 6</option>
                                        <option value="Thứ 7">Thứ 7</option>
                                    </select><br>
                                    <label for="time">Thời gian học</label>
                                    <input class="name" type="text" id="time" name="time[]" placeholder="Học tiết..." required>
                                </div>
                        </div>
                        <input type="hidden" id ="manhomhp" name="MANHOMHP" value="">
                        <button class="addscheduleitem" type="button" onclick="addScheduleItem()">Thêm mục học</button>
                        <button class="submit" onclick="changeData('formTKB','lapthoikhoabieu.php')" type="button">SUBMIT</button>
                    </form> 
                </div>
            </div>
        </div>
        <div class="col-2 nav float-left">
            <?php include "nav.html" ?>
        </div>
        <div class="col-10" style="margin-left:16.66%">
            <h2><i class="fa fa-gear"></i>NHÓM HỌC PHẦN</h2>
            <div class="new-p my-3">
                <a  id="btn-addinfor" href = "#"><i class="fa fa-plus-circle" style="margin-right: 10px;"></i>MỞ NHÓM HỌC PHẦN</a>   
            </div>
            
            <div class="my-4 sort-search d-flex">     
                <form class="col-5" name="formLoc" onsubmit= "return validateDate();">
                    <div class="search d-flex">
                        <input type="text" name="manhomhp" placeholder="&#160;&#160;&#160;Search here" style = "width:90%">
                        <label for="start"  style="margin-left:3px; margin-top: auto; margin-bottom:auto;">From</label>
                        <input class="name" type="date" name="start"/>
                        <label for="end" style="margin-left:3px; margin-top: auto; margin-bottom:auto;">To</label>
                        <input class="name" type="date" name="end"/>
                        <input type="hidden" name="MAHP" value = "<?php echo $_GET['MAHP']; ?>">
                        <button type="submit" name="filter" value="filter" style="font-size:30px;margin-left:3px; margin-top: auto; margin-bottom:auto;"><span class="material-symbols-outlined">search</span></button>
                    </div>
                </form>  
            </div>

            <div class="container-fluid all-p">
                <div class="container-fluid row-title d-flex my-3">
                    <div class="col-2 text-center title">MÃ NHP</div>
                    <div class="col-3 text-center title">NGÀY BD</div>
                    <div class="col-3 text-center title">NGÀY KT</div>
                    <div class="col-2 text-center title">GIẢNG VIÊN</div>
                    <div class="col-2 text-center title">ACTION</div>
                </div>
                <?php foreach ($document as $data): 
                     $starDate = $data['NGAYBD']->toDateTime(); 
                     $starDate = $starDate->format('d-m-Y');

                     $endDate = $data['NGAYKT']->toDateTime(); 
                     $endDate = $endDate->format('d-m-Y');
                ?>
                <div class="conatiern-fluid row-product d-flex">
                    <div class="col-2 text-center product"><p><?php echo $data['MANHOMHP'] ?></p></div>
                    <div class="col-3 text-center product"><p><?php echo $starDate ?></p></div>
                    <div class="col-3 text-center product"><?php echo $endDate ?></div>
                    <div class="col-2 text-center product"><p><?php echo $data['TENGV'] ?></p></div>
                    <div class="col-2 text-center product btn-de-up">
                        <button  class="btn but-update" onclick = "updateForm(this)" value="<?php echo $data['MANHOMHP']?>"><span class="material-symbols-outlined">update</span></button>
                        <button  class="btn but-schedule" value="<?php echo $data['MANHOMHP']?>"><span class="material-symbols-outlined">calendar_month</span></button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!--Open Close Model-->
        <script>
            var modal = document.getElementById('addinfor');
            var btn = document.getElementById('btn-addinfor');
            var icon = document.querySelector('#addinfor i');
  
            btn.onclick = function () {
                modal.style.display = 'block';
            };

            icon.onclick = function () {
                modal.style.display = 'none';
            };

           
            var buttonGroups =document.querySelectorAll('.btn-de-up')
            var model0= document.querySelector('.model-0');
            var icon0 = document.querySelector('.model-header-0 i');
            var submit0 = document.querySelector('.submit')
            function toggleCLose1(){
                model0.classList.add('hide');
            }
            buttonGroups.forEach(group => {
                const updateButton = group.querySelector('.but-update');
                 updateButton.addEventListener('click', () => {
                    model0.classList.remove('hide');
                });
            });
            icon0.addEventListener('click',  toggleCLose1);
            submit0.addEventListener('click', toggleCLose1);

            var buttonGroups = document.querySelectorAll('.btn-de-up');
            var model1 = document.querySelector('#thoiKB');
            var icon1 = document.querySelector('#thoiKB i');

            function toggleClose2() {
                model1.classList.add('hide');
            }

            buttonGroups.forEach(group => {
                const scheduleButton = group.querySelector('.but-schedule');
                scheduleButton.addEventListener('click', (event) => {
                    model1.classList.remove('hide');
                    var value = event.currentTarget.value;
                    document.getElementById("manhomhp").value = value; 
                });
            });

            icon1.addEventListener('click',  toggleClose2);
    
        </script>
        <script>
            /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
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

            /*function YesorNo(){
                confirm('DO YOU WANT TO DELETE THIS PRODUCT ?')
            }*/

            function validateDate() {
                const startDate = document.formLoc.start.value;
                const endDate = document.formLoc.end.value;

                if ((startDate === '' && endDate !== '') || (startDate !== '' && endDate === '')) {
                    alert('Please fill both start and end dates.');
                    return false;
                }
            }


            function addScheduleItem() {
                const scheduleItems = document.getElementById('scheduleItems');
                const newItem = document.createElement('div');
                newItem.innerHTML = `
                <div class="date">
                    <label for="day">Ngày:</label>
                    <select class="select" id="day" name="day[]" required>
                        <option value="">Chọn ngày</option>
                        <option value="Thứ 2">Thứ 2</option>
                        <option value="Thứ 3">Thứ 3</option>
                        <option value="Thứ 4">Thứ 4</option>
                        <option value="Thứ 5">Thứ 5</option>
                        <option value="Thứ 6">Thứ 6</option>
                    </select><br>
                    <label for="time">Thời gian học:</label>
                    <input class="name" type="text" id="time" name="time[]" placeholder="Học tiết..." required>
                </div>`;
                scheduleItems.appendChild(newItem);
            }

        </script>
    </body>
</html>
