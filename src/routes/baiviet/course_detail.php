<?php
ob_start(); 
require_once __DIR__ . '/../DATABASE/DataCouser.php';
require_once __DIR__ . '/../DATABASE/sql.php'; // Kết nối CSDL

// Khởi tạo session với cookie toàn cục
session_set_cookie_params(0, "/");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DEBUG: (Bạn có thể comment hoặc xóa dòng in SESSION sau khi debug)
// echo "<pre>" . print_r($_SESSION, true) . "</pre>";
// exit();

// Kiểm tra nếu chưa đăng nhập, chuyển hướng sang trang đăng nhập
if (!isset($_SESSION['user_id'], $_SESSION['ten_dang_nhap'], $_SESSION['vai_tro'])) {
    header("Location: ../taikhoan/dangnhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$ten_hocsinh = $_SESSION['ten_hocsinh'] ?? '';
$ten_dang_nhap = $_SESSION['ten_dang_nhap'];
$vai_tro = $_SESSION['vai_tro'];

// Chỉ cho phép vai trò "hocsinh" đăng ký khóa học
if (strtolower($vai_tro) !== 'hocsinh') {
    die("<p style='color: red; font-weight: bold;'>Chỉ học sinh mới có quyền đăng ký khóa học.</p>");
}

// Kiểm tra nếu có ID khóa học và cap_hoc trong URL
if (isset($_GET['id']) && isset($_GET['cap_hoc'])) {
    $course_id = intval($_GET['id']);
    $cap_hoc = $_GET['cap_hoc'];

    // Lấy thông tin khóa học từ bảng khoahoc
    $sql = "SELECT * FROM khoahoc WHERE id = :id AND cap_hoc = :cap_hoc";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $course_id, 'cap_hoc' => $cap_hoc]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        die("<p style='color: red; font-weight: bold;'>Không tìm thấy khoá học.</p>");
    }

    // Kiểm tra học sinh đã đăng ký khóa học này chưa (lấy thêm tên lớp nếu có)
    $sql_check = "SELECT dk.id, dk.trang_thai, dk.id_lien_ket, lh.ten_lop 
                  FROM dangky_khoahoc dk
                  LEFT JOIN lophoc lh ON dk.lophoc_id = lh.id
                  WHERE dk.hocsinh_id = :user_id AND dk.khoahoc_id = :course_id";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute(['user_id' => $user_id, 'course_id' => $course_id]);
    $registered_course = $stmt_check->fetch(PDO::FETCH_ASSOC);
}

// Xử lý khi form đăng ký được gửi lên
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);
    $cap_hoc = $_POST['cap_hoc'];

    // Lấy tên khóa học từ bảng khoahoc
    $sql_course = "SELECT ten_khoahoc FROM khoahoc WHERE id = :id";
    $stmt_course = $pdo->prepare($sql_course);
    $stmt_course->execute(['id' => $course_id]);
    $course_data = $stmt_course->fetch(PDO::FETCH_ASSOC);

    if (!$course_data) {
        $_SESSION['message'] = "Không tìm thấy khóa học.";
        $_SESSION['message_type'] = "error";
        header("Location: course_detail.php?id=$course_id&cap_hoc=$cap_hoc");
        exit();
    }
    $ten_khoahoc = $course_data['ten_khoahoc'];

    // Kiểm tra nếu học sinh đã đăng ký khóa học này
    $sql_check_exist = "SELECT * FROM dangky_khoahoc WHERE hocsinh_id = :user_id AND khoahoc_id = :course_id";
    $stmt_check_exist = $pdo->prepare($sql_check_exist);
    $stmt_check_exist->execute(['user_id' => $user_id, 'course_id' => $course_id]);

    if ($stmt_check_exist->rowCount() > 0) {
        $_SESSION['message'] = "Bạn đã đăng ký khóa học này trước đó!";
        $_SESSION['message_type'] = "error";
    } else {
        // Tạo id_lien_ket duy nhất (mã đăng ký)
        $id_lien_ket = uniqid("DK_");

        // Thêm vào bảng dangky_khoahoc (lophoc_id được để NULL nếu không có)
        $sql_insert = "INSERT INTO dangky_khoahoc (id_lien_ket, hocsinh_id, khoahoc_id, lophoc_id, ten_khoahoc, trang_thai, ho_ten, ten_dang_nhap) 
                       VALUES (:id_lien_ket, :user_id, :course_id, NULL, :ten_khoahoc, 'đang chờ phê duyệt', :ho_ten, :ten_dang_nhap)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute([
            'id_lien_ket'   => $id_lien_ket,
            'user_id'       => $user_id,
            'course_id'     => $course_id,
            'ten_khoahoc'   => $ten_khoahoc,
            'ho_ten'        => $ten_hocsinh,
            'ten_dang_nhap' => $ten_dang_nhap
        ]);

        $_SESSION['message'] = "Đăng ký thành công! Mã đăng ký của bạn là: $id_lien_ket. Vui lòng chờ phê duyệt.";
        $_SESSION['message_type'] = "success";
    }

    header("Location: course_detail.php?id=$course_id&cap_hoc=$cap_hoc");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết khoá học</title>
    <?php include '../DATABASE/body.php'; ?>
</head>
<?php include '../background/header.php'; ?>

<body>
    <div class="course-detail-container">
        <?php if ($course): ?>
        <figure>
            <img src="<?php echo htmlspecialchars($course['hinh_anh']); ?>"
                alt="<?php echo htmlspecialchars($course['ten_khoahoc']); ?>">
        </figure>
        <h1><?php echo htmlspecialchars($course['ten_khoahoc']); ?></h1>
        <div class="course-info">
            <p><strong>Cấp học:</strong> <?php echo htmlspecialchars($course['cap_hoc']); ?></p>
            <p><strong>Giá tiền:</strong> <?php echo number_format($course['gia_tien'], 2); ?> VNĐ</p>
            <p><strong>Thời gian học:</strong> <?php echo htmlspecialchars($course['thoi_gian_hoc']); ?> năm</p>
            <p><strong>Hình thức học:</strong> <?php echo htmlspecialchars($course['hinh_thuc_hoc']); ?></p>

            <?php if (!empty($_SESSION['message'])): ?>
            <p
                style="color: <?php echo $_SESSION['message_type'] === 'error' ? 'red' : 'green'; ?>; font-weight: bold;">
                <?php echo $_SESSION['message']; unset($_SESSION['message'], $_SESSION['message_type']); ?>
            </p>
            <?php elseif ($registered_course): ?>
            <p style="color: green; font-weight: bold;">
                Bạn đã đăng ký khóa học
                <strong><?php echo htmlspecialchars($registered_course['ten_lop'] ?? ''); ?></strong>.<br>
                Mã đăng ký:
                <strong><?php echo htmlspecialchars($registered_course['id_lien_ket'] ?? 'Chưa có mã'); ?></strong>
            </p>
            <?php else: ?>
            <form action="" method="POST">
                <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                <input type="hidden" name="cap_hoc" value="<?php echo htmlspecialchars($course['cap_hoc']); ?>">
                <button type="submit" class="submit-register">Đăng ký khóa học</button>
            </form>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <a href="../menu/index.php">← Quay lại</a>
    </div>
    <?php include '../background/footer.php'; ?>
</body>

</html>