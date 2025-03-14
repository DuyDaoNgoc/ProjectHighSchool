<?php
session_start();
require '../DATABASE/sql.php';

// Kiểm tra đăng nhập: nếu chưa có user_id hoặc vai trò không có thì chuyển về đăng nhập
if (!isset($_SESSION['user_id']) || !isset($_SESSION['vai_tro'])) {
    header("Location: ../taikhoan/dangnhap.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);
$vai_tro = $_SESSION['vai_tro'];

// Lấy thông tin cơ bản từ bảng nguoi_dung (bao gồm họ tên)
$sql = "SELECT ho_ten FROM nguoi_dung WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($ho_ten);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Cá Nhân - Trường Học ND</title>
    <link rel="stylesheet" href="http://localhost/high-school/public/css/style.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/gerenal.css">
    <style>
    .dashboard {
        width: 90%;
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .dashboard h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .dashboard p {
        text-align: center;
        font-size: 1.1em;
    }

    .function-list {
        list-style: none;
        padding: 0;
        text-align: center;
        margin-top: 20px;
    }

    .function-list li {
        margin: 10px 0;
    }

    .function-list li a {
        text-decoration: none;
        font-size: 1.2em;
        color: #4285F4;
        padding: 10px 20px;
        border: 1px solid #4285F4;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .function-list li a:hover {
        background-color: #4285F4;
        color: #fff;
    }
    </style>
</head>

<body>
    <?php include '../background/header.php'; ?>

    <div class="dashboard">
        <h1>Chào mừng, <?php echo htmlspecialchars($ho_ten); ?></h1>
        <p>Vai trò: <?php echo htmlspecialchars($vai_tro); ?></p>
        <ul class="function-list">
            <?php if ($vai_tro === 'HocSinh'): ?>
            <li><a href="../sinhvien/xem_diem.php">Xem điểm</a></li>
            <li><a href="../taikhoan/thongtin_ca_nhan.php">Thông tin cá nhân</a></li>
            <li><a href="../taikhoan/dangxuat.php">Đăng xuất</a></li>
            <?php elseif ($vai_tro === 'GiaoVien'): ?>

            <li><a href="../giaovien/bang_ghi_diem.php">Bảng ghi điểm</a></li>

            <?php elseif ($vai_tro === 'QuanTri'): ?>
            <li><a href="../quantri/quan_ly_he_thong.php">Quản lý hệ thống</a></li>
            <li><a href="../quantri/tao_lop.php">Tạo lớp</a></li>

            <?php else: ?>
            >
            <?php endif; ?>
        </ul>
    </div>

    <?php include '../background/footer.php'; ?>
</body>

</html>