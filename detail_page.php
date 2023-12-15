<?php 
    require 'ConnectMongoDB.php';

    
	if(isset($_GET['magv'])) {
		$MaGV = $_GET['magv'];
		if(isset($_GET['search'])){
			$keyword = $_GET['search'];
			$resultSet1 = $collectionHP->findOne(['TENHP' => new MongoDB\BSON\Regex($keyword)]);
			$filter = [
				'$and' => [
					['MAHP' => $resultSet1['MAHP']],
					['MAGV' => $MaGV],
				]
			];
			$resultSet = $collectionNHP->find($filter);
		}
		else {
			$resultSet = $collectionNHP->find(['MAGV' => $MaGV]);
		}
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
		<div class="my-4 sort-search d-flex">     
			<form class="col-4" action="">
				<div class="search d-flex">
					<input type="hidden" name="magv" id="masv" value="<?php echo $_GET['magv']?>">
					<input name="search" type="text" placeholder="&#160;&#160;&#160;Search here" style = "width:100%">     
					<button class="icon-search" type="submit" style="background-color: #07689F; font-size:30px;margin-left:3px; margin-top: auto; margin-bottom:auto;"><span class="material-symbols-outlined">search</span></button>
				</div>
			</form>  
		</div>
	<?php }
	else if(isset($_GET['masv'])){ ?>XEM ĐIỂM</h1> 
	<div style="text-align:center" class="my-4 sort-search d-flex">
		<div><p>MÃ SINH VIÊN: <?php echo $_GET['masv']; ?></p></div>
		
		
		
		<div><p>TÊN SINH VIÊN: <?php $SV = $collectionSinhVien->findOne(['MASV' => $_GET['masv']]); 
		echo $SV['HOTEN']?></p></div>
	</div>	
	<?php }?>
    
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
						
						<th><?php 
						$starDate = $data['NGAYBD']->toDateTime(); 
						$starDate = $starDate->format('d-m-Y');
						echo $starDate; ?>
						</th>
						<th><?php 
						$endDate = $data['NGAYKT']->toDateTime(); 
						$endDate = $endDate->format('d-m-Y');
						echo $endDate ?></th>
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
								<th id="diemKTHeader"><?php echo $document['DIEMKT']; ?></th>
								<th id="thiHeader"><?php echo $document['THI'] ?></th>
								<th>
									<a href="#" name="update" onclick="editRow('<?php echo $_GET['masv']; ?>', '<?php echo $document['MANHOMHP']; ?>', '<?php echo $document['DIEMKT']; ?>', '<?php echo $document['THI']; ?>')">Chỉnh sửa</a>
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
<script>
    function editRow(rowId, maNHP, diemKT, thi) {
		var newDiemKT = parseFloat(prompt("Nhập điểm kiểm tra mới:", diemKT));
		var newThi = parseFloat(prompt("Nhập điểm thi mới:", thi));

		if (!isNaN(newDiemKT) && !isNaN(newThi)) {
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "updateData.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function () {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {
						console.log(xhr.responseText); // Xử lý phản hồi thành công
						document.getElementById("diemKTHeader").innerText = newDiemKT;
                    	document.getElementById("thiHeader").innerText = newThi;
					} else {
						console.error("Lỗi: " + xhr.status); // Xử lý lỗi
					}
				}
			};
			xhr.send("rowId=" + encodeURIComponent(rowId) + "&maNHP=" + encodeURIComponent(maNHP) +
				"&newDiemKT=" + encodeURIComponent(newDiemKT) + "&newThi=" + encodeURIComponent(newThi));
		} else {
			console.error("Dữ liệu nhập không hợp lệ. Vui lòng nhập giá trị số hợp lệ.");
		}
	}

</script>
</html>