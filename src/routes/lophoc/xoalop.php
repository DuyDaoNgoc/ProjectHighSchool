<?php

    session_start();

include __DIR__ . '/../DATABASE/sql.php';


if (!isset($_SESSION['user_id']) || !isset($_SESSION['vai_tro']) || !in_array($_SESSION['vai_tro'], ['Admin', 'GiaoVien'])) {
    header('Location: ../taikhoan/dangnhap.php');
    exit();
}

// Kiểm tra xem có truyền id lớp qua GET hay không
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID lớp không hợp lệ.");
}

$id = intval($_GET['id']);

// Thực hiện xoá lớp (câu lệnh DELETE)
$sql = "DELETE FROM lophoc WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    // Sau khi xoá thành công, chuyển hướng về danh sách lớp
    header("Location: DanhSachLop.php?message=Xoá lớp thành công");
    exit();
} else {
    die("Lỗi khi xoá lớp: " . $conn->error);
}
?>