<?php
session_start();
require_once  '../../DATABASE/sql.php'; 

if (!isset($_SESSION['user_id']) || !isset($_SESSION['vai_tro']) || !in_array($_SESSION['vai_tro'], ['Admin', 'GiaoVien'])) {
    header('Location: ../taikhoan/dangnhap.php');
    exit();
}

// Giả sử bạn lấy ID của giáo viên từ $_GET
$giaovien_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($giaovien_id <= 0) {
    echo "<script>alert('ID không hợp lệ!'); window.location.href='../quan-tri/admin.php';</script>";
    exit();
}

$sql = "UPDATE giaovien SET trang_thai = 'Đã duyệt' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $giaovien_id);

if ($stmt->execute()) {
    echo "<script>alert('Phê duyệt giáo viên thành công.'); window.location.href='admin.php';</script>";
} else {
    die("Lỗi khi phê duyệt: " . htmlspecialchars($stmt->error));
}

$stmt->close();
?>