<?php
include '../DATABASE/sql.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM giao_vien WHERE ma_giao_vien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Xóa thành công!'); window.location.href='giaovien.php';</script>";
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}
?>