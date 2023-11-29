<!DOCTYPE html>
<html>
    <head>
        <title>Manage Product</title>
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
            <h2><i class="fa fa-gear"></i>NHẬP ĐIỂM</h2>
            <form class="form-scorce">
                <div class="container-fluid infor-scorce d-flex">
                    <div class="col-6">
                        <h2>Thông tin chung</h2>
                        <label for="hocky">Học kỳ:</label>
                        <select name="hocky" id="hocky">
                            <option value="1">Học kỳ I 2018-2019</option>
                            <option value="1">Học kỳ II 2018-2019</option>
                        </select><br>
                        <label for="giangvien">Tên giảng viên:</label>
                        <select name="giangvien" id="giangvien">
                            <option value="120120">Trần Văn A</option>
                            <option value="121121">Lê Thị B</option>
                        </select><br>
                        <label for="diem">Nhập file điểm</label>
                        <input type="file" id="diem" name="diem"/>
                        <input type="submit" name="sumit" value="Submit">
                    </div>
                    <div class="col-6">
                        <h2>Thông tin môn học</h2>
                        <label for="nganh">Ngành:</label>
                        <select name="nganh" id="nganh">
                            <option value="cntt">Công nghệ thông tin</option>
                            <option value="ktpm">Kỹ thuật phần mềm</option>
                        </select><br>
                        <label for="hocphan">Học phần:</label>
                        <select name="hocphan" id="hocphan">
                            <option value="120120">Cơ sở dữ liệu nâng cao</option>
                            <option value="121121">Kỹ thuật lập trình</option>
                        </select><br>
                        <label for="hocphan">Nhóm lớp học phần:</label>
                        <select name="lophp" id="lophp">
                            <option value="nhom1">Nhóm 1</option>
                            <option value="121121">Nhóm 2</option>
                        </select><br>
                    </div>
                </div>
            </form>
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