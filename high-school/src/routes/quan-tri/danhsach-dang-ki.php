<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../DATABASE/DataCouser.php';  // Kết nối CSDL

$search_hs = isset($_GET['search_hs']) ? trim($_GET['search_hs']) : "";
$search_param = "%" . $search_hs . "%";

// Truy vấn SQL để lấy danh sách học sinh đăng ký khóa học
$sql = "SELECT hs.id, hs.ho_ten, hs.que_quan, hs.trinh_do_hoc_van, 
               lh.ten_lop, hs.trang_thai, hs.gioi_tinh, hs.ngay_sinh, 
               hs.vai_tro, hs.ten_dang_nhap, kh.ten_khoahoc, kh.cap_hoc, kh.id as khoahoc_id,
               nd.id as id_lien_ket  -- Lấy id từ bảng nguoi_dung
        FROM dangky_khoahoc dk
        JOIN hocsinh hs ON dk.hocsinh_id = hs.id
        JOIN khoahoc kh ON dk.khoahoc_id = kh.id
        LEFT JOIN lophoc lh ON dk.lophoc_id = lh.id
        LEFT JOIN nguoi_dung nd ON nd.ten_dang_nhap = hs.ten_dang_nhap  -- Liên kết với bảng nguoi_dung
        WHERE hs.ho_ten LIKE :search_hs
        ORDER BY hs.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['search_hs' => $search_param]);
$hs_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Giao diện danh sách đăng ký học sinh (Tab 3) -->
<div class="tab-content transform-padding" id="tab3">
    <form method="get" action="">
        <label for="search_hs">Tìm kiếm học sinh</label>
        <input type="text" name="search_hs" id="search_hs" placeholder="Nhập tên học sinh..."
            value="<?php echo htmlspecialchars($search_hs); ?>" class="input-search">
        <button type="submit" class="submit-search">Tìm kiếm</button>
    </form>

    <h2>Danh sách Học sinh đăng ký</h2>
    <table>
        <thead>
            <tr class="table-th">
                <th>ID</th>
                <th>Họ tên</th>
                <th>Quê quán</th>
                <th>Trình độ học vấn</th>
                <th>Lớp</th>
                <th>Tên khóa học</th>
                <th>Trạng thái</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Vai trò</th>
                <th>Cấp học</th>
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
                            <td><a style='text-decoration:none; color:black;' href='../taikhoan/thongtin.php?id=" . urlencode($row['id']) . "'>" . htmlspecialchars($row['ho_ten']) . "</a></td>
                            <td>" . htmlspecialchars($row['que_quan']) . "</td>
                            <td>" . htmlspecialchars($row['trinh_do_hoc_van']) . "</td>
                            <td>" . htmlspecialchars($row['ten_lop'] ?? 'Chưa xếp lớp') . "</td> 
                            <td>" . htmlspecialchars($row['ten_khoahoc']) . "</td>
                            <td>" . htmlspecialchars($row['trang_thai']) . "</td>
                            <td>" . htmlspecialchars($row['gioi_tinh']) . "</td>
                            <td>" . htmlspecialchars($row['ngay_sinh']) . "</td>
                            <td>" . htmlspecialchars($row['vai_tro']) . "</td>
                            <td>" . htmlspecialchars($row['cap_hoc']) . "</td>
                            <td>" . htmlspecialchars($row['ten_dang_nhap']) . "</td>
                           
                            <td class='action-links'>";

                    // Cập nhật các liên kết hành động
                    echo "<a href='../quan-tri/admin-phe-duyet-register.php?id=" . urlencode($row['id_lien_ket']) . "&khoahoc_id=" . urlencode($row['khoahoc_id']) . "'>Phê duyệt</a> ";
                    echo "<a href='tu-choi.php?id=" . urlencode($row['id_lien_ket']) . "&khoahoc_id=" . urlencode($row['khoahoc_id']) . "' onclick='return confirm(\"Bạn có chắc chắn muốn từ chối học sinh này?\");'>Từ chối</a>";
                    echo "<a href='../taikhoan/thongtin.php?id=" . urlencode($row['id']) . "'>Xem</a> ";
                    echo "<a href='../quan-li/sua/suahocsinh.php?id=" . urlencode($row['id']) . "'>Chỉnh sửa</a>";

                    echo "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='13'>Không có học sinh nào đăng ký khóa học.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>