<?php
session_start();
$host = 'localhost';
$dbname = 'truonghoc';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

// Kiểm tra quyền truy cập (chỉ Admin mới được phép)
if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'Admin') {
    header("Location: ../taikhoan/dangnhap.php");
    exit();
}

// Lấy danh sách khóa học từ bảng khoahoc
$sql = "SELECT id, ten_khoahoc, nganh FROM khoahoc";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$khoahoc_list = $stmt->fetchAll();
    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $ten_lop = trim($_POST['ten_lop']);

    // Lấy thông tin khóa học được chọn
    $sql = "SELECT nganh FROM khoahoc WHERE id = :course_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $stmt->execute();
    $khoahoc = $stmt->fetch();

    if ($khoahoc) {
        $nganh = $khoahoc['nganh'];

        // Sĩ số lớp không được nhập thủ công, mà sẽ được tính từ số lượng học sinh trong lớp.
        // Vì vậy, khi tạo lớp mới, ta khởi tạo số lượng học sinh hiện tại (so_hoc_sinh_vang) là 0.
        $sql = "INSERT INTO lophoc (ten_lop, nganh, so_hoc_sinh_vang) 
                VALUES (:ten_lop, :nganh, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ten_lop', $ten_lop, PDO::PARAM_STR);
        $stmt->bindParam(':nganh', $nganh, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Lớp học đã được tạo thành công!</p>";
        } else {
            echo "<p style='color: red;'>Lỗi khi tạo lớp học.</p>";
        }
    }
}
?>

<style>
.background-class {
    background: whitesmoke;
    width: max-content;
    padding: 30px;
}

.div-background-class {
    display: grid;
    justify-content: center;
}
</style>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tạo Lớp Học</title>
    <?php include '../DATABASE/body.php'; ?>
</head>

<body>

    <a href="../menu/index.php" class="return-home"><img src="http://localhost/high-school/public/asset/icon/right.svg"
            alt=""> </a>
    <h2 class="bold">Tạo Lớp Học Mới</h2>
    <div class="div-background-class">
        <form method="post" class="consultation-form">
            <label for="course_id">Chọn Khóa Học:</label>
            <select name="course_id" id="course_id" required class="form-input">
                <option value="">-- Chọn khóa học --</option>
                <?php foreach ($khoahoc_list as $khoahoc): ?>
                <option value="<?php echo $khoahoc['id']; ?>">
                    <?php echo htmlspecialchars($khoahoc['ten_khoahoc'] . " (" . $khoahoc['nganh'] . ")"); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="ten_lop">Tên Lớp:</label>
            <input type="text" name="ten_lop" id="ten_lop" required class="form-input">

            <!-- Sĩ số lớp không được nhập thủ công, nó sẽ được tính dựa trên số lượng học sinh trong lớp -->
            <button type="submit" class="btn-submit">Tạo Lớp</button>
        </form>
    </div>
</body>

</html>