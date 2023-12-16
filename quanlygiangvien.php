<?php 
    require 'ConnectMongoDB.php';

    $resultSet = $collectionGiangVien->find();
    $resultSet1 = $collectionKhoa->find();
    $resultSet2 = $collectionKhoa->find();
    if(isset($_GET['search'])){
        $keyword = $_GET['search'];
        $filter = [
            '$or' => [
                ['TENGV' => new MongoDB\BSON\Regex($keyword)],
                ['MAGV' => $keyword]
            ]
        ];
    $resultSet = $collectionGiangVien->find($filter);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Quản lý giảng viên</title>
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
        <script src="js/QLGV.js"></script>
    </head>
    <body>
        <div class="model-0 hide">
            <div class="model-inner-0">  
                <div class="model-header-0 d-flex">
                    <div class="header-form"><h3>CẬP NHẬT THÔNG TIN</h3></div>
                    <i class="fa fa-window-close"></i>
                </div>
                <div class="model-body-0">
                    <form name="Update" action="UpdateGV.php" method="post" id="form-login" enctype="multipart/form-data" onsubmit="return validateForm();">
                        <input type="hidden" name="magv" id="magv" value="">
                        <label for="name">Họ và  Tên</label><br>
                        <input class="name" type="text" id="name" name="name" value=""><br>
                        <label for="email">Email</label><br>
                        <input class="name" type="text" id="email" name="email" value=""><br>
                        <label for="phone">Số điện thoại</label><br>
                        <input class="name" type="text" id="phone" name="phone" value=""><br>
                        <label for="cars">Khoa</label><br>
                        <select class="name" name="khoa" id="khoa">
                        <?php foreach ($resultSet2 as $data2): ?>
                            <option value="<?php echo $data2['TENKHOA'] ?>"><?php echo $data2['TENKHOA'] ?></option>
                        <?php endforeach; ?>
                        </select>
                        <label for="cars">Trạng Thái</label><br>
                        <select class="name" name="status" id="status">
                            <option value="Ngừng công tác">Ngừng công tác</option>
                            <option value="Hiện diện">Hiện diện</option>
                        </select>
                        <input class="submit" type="submit" value="SUBMIT" name ="submit">
                    </form>
                </div>
            </div>
        </div>
        <div class="model-0 hide" id = "addinfor">
            <div class="model-inner-0">  
                <div class="model-header-0 d-flex">
                    <div class="header-form"><h3>THÊM CÁN BỘ</h3></div>
                    <i class="fa fa-window-close"></i>
                </div>
                <div class="model-body-0">
                    <form name="add" action="AddGV.php" method="post" id="form-login" enctype="multipart/form-data" onsubmit="return validateAddForm();">
                        <label for="name">Họ và  Tên</label><br>
                        <input class="name" type="text" id="addname" name="name" value=""><br>
                        <label for="email">Email</label><br>
                        <input class="name" type="text" id="addemail" name="email" value=""><br>
                        <label for="email">Số điện thoại</label><br>
                        <input class="name" type="text" id="sdt"name="sdt" value=""><br>
                        <label for="email">Ngày sinh</label><br>
                        <input class ="name" type="date" id="birthday" name="birthday" value="2018-07-22"/>
                        <label for="cars">Khoa</label><br>
                        <select class="name" name="khoa" id="status">
                        <?php foreach ($resultSet1 as $data1): ?>
                            <option value="<?php echo $data1['TENKHOA'] ?>"><?php echo $data1['TENKHOA'] ?></option>
                        <?php endforeach; ?>
                        </select>
                        <label for="cars">Giới tính</label><br>
                        <select name="gender" id="gender">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                        <input name ="submit" class="submit" type="submit" value="SUBMIT">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-2 nav float-left">
            <?php include "nav.html" ?>
        </div>
        <div class="col-10" style="margin-left:16.66%">
            <h2><i class="fa fa-gear"></i>THÔNG TIN GIẢNG VIÊN</h2>
            <div class="new-p my-3">
                <a  id="btn-addinfor" href = "#"><i class="fa fa-plus-circle" style="margin-right: 10px;"></i>THÊM MỘT CÁN BỘ</a>   
            </div>
            
            <div class="my-4 sort-search d-flex">     
                <form class="col-4" action="">
                    <div class="search d-flex">
                        <input name="search" type="text" placeholder="&#160;&#160;&#160;Search here" style = "width:100%">     
                        <button type="submit" style="font-size:30px;margin-left:3px; margin-top: auto; margin-bottom:auto;"><span class="material-symbols-outlined">search</span></button>
                    </div>
                </form>  
            </div>

            <div class="container-fluid all-p">
                <div class="container-fluid row-title d-flex my-3">
                    <div class="col-1 text-center title">MAGV</div>
                    <div class="col-3 text-center title">HỌ VÀ TÊN</div>
                    <div class="col-3 text-center title">EMAIL</div>
                    
                    <div class="col-2 text-center title">KHOA</div>
                    <div class="col-2 text-center title">TRẠNG THÁI</div>
                    <div class="col-2 text-center title">ACTION</div>
                </div>
                            
                    <?php
                    
                    foreach ($resultSet as $data): ?>
                        <div class="container-fluid row-product d-flex" onclick="redirectToUpdatePage('<?php echo $data['MAGV']; ?>')">
                            <div class="col-1 text-center title"><?php echo $data['MAGV']; ?></div>
                            <div class="col-3 product"><p><?php echo $data['TENGV']; ?></p></div>
                            <div style ="overflow: auto; overflow-x: hidden; overflow-y: auto;" class="col-3 text-center product"><p><?php echo $data['EMAIL']; ?></p></div>
                            

                            <?php
                            // Truy vấn dữ liệu từ bảng major dựa trên idMajor của giangvien
                            $majorData = $collectionKhoa->findOne(['MAKHOA' => $data['MAKHOA']]);
                            ?>

                            <div class="col-2 text-center product"><p><?php echo $majorData['TENKHOA']; ?></p></div>
                            <div class="col-2 text-center title"><?php echo $data['TRANGTHAI'] ?></div>
                            <div class="col-2 text-center product btn-de-up">
                                <button class="btn but-update" onclick="UpdateGV(this); event.stopPropagation();" name="update" value= "<?php echo $data['MAGV'] ?>" >UPDATE</button>
                                <button class="btn but-update" onclick="Reset('<?php echo $data['MAGV'] ?>'); event.stopPropagation();" name="reset"  >RESET</button>
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
