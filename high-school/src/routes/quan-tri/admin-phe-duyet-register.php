<?php
session_start();
require_once __DIR__ . '/../DATABASE/DataCouser.php';

// Kiểm tra quyền Admin
if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'Admin') {
    header("Location: ../taikhoan/dangnhap.php");
    exit();
}

// Kiểm tra và lấy khoahoc_id từ URL
$khoahoc_id = isset($_GET['khoahoc_id']) ? intval($_GET['khoahoc_id']) : 0;
$student_name = "Không có thông tin";
$course_name = "Không có thông tin";
$hocsinh_id = null;
$lophoc_id = null;
$class_options = '';

if ($khoahoc_id > 0) {
    try {
        // Truy vấn lấy thông tin đăng ký khóa học
        $sql = "SELECT dk.id AS register_id, hs.id AS hocsinh_id, hs.ho_ten, 
                       kh.ten_khoahoc, kh.id AS khoahoc_id
                FROM dangky_khoahoc dk
                JOIN hocsinh hs ON dk.hocsinh_id = hs.id
                JOIN khoahoc kh ON dk.khoahoc_id = kh.id
                WHERE dk.khoahoc_id = :khoahoc_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':khoahoc_id' => $khoahoc_id]);
        $registration = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registration) {
            $student_name = htmlspecialchars($registration['ho_ten']);
            $course_name = htmlspecialchars($registration['ten_khoahoc']);
            $hocsinh_id = $registration['hocsinh_id'];

            // Tìm các lớp học phù hợp với khóa học này
            $sql = "SELECT id, ten_lop FROM lophoc WHERE nganh = (SELECT nganh FROM khoahoc WHERE id = :khoahoc_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':khoahoc_id' => $khoahoc_id]);
            $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Tạo danh sách các lớp học cho dropdown
            foreach ($classes as $class) {
                $class_options .= "<option value='" . $class['id'] . "'>" . htmlspecialchars($class['ten_lop']) . "</option>";
            }
        } else {
            echo "<p style='color: red; text-align: center;'>Không tìm thấy đơn đăng ký cho khóa học này.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red; text-align: center;'>Lỗi truy vấn: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

// Kiểm tra phê duyệt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve'])) {
    $lop_hoc_id = isset($_POST['lop_hoc_id']) ? intval($_POST['lop_hoc_id']) : null;

    if ($lop_hoc_id && $hocsinh_id && $khoahoc_id) {
        try {
            // Cập nhật trạng thái phê duyệt và lớp học
            $sql = "UPDATE dangky_khoahoc 
                    SET trang_thai = 'Đã phê duyệt', lophoc_id = :lop_hoc_id 
                    WHERE hocsinh_id = :hocsinh_id AND khoahoc_id = :khoahoc_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':lop_hoc_id' => $lop_hoc_id,
                ':hocsinh_id' => $hocsinh_id,
                ':khoahoc_id' => $khoahoc_id
            ]);
            echo "<p style='color: green; text-align: center;'>Đăng ký đã được phê duyệt thành công!</p>";
        } catch (PDOException $e) {
            echo "<p style='color: red; text-align: center;'>Lỗi khi phê duyệt: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Thông tin không hợp lệ, vui lòng thử lại.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <?php include '../DATABASE/body.php' ?>
    <title>Phê duyệt đăng ký</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .form-container {
        background: whitesmoke;
        padding: 20px;
        width: 100%;
        max-width: 400px;
        margin: 50px auto;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .btn-submit {
        background-color: #28a745;
        color: white;
        padding: 12px;
        border: none;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
        border-radius: 5px;
    }

    .btn-submit:hover {
        background-color: #218838;
    }

    @media screen and (max-width: 480px) {
        .form-container {
            width: 90%;
            margin: 20px auto;
        }
    }
    </style>
</head>

<body>

    <?php include '../background/header.php'; ?>

    <div class="form-container">
        <h2>Phê duyệt đăng ký</h2>
        <form method="POST" action="approve_registration.php">
            <div class="form-group">
                <label for="khoahoc_id">ID Khóa học:</label>
                <input type="text" id="khoahoc_id" value="<?= htmlspecialchars($khoahoc_id) ?>" readonly
                    class="form-input" name="khoahoc_id">
            </div>
            <div class="form-group">
                <label for="student_name">Tên học sinh:</label>
                <input type="text" id="student_name" value="<?= htmlspecialchars($student_name) ?>" readonly
                    class="form-input">
            </div>
            <div class="form-group">
                <label for="course_name">Khóa học:</label>
                <input type="text" id="course_name" value="<?= htmlspecialchars($course_name) ?>" readonly
                    class="form-input">
            </div>
            <div class="form-group">
                <label for="class_name">Lớp học:</label>
                <?php if ($class_options): ?>
                <select name="lop_hoc_id" class="form-input">
                    <option value="">Chọn lớp học</option>
                    <?= $class_options ?>
                </select>
                <?php else: ?>
                <p style="color: red;">Chưa có lớp phù hợp. Học sinh sẽ vào danh sách chờ.</p>
                <?php endif; ?>
            </div>
            <input type="hidden" name="hocsinh_id" value="<?= $hocsinh_id ?>">
            <button type="submit" name="approve" class="btn-submit">Phê duyệt</button>
        </form>
    </div>

    <p style="text-align: center;"><a href="admin.php">← Quay lại danh sách</a></p>

    <?php include '../background/footer.php'; ?>

</body>

</html>