<?php

include __DIR__ . '/../DATABASE/sql.php';

// Kiểm tra quyền truy cập (chỉ Admin hoặc GiaoVien mới được phép)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['vai_tro']) || !in_array($_SESSION['vai_tro'], ['Admin', 'GiaoVien'])) {
    header('Location: ../taikhoan/dangnhap.php');
    exit();
}



$search_lop = "";
if (isset($_GET['search_lop'])) {
    $search_lop = trim($_GET['search_lop']);
}

// Nếu có từ khóa tìm kiếm, thêm điều kiện WHERE cho câu truy vấn
if ($search_lop !== "") {
    $sql = "SELECT id, ten_lop, si_so, so_hoc_sinh_vang, hoc_ky, nam_hoc, nganh, kihoc_id FROM lophoc WHERE ten_lop LIKE ?";
    $stmt = $conn->prepare($sql);
    $param = "%" . $search_lop . "%";
    $stmt->bind_param("s", $param);
} else {
    $sql = "SELECT id, ten_lop, si_so, so_hoc_sinh_vang, hoc_ky, nam_hoc, nganh, kihoc_id FROM lophoc";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
$lophoc_list = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh Sách Lớp Học</title>
    <?php include '../DATABASE/body.php'; ?>
    <style>
    .table-container {
        margin: 20px auto;
        width: 90%;
        background: whitesmoke;
        padding: 20px;
    }

    .return-home {
        display: inline-block;
        margin: 20px;
        text-decoration: none;
        color: #333;
    }

    .input-search {
        padding: 5px;
        margin: 5px 0;
    }

    .submit-search {
        padding: 5px 10px;
        margin-left: 5px;
    }
    </style>
</head>

<body>
    <div class="tab-content transform-padding" id="tab4">
        <form method="get" action="">
            <label for="search_lop">Tìm kiếm lớp:</label>
            <input type="text" name="search_lop" id="search_lop" placeholder="Nhập tên lớp..."
                value="<?php echo htmlspecialchars($search_lop); ?>" class="input-search">
            <button type="submit" class="submit-search">Tìm kiếm</button>
        </form>
        <h2 class="bold">Danh Sách Lớp Học</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr class="table-th">
                        <th>ID</th>
                        <th>Tên Lớp</th>
                        <th>Sĩ Số</th>
                        <th>Số Học Sinh Vắng</th>
                        <th>Học Kỳ</th>
                        <th>Năm Học</th>
                        <th>Ngành</th>
                        <th>Kỳ Học ID</th>
                        <th>Hành động</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (count($lophoc_list) > 0): ?>
                    <?php foreach ($lophoc_list as $lophoc): ?>
                    <tr>
                        <td><?php echo $lophoc['id']; ?></td>
                        <td><?php echo htmlspecialchars($lophoc['ten_lop']); ?></td>
                        <td><?php echo $lophoc['si_so']; ?></td>
                        <td><?php echo $lophoc['so_hoc_sinh_vang']; ?></td>
                        <td><?php echo htmlspecialchars($lophoc['hoc_ky']); ?></td>
                        <td><?php echo htmlspecialchars($lophoc['nam_hoc']); ?></td>
                        <td><?php echo htmlspecialchars($lophoc['nganh']); ?></td>
                        <td><?php echo $lophoc['kihoc_id']; ?></td>
                        <td class="action-links"><a href="../lophoc/xemlop.php?id=<?php echo $lophoc['id']; ?>">Xem</a>
                            <a href="../lophoc/xoalop.php?id=<?php echo $lophoc['id']; ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xoá lớp này không?');">Xoá</a>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="10">Không có lớp học nào được tạo.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>