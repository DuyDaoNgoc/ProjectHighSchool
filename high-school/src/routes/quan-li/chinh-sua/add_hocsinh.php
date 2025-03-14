<?php
session_start();
require_once __DIR__ . '/../DATABASE/DataCouser.php';

// Kiểm tra quyền truy cập (chỉ Admin mới được phép)
if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'Admin') {
    header("Location: ../taikhoan/dangnhap.php");
    exit();
}

// Kiểm tra nếu form được gửi đi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['approve'])) {
    $register_id = intval($_POST['register_id']);

    if ($register_id <= 0) {
        die("Dữ liệu không hợp lệ!");
    }

    try {
        $pdo->beginTransaction();

        // Lấy thông tin học sinh & khóa học từ đơn đăng ký
        $sql = "SELECT hocsinh_id, khoahoc_id FROM dangky_khoahoc WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $register_id]);
        $registration = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$registration) {
            throw new Exception("Đơn đăng ký không tồn tại.");
        }

        $student_id = $registration['hocsinh_id'];
        $khoahoc_id = $registration['khoahoc_id'];

        // Tìm lớp học thuộc khóa học đó & còn chỗ trống
        $sql = "SELECT id, si_so FROM lophoc WHERE khoahoc_id = :khoahoc_id AND si_so > (SELECT COUNT(*) FROM sinhvien_lop WHERE lop_hoc_id = lophoc.id) LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':khoahoc_id' => $khoahoc_id]);
        $class = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$class) {
            // Nếu khóa học chưa có lớp hoặc lớp đầy, cập nhật trạng thái "Chờ lớp"
            $sql = "UPDATE dangky_khoahoc SET trang_thai = 'Chờ lớp' WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $register_id]);

            $pdo->commit();
            echo "<script>alert('Không có lớp trống, học sinh được đưa vào hàng chờ.'); window.location.href='admin.php';</script>";
            exit();
        }

        $lop_hoc_id = $class['id'];

        // Kiểm tra học sinh đã có trong lớp chưa
        $sql = "SELECT 1 FROM sinhvien_lop WHERE hocsinh_id = :student_id AND lop_hoc_id = :lop_hoc_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':student_id' => $student_id,
            ':lop_hoc_id' => $lop_hoc_id
        ]);
        if ($stmt->fetch()) {
            throw new Exception("Học sinh đã được xếp vào lớp này.");
        }

        // Xếp học sinh vào lớp học
        $sql = "INSERT INTO sinhvien_lop (hocsinh_id, lop_hoc_id) VALUES (:student_id, :lop_hoc_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':student_id' => $student_id,
            ':lop_hoc_id' => $lop_hoc_id
        ]);

        // Cập nhật trạng thái đơn đăng ký thành 'Đã duyệt'
        $sql = "UPDATE dangky_khoahoc SET trang_thai = 'Đã duyệt' WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $register_id]);

        $pdo->commit();

        echo "<script>alert('Phê duyệt thành công!'); window.location.href='admin.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        die("<p style='color: red;'>Lỗi: " . htmlspecialchars($e->getMessage()) . "</p>");
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phê duyệt đăng ký khóa học</title>
    <style>
    input[type="number"] {
        width: 100%;
        padding: 5px;
    }

    .background-class {
        background: whitesmoke;
        width: max-content;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .div-background-class {
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .btn-submit {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    .btn-submit:hover {
        background-color: #218838;
    }

    .form-input {
        padding: 8px;
        width: 100%;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>

    <?php include '../background/header.php'; ?>

    <div>
        <h1 style="text-align: center;">Phê duyệt đăng ký khóa học</h1>
        <div class="div-background-class">
            <form method="POST" action="approve_registration.php" class="background-class">
                <label>ID đơn đăng ký:</label>
                <input type="number" name="register_id" required class="form-input">

                <button type="submit" name="approve" class="btn-submit">Phê duyệt và xếp lớp</button>
            </form>
        </div>

        <p style="text-align: center;"><a href="admin.php">← Quay lại danh sách đăng ký</a></p>
    </div>

    <?php include '../background/footer.php'; ?>

</body>

</html>