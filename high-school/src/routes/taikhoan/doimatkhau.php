<?php
include '../DATABASE/sql.php';

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: dangnhap.php');
    exit();
}

$user_id = intval($_SESSION['user_id']);
$role = $_SESSION['vai_tro'] ?? '';

// Chọn bảng truy vấn dựa trên vai trò
if ($role === 'Admin') {
    $sql = "SELECT ten_dang_nhap, ho_ten, avatar FROM admin WHERE id = ?";
} elseif ($role === 'HocSinh') {
    $sql = "SELECT ten_dang_nhap, ho_ten, gioi_tinh FROM hocsinh WHERE id = ?";
} elseif ($role === 'GiaoVien') {
    $sql = "SELECT ten_dang_nhap, ho_ten, gioi_tinh FROM giaovien WHERE id = ?";
} else {
    // fallback: sử dụng bảng nguoi_dung nếu vai trò không xác định
    $sql = "SELECT ten_dang_nhap, ho_ten, avatar FROM nguoi_dung WHERE id = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Xử lý avatar: Nếu không có avatar từ bảng (Admin có trường avatar) thì đối với HocSinh/GiaoVien
if ($role !== 'Admin') {
    // Nếu có trường gioi_tinh, chọn avatar dựa trên giới tính
    if (isset($user['gioi_tinh'])) {
        if (strtolower($user['gioi_tinh']) === 'nữ') {
            $avatar = "http://localhost/high-school/public/asset/icon/avatar-nu.svg";
        } else {
            $avatar = "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
        }
    } else {
        $avatar = "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
    }
} else {
    $avatar = !empty($user['avatar']) ? $user['avatar'] : "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Cá Nhân</title>
    <link rel="stylesheet" href="http://localhost/high-school/public/css/style.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/gerenal.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/admin.css">
</head>

<body>
    <?php include '../background/header.php'; ?>

    <div>
        <div class="thong-tin-ca-nhan">
            <h2>Thông Tin Cá Nhân</h2>
            <p><b>Tên đăng nhập:</b> <?php echo htmlspecialchars($user['ten_dang_nhap']); ?></p>
            <p><b>Họ tên:</b> <?php echo htmlspecialchars($user['ho_ten']); ?></p>
            <p><b>Vai trò:</b> <?php echo htmlspecialchars($role); ?></p>
            <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" width="100">
            <h3>Đổi Mật Khẩu</h3>
            <form method="POST" class="form-doi-mat-khau">
                <label for="old_password">Mật khẩu cũ:</label>
                <input type="password" name="old_password" required>
                <br>
                <label for="new_password">Mật khẩu mới:</label>
                <input type="password" name="new_password" required>
                <br>
                <label for="confirm_password">Xác nhận mật khẩu mới:</label>
                <input type="password" name="confirm_password" required>
                <br>
                <button type="submit" name="change_password">Đổi mật khẩu</button>
            </form>
        </div>
    </div>

    <?php include '../background/footer.php'; ?>

    <?php
    // Xử lý đổi mật khẩu
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $sql = "SELECT mat_khau FROM nguoi_dung WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (password_verify($old_password, $row['mat_khau'])) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE nguoi_dung SET mat_khau = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $hashed_password, $user_id);
                $stmt->execute();
                $stmt->close();
                echo "<p style='color: green;'>Đổi mật khẩu thành công!</p>";
            } else {
                echo "<p style='color: red;'>Mật khẩu mới không trùng khớp!</p>";
            }
        } else {
            echo "<p style='color: red;'>Mật khẩu cũ không chính xác!</p>";
        }
    }
    ?>
</body>

</html>