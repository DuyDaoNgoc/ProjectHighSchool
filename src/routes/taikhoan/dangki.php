<?php
include '../DATABASE/dabase_tk.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <?php include '../DATABASE/body.php'; ?>
</head>

<body>

    <div class="login">
        <div class="login-form">
            <div class="space-frm">
                <h2>Đăng Ký Tài Khoản</h2>
                <form action="http://localhost/high-school/src/routes/DATABASE/dabase_tk.php" method="POST"
                    class="login__form">

                    <label>Họ và tên:</label>
                    <input type="text" name="ten" required>

                    <label>Giới tính:</label>
                    <select name="gioi_tinh">
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>

                    <label>Ngày sinh:</label>
                    <input type="date" name="ngay_sinh" required>



                    <label>Quê quán:</label>
                    <input type="text" name="que_quan" required>

                    <label>Điện thoại:</label>
                    <input type="text" name="dien_thoai" required>

                    <label>Email:</label>
                    <input type="email" name="email" required>



                    <label>Tài khoản:</label>
                    <input type="text" name="tai_khoan" required>

                    <label>Mật khẩu:</label>
                    <input type="password" name="mat_khau" required>

                    <label>Loại tài khoản:</label>
                    <select name="vai_tro">
                        <option value="HocSinh">Học sinh</option>
                        <option value="GiaoVien">Giáo viên</option>
                    </select>

                    <button type="submit">Đăng Ký</button>
                    <a href="../taikhoan/dangnhap.php">Đăng nhập</a>
                </form>
            </div>
            <img src="http://localhost/high-school/public/asset/img/login/login.jpg" alt="" class="login-form__form">
        </div>
    </div>

</body>

</html>