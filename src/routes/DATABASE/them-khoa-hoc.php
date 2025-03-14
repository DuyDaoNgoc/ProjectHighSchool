<?php
include '../DATABASE/sql.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $ten_khoahoc    = $_POST['ten_khoahoc'];
    $hinh_anh       = $_POST['hinh_anh'];
    $cap_hoc        = $_POST['cap_hoc'];
    $gia_tien       = $_POST['gia_tien'];
    $thoi_gian_hoc  = $_POST['thoi_gian_hoc'];
    $hinh_thuc_hoc  = $_POST['hinh_thuc_hoc'];

    
    $dsn = 'mysql:host=localhost;dbname=truonghoc';
    $username = 'root';
    $password = '';

    try {
      
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     
        $sql = "INSERT INTO khoahoc (ten_khoahoc, hinh_anh, cap_hoc, gia_tien, thoi_gian_hoc, hinh_thuc_hoc) 
                VALUES (:ten_khoahoc, :hinh_anh, :cap_hoc, :gia_tien, :thoi_gian_hoc, :hinh_thuc_hoc)";
        $stmt = $pdo->prepare($sql);

        
        $stmt->bindParam(':ten_khoahoc', $ten_khoahoc);
        $stmt->bindParam(':hinh_anh', $hinh_anh);
        $stmt->bindParam(':cap_hoc', $cap_hoc);
        $stmt->bindParam(':gia_tien', $gia_tien);
        $stmt->bindParam(':thoi_gian_hoc', $thoi_gian_hoc);
        $stmt->bindParam(':hinh_thuc_hoc', $hinh_thuc_hoc);

        
        $stmt->execute();

        $thongbao = "Thêm khoá học thành công!";
    } catch (PDOException $e) {
        $thongbao = "Lỗi: " . $e->getMessage();
    }
}
?>