<?php

ob_start();
session_start();
require '../DATABASE/sql.php'; 

$prefill_loai = isset($_POST['loai_nguoi_dung']) ? htmlspecialchars($_POST['loai_nguoi_dung']) : "";

$login_message = isset($_SESSION['login_message']) ? $_SESSION['login_message'] : "";
unset($_SESSION['login_message']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tai_khoan = trim($_POST['tai_khoan']);
    $mat_khau_plain = trim($_POST['mat_khau']);

    if (empty($tai_khoan) || empty($mat_khau_plain)) {
        $_SESSION['login_message'] = "<div class='login-message error'>Vui lòng nhập tài khoản và mật khẩu!</div>";
        header("Location: ../taikhoan/dangnhap.php");
        exit();
    }

    // Tìm trong bảng nguoi_dung
    $sql = "SELECT id, mat_khau, vai_tro, id_lien_ket FROM nguoi_dung WHERE ten_dang_nhap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tai_khoan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
        $hashed_password = $row['mat_khau'];
        $vai_tro = $row['vai_tro'];
        $id_lien_ket = $row['id_lien_ket'];
    } else {
        // Nếu không tìm thấy trong bảng nguoi_dung, tìm trong bảng admin
        $sql = "SELECT id, mat_khau, 'Admin' AS vai_tro, NULL AS id_lien_ket FROM `admin` WHERE ten_dang_nhap = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $tai_khoan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $user_id = $row['id'];
            $hashed_password = $row['mat_khau'];
            $vai_tro = "Admin"; // Gán vai trò Admin
            $id_lien_ket = null;
        } else {
            // Không tìm thấy tài khoản
            $_SESSION['login_message'] = "<div class='login-message error'>Sai tài khoản hoặc mật khẩu!</div>";
            header("Location: ../taikhoan/dangnhap.php");
            exit();
        }
    }

    // Kiểm tra mật khẩu
    if (password_verify($mat_khau_plain, $hashed_password)) {
        // Thiết lập session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['vai_tro'] = $vai_tro;
        $_SESSION['id_lien_ket'] = $id_lien_ket;
        $_SESSION['login_message'] = "<div class='login-message success'>Đăng nhập thành công!</div>";

        session_write_close(); // Đảm bảo session lưu trước khi chuyển hướng

        // Chuyển hướng dựa trên vai trò
        if ($vai_tro === "Admin") {
            header("Location: ../menu/index.php"); // Trang dành riêng cho admin
        } else {
            header("Location: ../menu/index.php"); // Trang dành cho người dùng
        }
        exit();
    }

    // Nếu mật khẩu sai
    $_SESSION['login_message'] = "<div class='login-message error'>Sai tài khoản hoặc mật khẩu!</div>";
    header("Location: ../taikhoan/dangnhap.php");
    exit();
}
ob_end_flush();
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <?php include '../DATABASE/body.php' ?>
</head>

<body>

    <div class="login">
        <div class="login-form">
            <div class="space-frm">
                <h2>Đăng Nhập</h2>
                <form method="POST" class="login__form">
                    <label>Tài khoản:</label>
                    <input type="text" name="tai_khoan" value="<?php echo htmlspecialchars($prefill_loai); ?>">
                    <label>Mật khẩu:</label>
                    <input type="password" name="mat_khau" id="password">
                    <div class="show-password">
                        <input type="checkbox" id="togglePassword">
                        <label for="togglePassword">Hiện mật khẩu</label>
                    </div>



                    <?php 
            if (!empty($login_message)) {
                echo $login_message;
            }
          ?>
                    <button type="submit">Đăng Nhập</button>
                    <a href="../taikhoan/dangki.php">Đăng ký tài khoản</a>
                </form>
            </div>
            <img src="http://localhost/high-school/public/asset/img/login/login.jpg" alt="" class="login-form__form">
        </div>
    </div>
    <script>
    const togglePassword = document.querySelector("#togglePassword");
    const passwordField = document.querySelector("#password");
    togglePassword.addEventListener("change", function() {
        const type = this.checked ? "text" : "password";
        passwordField.setAttribute("type", type);
    });
    </script>
</body>

</html>