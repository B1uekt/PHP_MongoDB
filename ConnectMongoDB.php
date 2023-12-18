<?php 
    require 'vendor/autoload.php';

    use MongoDB\Client;
    
    $mongoUri = "mongodb://localhost:27017";
    
    $client = new Client($mongoUri);
    
    
    $database = $client->selectDatabase('quanlysinhvien'); 
    $collectionLop = $database->selectCollection('lop');
    $collectionNganh = $database->selectCollection('nganh');
    $collectionKhoa = $database->selectCollection('khoa');
    $collectionNienkhoa = $database->selectCollection('nienkhoa');
    $collectionGiangVien = $database->selectCollection('giangvien');
    $collectionSinhVien = $database->selectCollection('sinhvien');
    $collectionHP = $database->selectCollection('hocphan');
	$collectionKQ = $database->selectCollection('ketqua');
	$collectionHK = $database->selectCollection('hocky');
    $collectionNHP = $database->selectCollection('nhomhocphan');
    $collectionDamNhiem = $database->selectCollection('damnhiem');
?>