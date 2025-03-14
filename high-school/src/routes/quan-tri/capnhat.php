<?php
session_start();

// Kiểm tra xem người dùng có phải Admin không
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] !== 'Admin') {
    header("Location: ../menu/index.php"); 
    exit();
}

require_once '../DATABASE/sql.php'; 
$conn->set_charset("utf8");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


$message_teacher = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_teacher'])) {
    $teacher_id = intval($_POST['teacher_id'] ?? 0);
    $new_level  = trim($_POST['trinh_do_hoc_van'] ?? '');
    if ($teacher_id > 0 && !empty($new_level)) {
        $sql = "UPDATE giaovien SET trinh_do_hoc_van = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_level, $teacher_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $message_teacher = "Cập nhật trình độ học vấn của giáo viên thành công!";
        } else {
            $message_teacher = "Không có thay đổi nào được cập nhật.";
        }
        $stmt->close();
    } else {
        $message_teacher = "Vui lòng điền đầy đủ thông tin cho cập nhật giáo viên.";
    }
}


$message_student = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_student'])) {
    $student_id = intval($_POST['student_id'] ?? 0);
    $new_class  = trim($_POST['ten_lop'] ?? '');
    $new_major  = trim($_POST['nganh'] ?? '');
    if ($student_id > 0 && !empty($new_class) && !empty($new_major)) {
        $sql = "UPDATE hocsinh SET ten_lop = ?, nganh = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $new_class, $new_major, $student_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $message_student = "Cập nhật lớp học và ngành của học sinh thành công!";
        } else {
            $message_student = "Không có thay đổi nào được cập nhật.";
        }
        $stmt->close();
    } else {
        $message_student = "Vui lòng điền đầy đủ thông tin cho cập nhật học sinh.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Cập nhật thông tin</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
    }

    h1 {
        color: #333;
    }

    form {
        margin-bottom: 30px;
        border: 1px solid #ccc;
        padding: 15px;
        max-width: 500px;
    }

    label {
        display: block;
        margin-top: 10px;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 8px;
    }

    input[type="submit"] {
        margin-top: 15px;
        padding: 10px 20px;
    }

    .message {
        padding: 10px;
        color: green;
    }

    .error {
        padding: 10px;
        color: red;
    }
    </style>
</head>

<body>
    <h1>Trang quản trị Admin</h1>

    <?php if (!empty($message_teacher)): ?>
    <div class="message"><?php echo htmlspecialchars($message_teacher); ?></div>
    <?php endif; ?>

    <h2>Cập nhật trình độ học vấn của Giáo viên</h2>
    <form method="post" action="">
        <label for="teacher_id">ID Giáo viên:</label>
        <input type="number" name="teacher_id" id="teacher_id" required>

        <label for="trinh_do_hoc_van">Trình độ học vấn mới:</label>
        <input type="text" name="trinh_do_hoc_van" id="trinh_do_hoc_van" required>

        <input type="submit" name="update_teacher" value="Cập nhật">
    </form>

    <?php if (!empty($message_student)): ?>
    <div class="message"><?php echo htmlspecialchars($message_student); ?></div>
    <?php endif; ?>

    <h2>Cập nhật Lớp học và Ngành của Học sinh</h2>
    <form method="post" action="">
        <label for="student_id">ID Học sinh:</label>
        <input type="number" name="student_id" id="student_id" required>

        <label for="ten_lop">Tên lớp mới:</label>
        <input type="text" name="ten_lop" id="ten_lop" required>

        <label for="nganh">Ngành mới (viết tắt, ví dụ: cntt, att):</label>
        <input type="text" name="nganh" id="nganh" required>

        <input type="submit" name="update_student" value="Cập nhật">
    </form>

    <p><a href="../index.php">Quay lại trang chủ</a></p>
</body>

</html>