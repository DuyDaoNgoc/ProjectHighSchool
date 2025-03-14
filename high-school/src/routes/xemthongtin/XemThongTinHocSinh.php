<?php
session_start();
require '../DATABASE/sql.php';

if (!isset($_GET['id'])) {
    die("Không có ID học sinh được cung cấp.");
}

$hs_id = intval($_GET['id']);

$sql = "SELECT * FROM hocsinh WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hs_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Học sinh không tồn tại.");
}
$hs = $result->fetch_assoc();
$stmt->close();

// Xử lý avatar: Nếu cột avatar có tồn tại và không rỗng, dùng nó; nếu không, dựa theo giới tính
if (!empty($hs['avatar'])) {
    $avatar = $hs['avatar'];
} else {
    if (isset($hs['gioi_tinh']) && strtolower($hs['gioi_tinh']) === 'nữ') {
        $avatar = "http://localhost/high-school/public/asset/icon/avatar-nu.svg";
    } else {
        $avatar = "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin Học sinh</title>
    <?php include '../DATABASE/body.php'; ?>
    <style>
    .info-container {
        max-width: 600px;
        margin: 20px auto;
        text-align: center;
    }

    .info-container img {
        max-width: 200px;
        border-radius: 50%;
    }
    </style>
</head>

<body>
    <?php include '../background/header.php'; ?>
    <div class="info-container">
        <h1>Thông tin Học sinh</h1>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($hs['id']); ?></p>
        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar của Học sinh">
        <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($hs['ho_ten']); ?></p>
        <p><strong>Quê quán:</strong> <?php echo htmlspecialchars($hs['que_quan']); ?></p>
        <p><strong>Năm sinh:</strong> <?php echo htmlspecialchars($hs['nam_sinh']); ?></p>
        <p><strong>Trình độ học vấn:</strong> <?php echo htmlspecialchars($hs['trinh_do_hoc_van']); ?></p>
        <p><strong>Lớp:</strong> <?php echo htmlspecialchars($hs['ten_lop']); ?></p>
        <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($hs['trang_thai']); ?></p>
        <p><strong>Giới tính:</strong> <?php echo htmlspecialchars($hs['gioi_tinh']); ?></p>
        <p><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($hs['ngay_sinh']); ?></p>
        <p><strong>Tên đăng nhập:</strong> <?php echo htmlspecialchars($hs['ten_dang_nhap']); ?></p>
        <?php if (isset($hs['diem'])): ?>
        <p><strong>Điểm:</strong> <?php echo htmlspecialchars($hs['diem']); ?></p>
        <?php endif; ?>
        <?php if (isset($hs['hanh_kiem'])): ?>
        <p><strong>Hạnh kiểm:</strong> <?php echo htmlspecialchars($hs['hanh_kiem']); ?></p>
        <?php endif; ?>
        <p><a href="sua_hs.php?id=<?php echo urlencode($hs_id); ?>">Chỉnh sửa thông tin</a></p>
    </div>
    <?php include '../background/footer.php'; ?>
</body>

</html>