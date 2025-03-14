<?php
session_start();
$host = 'localhost';
$dbname = 'truonghoc';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để đăng ký khóa học!'); window.location.href='../taikhoan/dangnhap.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;

if ($course_id <= 0) {
    echo "<script>alert('Khóa học không hợp lệ!'); window.location.href='../menu/index.php';</script>";
    exit();
}

try {
    // Lấy thông tin khóa học
    $sqlCourse = "SELECT id, ten_khoahoc FROM khoahoc WHERE id = :course_id";
    $stmt = $pdo->prepare($sqlCourse);
    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        echo "<script>alert('Khóa học không tồn tại!'); window.location.href='../menu/index.php';</script>";
        exit();
    }

    // Kiểm tra nếu học sinh đã bị từ chối khóa học này trước đó
    $sqlCheckRejected = "SELECT 1 FROM dangky_bituchoi WHERE hocsinh_id = :user_id AND khoahoc_id = :course_id";
    $stmt = $pdo->prepare($sqlCheckRejected);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->fetch()) {
        echo "<script>alert('Bạn đã từng bị từ chối khóa học này! Vui lòng liên hệ quản trị viên.'); window.location.href='../menu/index.php';</script>";
        exit();
    }

    // Kiểm tra nếu lớp học đã tồn tại
    $sqlCheckClass = "SELECT id FROM lophoc WHERE ten_lop = :ten_lop LIMIT 1";
    $stmt = $pdo->prepare($sqlCheckClass);
    $stmt->bindParam(':ten_lop', $course['ten_khoahoc'], PDO::PARAM_STR);
    $stmt->execute();
    $lophoc = $stmt->fetch(PDO::FETCH_ASSOC);

    // Nếu chưa có lớp học, tạo mới
    if (!$lophoc) {
        $sqlCreateClass = "INSERT INTO lophoc (ten_lop) VALUES (:ten_lop)";
        $stmt = $pdo->prepare($sqlCreateClass);
        $stmt->bindParam(':ten_lop', $course['ten_khoahoc'], PDO::PARAM_STR);
        $stmt->execute();

        // Lấy ID của lớp học vừa tạo
        $lophoc_id = $pdo->lastInsertId();
    } else {
        $lophoc_id = $lophoc['id'];
    }

    // Lấy thông tin học sinh
    $sqlUser = "SELECT ho_ten FROM hocsinh WHERE id = :user_id";
    $stmt = $pdo->prepare($sqlUser);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<script>alert('Chỉ học sinh mới có thể đăng ký khóa học!'); window.location.href='../menu/index.php';</script>";
        exit();
    }

    // Kiểm tra nếu học sinh đã đăng ký khóa học này
    $sqlCheck = "SELECT 1 FROM dangky_khoahoc WHERE khoahoc_id = :course_id AND hocsinh_id = :user_id";
    $stmt = $pdo->prepare($sqlCheck);
    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->fetch()) {
        echo "<script>alert('Bạn đã đăng ký khóa học này!'); window.location.href='../menu/index.php';</script>";
        exit();
    }

    // Thêm đăng ký khóa học vào bảng `dangky_khoahoc`
    $sqlInsert = "INSERT INTO dangky_khoahoc (khoahoc_id, hocsinh_id, lophoc_id, ten_khoahoc, ho_ten, trang_thai)
    VALUES (:course_id, :user_id, :lophoc_id, :ten_khoahoc, :ho_ten, 'Chờ duyệt')";
    $stmt = $pdo->prepare($sqlInsert);
    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':lophoc_id', $lophoc_id, PDO::PARAM_INT);
    $stmt->bindParam(':ten_khoahoc', $course['ten_khoahoc'], PDO::PARAM_STR);
    $stmt->bindParam(':ho_ten', $user['ho_ten'], PDO::PARAM_STR);
    $stmt->execute();

    echo "<script>alert('Đăng ký thành công! Đang chờ duyệt.'); window.location.href='../menu/index.php';</script>";
    exit();
} catch (PDOException $e) {
    die("Lỗi khi đăng ký: " . htmlspecialchars($e->getMessage()));
}
?>