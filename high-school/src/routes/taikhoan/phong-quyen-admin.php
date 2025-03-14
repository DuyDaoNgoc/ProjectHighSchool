<?php

require_once '../DATABASE/sql.php';

$adminUsername    = 'admin';
$adminPasswordRaw = 'admin1234'; 
$adminEmail       = 'admin@example.com';
$adminRole        = 'Admin';
$adminHoTen       = 'Quản trị viên'; // Thêm họ tên admin

// Kiểm tra xem admin đã tồn tại chưa
$sqlCheck = "SELECT COUNT(*) FROM admin WHERE ten_dang_nhap = ?";
$stmtCheck = $conn->prepare($sqlCheck);
if (!$stmtCheck) {
    die("Lỗi prepare (kiểm tra admin): " . $conn->error);
}
$stmtCheck->bind_param("s", $adminUsername);
$stmtCheck->execute();
$stmtCheck->bind_result($count);
$stmtCheck->fetch();
$stmtCheck->close();

if ($count > 0) {
    echo "Tài khoản admin đã tồn tại.";
} else {
    // Hash mật khẩu
    $hashedPassword = password_hash($adminPasswordRaw, PASSWORD_DEFAULT);

    // Chèn admin với cột ho_ten
    $sqlInsert = "INSERT INTO admin (ten_dang_nhap, mat_khau, email, vai_tro, ho_ten) VALUES (?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    if (!$stmtInsert) {
        die("Lỗi prepare (chèn admin): " . $conn->error);
    }
    $stmtInsert->bind_param("sssss", $adminUsername, $hashedPassword, $adminEmail, $adminRole, $adminHoTen);
    if ($stmtInsert->execute()) {
        echo "Tài khoản admin đã được tạo thành công!";
    } else {
        echo "Lỗi khi tạo tài khoản admin: " . $stmtInsert->error;
    }
    $stmtInsert->close();
}

?>