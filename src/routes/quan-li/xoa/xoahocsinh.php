<?php
include '../DATABASE/sql.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM hoc_sinh WHERE ma_hoc_sinh = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Xóa thành công!'); window.location.href='admin_hocsinh.php';</script>";
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}
?>