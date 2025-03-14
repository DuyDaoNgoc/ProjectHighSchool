<?php
require_once '../DATABASE/sql.php';

if (isset($_GET['id']) && isset($_GET['khoahoc_id'])) {
    $hocsinh_id = intval($_GET['id']);
    $khoahoc_id = intval($_GET['khoahoc_id']);
    $ngay_tu_choi = date("Y-m-d H:i:s"); // Lấy thời gian hiện tại

    // Truy vấn để lấy dữ liệu từ bảng `dangky_khoahoc`
    $sql_select = "SELECT hocsinh_id, khoahoc_id, ten_khoahoc FROM dangky_khoahoc WHERE hocsinh_id = ? AND khoahoc_id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("ii", $hocsinh_id, $khoahoc_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $data = $result->fetch_assoc();
    $stmt_select->close();

    if ($data) {
        // Chèn dữ liệu vào bảng `dangky_bituchoi`
        $sql_insert = "INSERT INTO dangky_bituchoi (hocsinh_id, khoahoc_id, ten_khoahoc, ngay_tu_choi)
                       VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iiss", $data['hocsinh_id'], $data['khoahoc_id'], $data['ten_khoahoc'], $ngay_tu_choi);

        if ($stmt_insert->execute()) {
            // Xóa dữ liệu khỏi bảng `dangky_khoahoc`
            $sql_delete = "DELETE FROM dangky_khoahoc WHERE hocsinh_id = ? AND khoahoc_id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("ii", $hocsinh_id, $khoahoc_id);
            $stmt_delete->execute();
            $stmt_delete->close();

            echo "<script>alert('Đã từ chối khóa học của học sinh thành công.'); window.location.href='admin.php';</script>";
        } else {
            die("Lỗi khi chuyển dữ liệu sang bảng từ chối: " . htmlspecialchars($stmt_insert->error));
        }

        $stmt_insert->close();
    } else {
        echo "<script>alert('Không tìm thấy dữ liệu để từ chối.'); window.location.href='admin.php';</script>";
    }
} else {
    echo "<script>alert('Không tìm thấy học sinh hoặc khóa học.'); window.location.href='admin.php';</script>";
}
?>