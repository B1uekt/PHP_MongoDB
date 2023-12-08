<?php 
    require 'vendor/autoload.php';

    use MongoDB\Client;
    
    $mongoUri = "mongodb://localhost:27017";
    
    $client = new Client($mongoUri);
    
    
    $database = $client->selectDatabase('ProjectCSDL'); 
    $collectionSinhVien = $database->selectCollection('sinhvien');
    $collectionLop = $database->selectCollection('lop');
    $collectionNganh = $database->selectCollection('nganh');
    $collectionKhoa = $database->selectCollection('khoa');
    $collectionGiangVien = $database->selectCollection('giangvien');
    $resultSet = $collectionLop->find();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Quản lý sinh viên</title>
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
        
    </head>
    <body>
        <div class="model-0 hide">
            <div class="model-inner-0">  
                <div class="model-header-0 d-flex">
                    <div class="header-form"><h3>CẬP NHẬT THÔNG TIN</h3></div>
                    <i class="fa fa-window-close"></i>
                </div>
                <div class="model-body-0">
                    <form>
                        <label for="name">Họ và  Tên</label><br>
                        <input class="name" type="text" id="name" name="name" value=""><br>
                        <label for="email">Email</label><br>
                        <input class="name" type="text" id="email" name="email" value=""><br>
                        <label for="email">Số điện thoại</label><br>
                        <input class="name" type="text" id="email" name="email" value=""><br>
                        <label for="birthday">Ngày sinh</label><br>
                        <input class ="name" type="date" id="birthday" name="birthday" value="2018-07-22"/>
                        <label for="address">Địa chỉ</label><br>
                        <input class="name" type="text" id="address" name="address" value=""><br>
                        <label for="cars">Giới tính</label><br>
                        <select class="name" name="gender" id="gernder">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select><br>
                        <label for="cars">Trạng thái</label><br>
                        <select class="name" name="status" id="status">
                            <option value="hoan">Hoãn</option>
                            <option value="nghi">Nghĩ Học</option>\
                            <option value="hiendien">Hiện Diện</option>
                        </select>
                        <div class="id-number my-3">
                            <label for="id">MSSV</label><br>
                            <input type="text" name="id" id="id" disabled> 
                        </div>
                        <input class="submit" type="submit" value="SUBMIT">
                    </form>
                </div>
            </div>
        </div>
        <div class="model-0 hide" id = "addinfor">
            <div class="model-inner-0">  
                <div class="model-header-0 d-flex">
                    <div class="header-form"><h3>THÊM SINH VIÊN</h3></div>
                    <i class="fa fa-window-close"></i>
                </div>
                <div class="model-body-0">
                    <form>
                        <label for="name">Họ và Tên</label><br>
                        <input class="name" type="text" id="name" name="name" value=""><br>
                        <label for="email">Email</label><br>
                        <input class="name" type="text" id="email" name="email" value=""><br>
                        <label for="email">Số điện thoại</label><br>
                        <input class="name" type="text" id="email" name="email" value=""><br>
                        <label for="email">Ngày sinh</label><br>
                        <input class ="name" type="date" id="birthday" name="birthday" value="2018-07-22"/>
                        <label for="address">Địa chỉ</label><br>
                        <input class ="name" type="text" id="address" name="address" value=""/>
                        <label for="cars">Giới tính</label><br>
                        <select name="gender" id="gernder">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                        <input class="submit" type="submit" value="SUBMIT">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-2 nav float-left">
            <?php include "nav.html" ?>
        </div>
        <div class="col-10" style="margin-left:16.66%">
            <h2><i class="fa fa-gear"></i>DANH SÁCH CÁC LỚP</h2>
            <div class="new-p my-3">
                <a  id="btn-addinfor" href = "#"><i class="fa fa-plus-circle" style="margin-right: 10px;"></i>THÊM LỚP MỚI</a>   
            </div>
            <div class="my-4 sort-search d-flex">     
                <form class="col-4" action="">
                    <div class="search d-flex">
                        <input type="text" placeholder="&#160;&#160;&#160;Search here" style = "width:100%">     
                        <button type="submit" style="font-size:30px;margin-left:3px; margin-top: auto; margin-bottom:auto;"><span class="material-symbols-outlined">search</span></button>
                    </div>
                </form>  
            </div>

            <div class="container-fluid all-p">
                <div class="container-fluid row-title d-flex my-3">
                    <div class="col-1 text-center title">MÃ LỚP</div>
                    <div class="col-3 text-center title">TÊN LỚP</div>
                    <div class="col-2 text-center title">TÊN NGÀNH</div>
                    <div class="col-2 text-center title">TÊN KHOA</div>
                    <div class="col-2 text-center title">TÊN GVCV</div>
                    <div class="col-2 text-center title">ACTION</div>
                </div>
                <?php foreach ($resultSet as $data): ?>
                        <div class="container-fluid row-product d-flex">
                            <div class="col-1 text-center product"><p><?php echo $data['MALOP']; ?></p></div>
                            <div class="col-3 product"><p><?php echo $data['TENLOP']; ?></p></div>
                            

                            <?php
                            $Nganh = $collectionNganh->findOne(['MANGANH' => $data['MANGANH']]);
                            $Khoa = $collectionKhoa->findOne(['MAKHOA'=> $Nganh['MAKHOA']]);
                            $GiangVien = $collectionGiangVien->findOne(['MAGV' => $data['COVAN']]);
                            ?>

                            <div class="col-2 text-center product"><p><?php echo $Nganh['TENNGANH']; ?></p></div>
                            <div class="col-2 text-center product"><?php echo $Khoa['TENKHOA']?></div>
                            <div class="col-2 text-center product"><?php echo $GiangVien['TENGV']; ?></div>
                            <div class="col-2 text-center product btn-de-up">
                                <button class="btn but-update">UPDATE</button>
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
            var submit = document.querySelector('#addinfor .model-body-0 .submit')
            // Khi người dùng click vào nút, mở modal
            btn.onclick = function () {
                modal.style.display = 'block';
            };

            icon.onclick = function () {
                modal.style.display = 'none';
            };

            submit.onclick = function () {
                modal.style.display = 'none';
            };
            

            var buttonGroups =document.querySelectorAll('.btn-de-up')
            var model0= document.querySelector('.model-0');
            var icon0 = document.querySelector('.model-header-0 i');
            var submit0 = document.querySelector('.submit')
            function toggleCLose2(){
                model0.classList.add('hide');
            }
            buttonGroups.forEach(group => {
                const updateButton = group.querySelector('.but-update');
                 updateButton.addEventListener('click', () => {
                    model0.classList.remove('hide');
                });
            });
            icon0.addEventListener('click',  toggleCLose2);
            submit0.addEventListener('click', toggleCLose2);
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

            
        </script>
    </body>
</html>