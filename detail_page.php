<?php 
    require 'vendor/autoload.php';

    use MongoDB\Client;
    
    $mongoUri = "mongodb://localhost:27017";
    
    $client = new Client($mongoUri);
    
    
    $database = $client->selectDatabase('ProjectCSDL'); 
	$collectionNHP = $database->selectCollection('nhomhocphan');
	$collectionHP = $database->selectCollection('hocphan');
	$collectionKQ = $database->selectCollection('ketqua');
	$collectionHK = $database->selectCollection('hocky');
	if(isset($_GET['magv'])) {
		$MaGV = $_GET['magv'];
		$resultSet = $collectionNHP->find(['MAGV' => $MaGV]);
	}
	else if(isset($_GET['masv'])) {
		$MaSV = $_GET['masv'];
		$resultSet = $collectionKQ->find(['MASV' => $MaSV]);
		$diemTheoHocKi = [];
		foreach ($resultSet as $document) {
			$maHocKi = $document['MAHK'];
		
			if (!isset($diemTheoHocKi[$maHocKi])) {
				$diemTheoHocKi[$maHocKi] = [];
			}
			if (!in_array($document, $diemTheoHocKi[$maHocKi], true)) {
				$diemTheoHocKi[$maHocKi][] = $document;
			}
		}
	}
?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/styleXSP.css">
<link rel="stylesheet" href="css/stylemanage.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
	<h1 class = "text-center" style="margin: 24px">
	<?php if(isset($_GET['magv'])){ ?> CÁC NHÓM HỌC PHẦN ĐƯỢC PHÂN CÔNG</h1>
	<?php }
	else if(isset($_GET['masv'])){ ?>XEM ĐIỂM</h1> <?php }?>
    <div class="my-4 sort-search d-flex">     
		<form class="col-4" action="">
			<div class="search d-flex">
				<input name="search" type="text" placeholder="&#160;&#160;&#160;Search here" style = "width:100%">     
				<button class="icon-search" type="submit" style="background-color: #07689F; font-size:30px;margin-left:3px; margin-top: auto; margin-bottom:auto;"><span class="material-symbols-outlined">search</span></button>
			</div>
		</form>  
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="detail">
			<?php 
			if(isset($_GET['magv'])) { ?>
			<table style="width:100%" class="table">
					
					<tr id="non-h" style="height: 50px; font-weight: 700;">
						<th style="font-weight: 700">Stt</th>
						<th style="font-weight: 700">Mã nhóm học phần</th>
						<th style="font-weight: 700">Tên học phần</th>
						<th style="font-weight: 700">Số tín chỉ</th>
						<th style="font-weight: 700">Ngày bắt đầu</th>
						<th style="font-weight: 700">Ngày kết thúc</th>
					</tr>
					<tr id="non-j" style="height: 50px; font-weight: 700;">
						<th colspan="6" style="text-align:left">Học kì 1 năm học 2023-2024</th>
					</tr>
					<?php
					$counter = 0;
                    foreach ($resultSet as $data): $counter++; ?>
					
					<tr style="height: 50px">
						<th><?php echo $counter; ?></th>
						<th><?php echo $data['MANHOMHP']; ?></th>
						<?php
                            // Truy vấn dữ liệu từ bảng major dựa trên idMajor của giangvien
                            $HPData = $collectionHP->findOne(['MAHP' => $data['MAHP']]);
                        ?>
						<th><?php echo $HPData['TENHP']; ?></th>
						<th><?php echo $HPData['SOTINCHI']; ?></th>
						<th><?php echo $data['NGAYBD']; ?></th>
						<th><?php echo $data['NGAYKT'] ?></th>
					</tr>
					<?php endforeach; ?>
			</table> <?php }
			else if(isset($_GET['masv'])){?>
				<table style="width:100%; border: 10px solid #f0f0f0" class="table">
					<tr id="non-h" style="height: 50px; font-weight: 700;">
						<th style="font-weight: 700">Stt</th>
						<th style="font-weight: 700">Mã Học Phần</th>
						<th style="font-weight: 700">Tên Học Phần</th>
						<th style="font-weight: 700">Mã Nhóm Học Phần</th>
						<th style="font-weight: 700">Số Tín Chỉ</th>
						<th style="font-weight: 700">Điểm Thi</th>
						<th style="font-weight: 700">Điểm Kiểm Tra</th>
						<th></th>
					</tr>
					<?php 
					foreach ($diemTheoHocKi as $maHocKi => $diemHocKi) { ?>
						<tr id="non-j" style="height: 50px; font-weight: 700;">
							<th colspan="8" style="text-align:left"><?php 
							$HKData = $collectionHK->findOne(['MAHK' => $maHocKi]);
							echo $HKData['TENHK'] ?></th>
						</tr>
						<?php
						$counter = 0;
						foreach ($diemHocKi as $document) {
							$counter++ 
							?>
							<tr style="height: 50px">
								<th><?php echo $counter?></th>
								<th><?php
								$NHP = $collectionNHP->findOne(['MANHOMHP' => $document['MANHOMHP']]); 
								echo $NHP['MAHP']; ?>
								</th>
								<th><?php
								$HPData = $collectionHP->findOne(['MAHP' => $NHP['MAHP']]);  
								echo $HPData['TENHP']; ?></th>
								<th><?php echo $document['MANHOMHP']; ?></th>
								<th><?php echo $HPData['SOTINCHI']; ?></th>
								<th><?php echo $document['DIEMKT']; ?></th>
								<th><?php echo $document['THI'] ?></th>
								<th>
									<a href="#" name="update">Chỉnh sửa</a>
								</th>
						<?php }
					

					}
					?></tr>
					
			</table>
			<?php }?>
			
			</div>
		</div>
	</div>
</body>
</html>