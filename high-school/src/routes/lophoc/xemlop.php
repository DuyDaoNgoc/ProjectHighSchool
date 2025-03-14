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

// Lấy thông tin lớp học
$sql = "SELECT id, ten_lop, si_so, so_hoc_sinh_vang, hoc_ky, nam_hoc, nganh, kihoc_id FROM lophoc WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed (lophoc): " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$lophoc = $result->fetch_assoc();
$stmt->close();

if (!$lophoc) {
    die("Không tìm thấy lớp học với ID: " . $id);
}

// Lấy danh sách học sinh trong lớp từ bảng hocsinh thông qua bảng hocsinh_lophoc
$sql2 = "
    SELECT h.id, h.ho_ten, h.que_quan, h.nam_sinh, h.trinh_do_hoc_van, h.trang_thai, h.gioi_tinh, h.ngay_sinh, 
           h.ten_dang_nhap, h.hanh_kiem, h.diem, h.ten_lop, h.nien_khoa, h.nganh
    FROM hocsinh_lophoc hl
    JOIN hocsinh h ON hl.hocsinh_id = h.id
    WHERE hl.lophoc_id = ?
";
$stmt2 = $conn->prepare($sql2);
if (!$stmt2) {
    die("Prepare failed (hocsinh_lophoc): " . $conn->error);
}
$stmt2->bind_param("i", $id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$hocsinh_list = $result2->fetch_all(MYSQLI_ASSOC);
$stmt2->close();

// Cập nhật sĩ số (số học sinh đã được thêm vào lớp)
$si_so = count($hocsinh_list); // Si số bằng số học sinh hiện có trong lớp
$sql_update_si_so = "UPDATE lophoc SET si_so = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update_si_so);
if (!$stmt_update) {
    die("Prepare failed (update si so): " . $conn->error);
}
$stmt_update->bind_param("ii", $si_so, $id);
$stmt_update->execute();
$stmt_update->close();

// Cập nhật ngành học của học sinh trong bảng hocsinh khi học sinh được duyệt vào lớp
foreach ($hocsinh_list as $hs) {
    $sql_update_nganh = "UPDATE hocsinh SET nganh = ? WHERE id = ?";
    $stmt_update_nganh = $conn->prepare($sql_update_nganh);
    if (!$stmt_update_nganh) {
        die("Prepare failed (update nganh): " . $conn->error);
    }
    $stmt_update_nganh->bind_param("si", $lophoc['nganh'], $hs['id']);
    $stmt_update_nganh->execute();
    $stmt_update_nganh->close();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Lớp Học</title>
    <?php include '../DATABASE/body.php'; ?>
    <style>
    .detail-container {
        margin: 20px auto;
        width: 80%;
        background: whitesmoke;
        padding: 20px;
    }

    .detail-container h2 {
        text-align: center;
    }

    .detail-container table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-container table,
    th,
    td {
        border: 1px solid;
    }

    .detail-container th,
    .detail-container td {
        padding: 10px;
        text-align: left;
    }

    .return-link {
        margin: 20px;
        display: inline-block;
    }

    .students-container {
        margin: 20px auto;
        width: 80%;
        background: whitesmoke;
        padding: 20px;
    }

    .students-container h2 {
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid;
    }

    th {
        background-color: #4CAF50;
        color: white;
        text-align: left;
        padding: 12px 15px;
    }

    td {
        padding: 10px;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }
    </style>
</head>

<body>
    <?php include '../background/header.php'; ?>
    <a href="../quan-tri/admin.php" class="return-home"><img
            src="http://localhost/high-school/public/asset/icon/right.svg" alt=""> </a>
    <div class="detail-container">
        <h2 class="bold">Chi Tiết Lớp Học</h2>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($lophoc['id']); ?></td>
            </tr>
            <tr>
                <th>Tên Lớp</th>
                <td><?php echo htmlspecialchars($lophoc['ten_lop']); ?></td>
            </tr>
            <tr>
                <th>Sĩ Số Hiện Tại</th>
                <td><?php echo htmlspecialchars($lophoc['si_so']); ?></td>
            </tr>
            <tr>
                <th>Số Học Sinh Vắng</th>
                <td><?php echo htmlspecialchars($lophoc['so_hoc_sinh_vang']); ?></td>
            </tr>
            <tr>
                <th>Học Kỳ</th>
                <td><?php echo htmlspecialchars($lophoc['hoc_ky']); ?></td>
            </tr>
            <tr>
                <th>Năm Học</th>
                <td><?php echo htmlspecialchars($lophoc['nam_hoc']); ?></td>
            </tr>
            <tr>
                <th>Ngành</th>
                <td><?php echo htmlspecialchars($lophoc['nganh']); ?></td>
            </tr>
            <tr>
                <th>Kỳ Học ID</th>
                <td><?php echo htmlspecialchars($lophoc['kihoc_id']); ?></td>
            </tr>
        </table>
    </div>
    <div class="students-container">
        <h2 class="bold">Danh Sách Học Sinh</h2>
        <?php if (count($hocsinh_list) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ Tên</th>
                    <th>Quê Quán</th>

                    <th>Trình Độ Học Vấn</th>
                    <th>Trạng Thái</th>
                    <th>Giới Tính</th>
                    <th>Ngày Sinh</th>
                    <th>Niên Khóa</th>
                    <th>Ngành</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocsinh_list as $hs): ?>
                <tr>
                    <td><?php echo htmlspecialchars($hs['id']); ?></td>
                    <td><?php echo htmlspecialchars($hs['ho_ten']); ?></td>
                    <td><?php echo htmlspecialchars($hs['que_quan']); ?></td>
                    <td><?php echo htmlspecialchars($hs['trinh_do_hoc_van']); ?></td>
                    <td><?php echo htmlspecialchars($hs['trang_thai']); ?></td>
                    <td><?php echo htmlspecialchars($hs['gioi_tinh']); ?></td>
                    <td><?php echo htmlspecialchars($hs['ngay_sinh']); ?></td>
                    <td><?php echo htmlspecialchars($hs['nien_khoa']); ?></td>
                    <td><?php echo htmlspecialchars($hs['nganh']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Không có học sinh trong lớp này.</p>
        <?php endif; ?>
    </div>
</body>

</html>