<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../DATABASE/sql.php'; 

if (!isset($_SESSION['user_id']) || !isset($_SESSION['vai_tro']) || !in_array($_SESSION['vai_tro'], ['Admin', 'GiaoVien'])) {
    header('Location: ../taikhoan/dangnhap.php');
    exit();
}

include_once '../DATABASE/DataCouser.php';

$search_gv = isset($_GET['search_gv']) ? trim($_GET['search_gv']) : "";
$search_hs = isset($_GET['search_hs']) ? trim($_GET['search_hs']) : "";

$sql_gv = "SELECT g.id, g.ho_ten, g.que_quan, g.nam_sinh, g.chuyen_nganh, g.trinh_do_hoc_van, 
                  g.mat_khau, g.trang_thai, g.vai_tro, g.gioi_tinh, nd.ten_dang_nhap
           FROM giaovien g
           JOIN nguoi_dung nd ON g.id = nd.id_lien_ket
           WHERE g.vai_tro = 'GiaoVien'";
if (!empty($search_gv)) {
    $sql_gv .= " AND g.ho_ten LIKE :search_gv";
}
$stmt_gv = $pdo->prepare($sql_gv);
if (!empty($search_gv)) {
    $stmt_gv->bindValue(':search_gv', '%' . $search_gv . '%', PDO::PARAM_STR);
}
$stmt_gv->execute();
$gv_data = $stmt_gv->fetchAll(PDO::FETCH_ASSOC);

$sql_hs = "SELECT id, ho_ten, que_quan, nam_sinh, trinh_do_hoc_van, lop_id, mat_khau, trang_thai, gioi_tinh, ngay_sinh, vai_tro, ten_dang_nhap 
           FROM hocsinh";
if (!empty($search_hs)) {
    $sql_hs .= " WHERE ho_ten LIKE :search_hs";
}
$stmt_hs = $pdo->prepare($sql_hs);
if (!empty($search_hs)) {
    $stmt_hs->bindValue(':search_hs', '%' . $search_hs . '%', PDO::PARAM_STR);
}
$stmt_hs->execute();
$hs_data = $stmt_hs->fetchAll(PDO::FETCH_ASSOC);

if (!isset($courses)) {
    $courses = [];
}

$demDaiHoc = count(array_filter($courses, function($course) {
    return $course['cap_hoc'] === 'Đại học';
}));
$demThacSi = count(array_filter($courses, function($course) {
    return $course['cap_hoc'] === 'Thạc sĩ';
}));

if (!isset($demTienSi)) {
    $demTienSi = 0;
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang Quản Trị</title>
    <?php include '../DATABASE/body.php' ?>
</head>

<body>
    <?php include '../background/header.php'; ?>

    <nav class="style-container">
        <h1 class="bold">Quản trị</h1>
        <ul class="tabs">
            <li data-tab="tab1" class="active">Giáo viên</li>
            <li data-tab="tab2">Học sinh</li>
            <li data-tab="tab3">Danh sách học sinh đăng kí </li>
            <li data-tab="tab4">Danh sách lớp học </li>
        </ul>

        <div class="tab-content active transform-padding" id="tab1">
            <form method="get" action="">
                <label for="search_gv">Tìm kiếm giáo viên</label>
                <input type="text" name="search_gv" id="search_gv" placeholder="Nhập tên giáo viên..."
                    value="<?php echo htmlspecialchars($search_gv); ?>" class="input-search">
                <button type="submit" class="submit-search">Tìm kiếm</button>
            </form>
            <!-- Danh sách Giáo viên -->
            <h2>Danh sách Giáo viên</h2>
            <table>
                <thead>
                    <tr class="table-th">
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Quê quán</th>
                        <th>Năm sinh</th>
                        <th>Chuyên ngành</th>
                        <th>Trình độ học vấn</th>
                        <th>Trạng thái</th>
                        <th>Vai trò</th>
                        <th>Giới tính</th>
                        <th>Tên đăng nhập</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (!empty($gv_data)) {
                        foreach ($gv_data as $row) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['id']) . "</td>
                                    <td>" . htmlspecialchars($row['ho_ten']) . "</td>
                                    <td>" . htmlspecialchars($row['que_quan']) . "</td>
                                    <td>" . htmlspecialchars($row['nam_sinh']) . "</td>
                                    <td>" . htmlspecialchars($row['chuyen_nganh']) . "</td>
                                    <td>" . htmlspecialchars($row['trinh_do_hoc_van']) . "</td>
                                    <td>" . htmlspecialchars($row['trang_thai']) . "</td>
                                    <td>" . htmlspecialchars($row['vai_tro']) . "</td>
                                    <td>" . htmlspecialchars($row['gioi_tinh']) . "</td>
                                    <td>" . htmlspecialchars($row['ten_dang_nhap']) . "</td>
                                    <td class='action-links'>";
                            if (strtolower($row['trang_thai']) === 'chờ duyệt') {
                                echo "<a href='../quan-li/pheduyet/pheduyet-giaovien.php?id=" . urlencode($row['id']) . "'>Phê duyệt</a>";
                            }
                            echo "<a href='../xemthongtin/XemThongTinGiaoVien.php?id=" . urlencode($row['id']) . "'>Xem</a>";
                            echo "<a href='../quan-li/sua/chinh_sua_giao_vien.php?id=" . urlencode($row['id']) . "'>Chỉnh sửa</a>";
                            echo "<a href='../quan-li/xoa/xoagiaovien.php?id=" . urlencode($row['id']) . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa giáo viên này?\");'>Xóa</a>";
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>Không có giáo viên nào.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="tab-content transform-padding" id="tab2">
            <form method="get" action="">
                <label for="search_hs">Tìm kiếm học sinh</label>
                <input type="text" name="search_hs" id="search_hs" placeholder="Nhập tên học sinh..."
                    value="<?php echo htmlspecialchars($search_hs); ?>" class="input-search">
                <button type="submit" class="submit-search">Tìm kiếm</button>
            </form>
            <!-- Danh sách Học sinh -->
            <h2>Danh sách Học sinh</h2>
            <table>
                <thead>
                    <tr class="table-th">
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Quê quán</th>
                        <th>Trình độ học vấn</th>
                        <th>Lớp</th>
                        <th>Trạng thái</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Vai trò</th>
                        <th>Tên đăng nhập</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (!empty($hs_data)) {
                        foreach ($hs_data as $row) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['id']) . "</td>
                                    <td>" . htmlspecialchars($row['ho_ten']) . "</td>
                                    <td>" . htmlspecialchars($row['que_quan']) . "</td>
                                    <td>" . htmlspecialchars($row['trinh_do_hoc_van']) . "</td>
                                    <td>" . htmlspecialchars($row['lop_id']) . "</td>
                                    <td>" . htmlspecialchars($row['trang_thai']) . "</td>
                                    <td>" . htmlspecialchars($row['gioi_tinh']) . "</td>
                                    <td>" . htmlspecialchars($row['ngay_sinh']) . "</td>
                                    <td>" . htmlspecialchars($row['vai_tro']) . "</td>
                                    <td>" . htmlspecialchars($row['ten_dang_nhap']) . "</td>
                                    <td class='action-links'>";
                          
                            echo "<a href='../taikhoan/thongtin.php?id=" . urlencode($row['id']) . "'>Xem</a>";
                            echo "<a href='../quan-li/sua/suahocsinh.php?id=" . urlencode($row['id']) . "'>Chỉnh sửa</a>";
                            echo "<a href='../quan-li/xoa/xoahocsinh.php?id=" . urlencode($row['id']) . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa học sinh này?\");'>Xóa</a>";

                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>Không có học sinh nào.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php 
        
        include 'danhsach-dang-ki.php';
        
        ?>
        <?php include '../lophoc/DanhSachLop.php' ?>
    </nav>

    <script>
    // JavaScript chuyển đổi tab
    const tabs = document.querySelectorAll('.tabs li');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const activeTab = this.getAttribute('data-tab');
            document.getElementById(activeTab).classList.add('active');
        });
    });
    </script>

    <?php include '../background/footer.php'; ?>
</body>

</html>