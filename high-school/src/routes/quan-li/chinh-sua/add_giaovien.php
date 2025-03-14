<?php
session_start();
include 'db.php'; // Kết nối đến cơ sở dữ liệu

// Kiểm tra nếu form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_code = $_POST['teacher_code'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Câu lệnh INSERT cho giáo viên
    $stmt = $conn->prepare("INSERT INTO teachers (teacher_code, name, gender, dob, address, phone, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $teacher_code, $name, $gender, $dob, $address, $phone, $email, $hashed_password);

    // Thực thi câu lệnh INSERT và kiểm tra kết quả
    if ($stmt->execute()) {
        echo "Giáo viên đã được thêm thành công!";
    } else {
        echo "Lỗi khi thêm giáo viên: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Form thêm giáo viên mới -->
<h2>Thêm giáo viên</h2>
<form method="post" action="add_teacher.php">
    <label>Mã giáo viên:</label>
    <input type="text" name="teacher_code" required>
    <br>

    <label>Tên:</label>
    <input type="text" name="name" required>
    <br>

    <label>Giới tính:</label>
    <select name="gender" required>
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
        <option value="Khác">Khác</option>
    </select>
    <br>

    <label>Ngày sinh:</label>
    <input type="date" name="dob" required>
    <br>

    <label>Địa chỉ:</label>
    <input type="text" name="address" required>
    <br>

    <label>Số điện thoại:</label>
    <input type="text" name="phone">
    <br>

    <label>Email:</label>
    <input type="email" name="email">
    <br>

    <label>Mật khẩu:</label>
    <input type="password" name="password" required>
    <br>

    <input type="submit" value="Thêm giáo viên">
</form>