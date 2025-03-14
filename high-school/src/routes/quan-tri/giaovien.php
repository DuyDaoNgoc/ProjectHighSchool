<?php
session_start();
include '../DATABASE/dabase_tk.php'; // Kết nối tới cơ sở dữ liệu

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'teacher') {
    header('Location: ../taikhoan/login.php'); // Nếu không phải giáo viên, chuyển đến trang đăng nhập
    exit();
}

// Lấy thông tin giáo viên
$teacher_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, gender, dob, address, phone, email FROM teachers WHERE id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$stmt->bind_result($name, $gender, $dob, $address, $phone, $email);
$stmt->fetch();
$stmt->close();
?>

<h1>Quản lý giáo viên</h1>
<p><strong>Chào mừng, <?php echo $name; ?>!</strong></p>

<p><strong>Thông tin cá nhân:</strong></p>
<ul>
    <li><strong>Tên:</strong> <?php echo $name; ?></li>
    <li><strong>Giới tính:</strong> <?php echo $gender; ?></li>
    <li><strong>Ngày sinh:</strong> <?php echo $dob; ?></li>
    <li><strong>Địa chỉ:</strong> <?php echo $address; ?></li>
    <li><strong>Điện thoại:</strong> <?php echo $phone; ?></li>
    <li><strong>Email:</strong> <?php echo $email; ?></li>
</ul>

<!-- Các chức năng khác của giáo viên -->
<a href="edit_teacher.php">Sửa thông tin</a>