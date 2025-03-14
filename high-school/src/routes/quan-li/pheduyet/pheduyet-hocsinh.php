<?php
session_start();
require '../../DATABASE/sql.php';



if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'Admin' &&  $_SESSION['vai_tro'] !== 'GiaoVien') {
    header("Location: ../taikhoan/dangnhap.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Không có ID học sinh để phê duyệt.");
}

$hs_id = intval($_GET['id']);

$sql = "UPDATE hocsinh SET trang_thai = 'Đã duyệt' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hs_id);
$stmt->execute();
$stmt->close();

header("Location: /high-school/src/routes/quan-tri/admin.php");
exit();
?>