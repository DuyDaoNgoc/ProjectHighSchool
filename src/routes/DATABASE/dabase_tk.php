<?php
include '../DATABASE/sql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = trim($_POST['ten'] ?? '');
    $gioi_tinh = $_POST['gioi_tinh'] ?? 'Chưa có giới tính';
    $ngay_sinh = $_POST['ngay_sinh'] ?? '';
    $nam_sinh = (!empty($ngay_sinh) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $ngay_sinh)) ? date('Y', strtotime($ngay_sinh)) : '2000';
    $que_quan = $_POST['que_quan'] ?? '';
    $dien_thoai = $_POST['dien_thoai'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $vai_tro = $_POST['vai_tro'] ?? ''; // Vai trò: Học sinh hoặc Giáo viên
    $tai_khoan = trim($_POST['tai_khoan'] ?? '');
    $mat_khau_plain = $_POST['mat_khau'] ?? '';

    if (empty($tai_khoan) || empty($mat_khau_plain)) {
        die("<script>alert('Tên đăng nhập và mật khẩu không được để trống!'); window.history.back();</script>");
    }
    if (strlen($mat_khau_plain) < 8) {
        die("<script>alert('Mật khẩu phải có ít nhất 8 ký tự!'); window.history.back();</script>");
    }
    $mat_khau = password_hash($mat_khau_plain, PASSWORD_DEFAULT);

    // Kiểm tra tài khoản đã tồn tại chưa
    $sql_check = "SELECT COUNT(*) FROM nguoi_dung WHERE ten_dang_nhap = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $tai_khoan);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        die("<script>alert('Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác!'); window.history.back();</script>");
    }

    $conn->begin_transaction();
    try {
        // Biến lưu ID để liên kết
        $id_lien_ket = 0;

        if ($vai_tro == "HocSinh") {
            $sql_hs = "INSERT INTO hocsinh (ho_ten, gioi_tinh, ngay_sinh, nam_sinh, que_quan, dien_thoai, email, vai_tro, ten_dang_nhap, mat_khau, trang_thai) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active')";
            $stmt_hs = $conn->prepare($sql_hs);
            $stmt_hs->bind_param("ssssssssss", $ten, $gioi_tinh, $ngay_sinh, $nam_sinh, $que_quan, $dien_thoai, $email, $vai_tro, $tai_khoan, $mat_khau);
            $stmt_hs->execute();
            $id_lien_ket = $stmt_hs->insert_id;
            $stmt_hs->close();
        } elseif ($vai_tro == "GiaoVien") {
            $trinh_do = $_POST['trinh_do_hoc_van'] ?? 'Chưa cập nhật';
            $chuyen_nganh = $_POST['chuyen_nganh'] ?? 'Chưa cập nhật';

            $sql_gv = "INSERT INTO giaovien (ho_ten, gioi_tinh, nam_sinh, que_quan, dien_thoai, email, trinh_do_hoc_van, chuyen_nganh, vai_tro, ten_dang_nhap, mat_khau, trang_thai) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active')";
            $stmt_gv = $conn->prepare($sql_gv);
            $stmt_gv->bind_param("sssssssssss", $ten, $gioi_tinh, $nam_sinh, $que_quan, $dien_thoai, $email, $trinh_do, $chuyen_nganh, $vai_tro, $tai_khoan, $mat_khau);
            $stmt_gv->execute();
            $id_lien_ket = $stmt_gv->insert_id;
            $stmt_gv->close();
        }

        // Sau khi có id_lien_ket, thêm vào bảng nguoi_dung
        $sql_nd = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, email, vai_tro, id_lien_ket, ho_ten, sdt) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_nd = $conn->prepare($sql_nd);
        $stmt_nd->bind_param("ssssiis", $tai_khoan, $mat_khau, $email, $vai_tro, $id_lien_ket, $ten, $dien_thoai);
        $stmt_nd->execute();
        $stmt_nd->close();

        $conn->commit();
        echo "<script>alert('Đăng ký thành công!'); window.location.href='../taikhoan/dangnhap.php';</script>";
    } catch (Exception $e) {
        $conn->rollback();
        die("<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); window.history.back();</script>");
    }
}
?>