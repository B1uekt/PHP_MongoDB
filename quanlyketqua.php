<!DOCTYPE html>
<html>
<?php
    require 'vendor/autoload.php';
 
    use MongoDB\Client;     
    $mongoUri = "mongodb://localhost:27017";
    $client = new Client($mongoUri);
    $database = $client->selectDatabase('quanlysinhvien');
    $collection1 = $database->selectCollection('nganh');
    $collection2 = $database->selectCollection('giangvien');
    $collection3 = $database->selectCollection('hocky');
    $document1 = $collection1->find();
    $document2 = $collection2->find();
    $document3 = $collection3->find();

?>
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
        <!--Link JS-->
        <script src="js/ajax.js"></script>
    </head>
    <body>
        <div class="col-2 nav float-left">
            <?php include "nav.html" ?>
        </div>
        <div class="col-10" style="margin-left:16.66%">
            <h2><i class="fa fa-gear"></i>NHẬP ĐIỂM</h2>
            <form class="form-scorce" method="POST" enctype ="multipart/form-data" action="themketqua.php">
                <div class="container-fluid infor-scorce d-flex">
                    <div class="col-6">
                        <h2>Thông tin chung</h2>
                        <label for="hocky">Học kỳ:</label>
                        <select name="hocky" id="hocky" required>
                        <option value="">Chọn học kỳ</option>
                        <?php foreach ($document3 as $data): ?>
                            <option value=<?php echo $data['MAHK']; ?>><?php echo $data['TENHK']; ?></option>
                        <?php endforeach; ?>
                        </select><br>
                        <label for="giangvien">Tên giảng viên:</label>
                        <select name="giangvien" id="giangvien" onchange = "getHP(this,'MAGV','hocphan.php')"  required>
                        <option value="">Chọn giảng viên</option>
                        <?php foreach ($document2 as $data): ?>
                            <option value=<?php echo $data['MAGV']; ?>><?php echo $data['TENGV']; ?></option>
                        <?php endforeach; ?>
                        </select><br>
                        <label for="diem">Nhập file điểm</label>
                        <input type="file" id="diem" name="diem" required/>
                        <input type="submit" name="submit" value="Submit">
                    </div>
                    <div class="col-6">
                        <h2>Thông tin môn học</h2>
                        <label for="hocphan">Học phần:</label>
                        <select name="hocphan" id="hocphan" onchange = "getNHP(this,'MAHP','nhomhocphan.php')">
                            <option value="">Chọn học phần</option>
                        </select><br>
                        <label for="hocphan">Nhóm lớp học phần</label>
                        <select name="lophp" id="lophp">
                            <option value="">Chọn nhóm học phần</option>
                        </select><br>
                    </div>
                </div>
            </form>
        </div>
    </body>
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
    </script>
</html>