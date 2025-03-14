<?php
session_start();
require_once __DIR__ . '/../DATABASE/DataCouser.php';

// Kiểm tra quyền Admin
if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'Admin') {
    header("Location: ../taikhoan/dangnhap.php");
    exit();
}

$hocsinh_id = isset($_POST['hocsinh_id']) ? intval($_POST['hocsinh_id']) : 0;
$khoahoc_id = isset($_POST['khoahoc_id']) ? intval($_POST['khoahoc_id']) : 0;
$lop_hoc_id = isset($_POST['lop_hoc_id']) ? intval($_POST['lop_hoc_id']) : 0;

if ($hocsinh_id && $khoahoc_id && $lop_hoc_id) {
    try {
        // Bắt đầu giao dịch để đảm bảo tính toàn vẹn của dữ liệu
        $pdo->beginTransaction();

        // Cập nhật trạng thái phê duyệt và lớp học trong bảng dangky_khoahoc
        $sql = "UPDATE dangky_khoahoc 
                SET trang_thai = 'Đã phê duyệt', lophoc_id = :lop_hoc_id 
                WHERE hocsinh_id = :hocsinh_id AND khoahoc_id = :khoahoc_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':lop_hoc_id' => $lop_hoc_id,
            ':hocsinh_id' => $hocsinh_id,
            ':khoahoc_id' => $khoahoc_id
        ]);

        // Cập nhật sĩ số trong bảng lophoc
        $sql = "UPDATE lophoc 
                SET si_so = si_so + 1 
                WHERE id = :lop_hoc_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':lop_hoc_id' => $lop_hoc_id]);

        // Thêm học sinh vào lớp trong bảng trung gian (nếu có)
        // Giả sử bảng trung gian là hocsinh_lophoc với các trường hocsinh_id và lophoc_id
        $sql = "INSERT INTO hocsinh_lophoc (hocsinh_id, lophoc_id) 
                VALUES (:hocsinh_id, :lop_hoc_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':hocsinh_id' => $hocsinh_id,
            ':lop_hoc_id' => $lop_hoc_id
        ]);

        // Commit giao dịch
        $pdo->commit();

        // Redirect back to the admin page with success message
        header("Location: admin.php?message=Đăng ký đã được phê duyệt thành công!");
        exit();
    } catch (PDOException $e) {
        // Rollback nếu có lỗi
        $pdo->rollBack();
        echo "<p style='color: red; text-align: center;'>Lỗi khi phê duyệt: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color: red; text-align: center;'>Thông tin không hợp lệ, vui lòng thử lại.</p>";
}
?>