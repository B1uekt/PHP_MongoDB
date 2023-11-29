<!DOCTYPE html>
<html>
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
    </head>
    <body>
        <div class="model-0 hide" id = "addinfor">
            <div class="model-inner-0">  
                <div class="model-header-0 d-flex">
                    <div class="header-form"><h3>THÊM HỌC PHẦN</h3></div>
                    <i class="fa fa-window-close"></i>
                </div>
                <div class="model-body-0">
                    <form>
                        <label for="name">Tên học phần</label><br>
                        <input class="name" type="text" id="name" name="name" value=""><br>
                        <label for="email">Số tính chỉ</label><br>
                        <input class="name" type="text" id="email" name="email" value=""><br>
                        <label for="cars">Trạng thái</label><br>
                        <select name="status" id="status">
                            <option value="dong">Đóng</option>
                            <option value="mo">Mở</option>
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
            <h2><i class="fa fa-gear"></i>QUẢN LÝ HỌC PHẦN</h2>
            
            <div class="new-p my-3">
                <a id="btn-addinfor" href="#"><i class="fa fa-plus-circle" style="margin-right: 10px;"></i>THÊM HỌC PHẦN</a>   
            </div>
            
            <div class="my-4 sort-search d-flex">     
                <form class="col-6" action="">
                    <div class="search d-flex">
                        <input type="text" placeholder="&#160;&#160;&#160;Search here">
                        <select name="nganh" id="nganh">
                            <option value="">Chọn ngành</option>
                            <option value="cntt">CÔng nghệ thông tin</option>
                            <option value="ktpm">Kỹ thuật phần mềm</option>
                            <option value="khmt">Khoa học máy tính</option>
                        </select>     
                        <button type="submit"><span class="material-symbols-outlined">search</span></button>
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
                <div class="conatiern-fluid row-order d-flex">
                    <div class="col-2 text-center product"><p>812063</p></div>
                    <div class="col-2 text-center product"><p>Cơ sở dữ liệu nâng cao</p></div>
                    <div class="col-2 text-center product"><p>3</p></div>
                    <div class="col-2 text-center product"><p>None</p></div>
                    <div class="col-2 text-center product"><p>20</p></div>
                    <div class="col-2 text-center order btn-de-up">
                        <!--<button class="btn but-update">UPDATE</button>-->
                        <a href="" onclick="YesorNo()"  class="btn but-update ">MỞ</a>
                    </div>
                </div>
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

            function OnSubmit(){
                confirm("Do you agree to change this information?");
            }
            function YesorNo(){
                confirm('DO YOU WANT TO DELETE THIS USER ?')
            }
        </script>
    </body>
</html>