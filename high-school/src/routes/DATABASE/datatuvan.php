<?php
session_set_cookie_params(0, "/");
session_start();
require_once __DIR__ . '/DATABASE/sql.php';

// Truy vấn lấy danh sách ngành từ bảng khoahoc để tạo dropdown cho "Ngành quan tâm"
$course_options = [];
$sql_courses = "SELECT DISTINCT ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc ASC";
$result_courses = $conn->query($sql_courses);
 //neu > se ton tai//
if ($result_courses && $result_courses->num_rows > 0) {
    while ($row = $result_courses->fetch_assoc()) {
        $course_options[] = $row['ten_khoahoc'];
    }
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ho_ten         = trim($_POST['ho_ten'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $so_dien_thoai  = trim($_POST['so_dien_thoai'] ?? '');
    $que_quan       = trim($_POST['que_quan'] ?? '');
    $nganh_quan_tam = trim($_POST['nganh_quan_tam'] ?? '');

    // Kiểm tra các trường bắt buộc
    if (empty($ho_ten) || empty($email) || empty($so_dien_thoai) || empty($que_quan) || empty($nganh_quan_tam)) {
        $message = "<div class='form-message error'>Vui lòng điền đầy đủ thông tin.</div>";
    } else {
      
        $sql = "INSERT INTO dang_ky_tu_van (ho_ten, email, so_dien_thoai, que_quan, nganh_quan_tam)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
 
            $stmt->bind_param("sssss", $ho_ten, $email, $so_dien_thoai, $que_quan, $nganh_quan_tam);
            if ($stmt->execute()) {
                $message = "<div class='form-message success'>Đăng ký tư vấn thành công!</div>";
            } else {
                $message = "<div class='form-message error'>Lỗi: Không thể đăng ký tư vấn.</div>";
            }
            $stmt->close();
        } else {
            $message = "<div class='form-message error'>Lỗi: Không thể chuẩn bị câu lệnh SQL.</div>";
        }
    }
}

ob_end_flush();
?>