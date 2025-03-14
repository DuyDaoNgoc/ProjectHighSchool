<?php
session_start();
require_once __DIR__ . '../../../DATABASE/sql.php';  

if (!isset($_SESSION['user_id']) || !isset($_SESSION['vai_tro']) || !in_array($_SESSION['vai_tro'], ['Admin', 'GiaoVien'])) {
    header('Location: ../taikhoan/dangnhap.php');
    exit();
}





if (!isset($_GET['id'])) {
die("Không có ID học sinh được cung cấp.");
}

$hs_id = intval($_GET['id']);
$update_message = "";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_student'])) {

$trinh_do = $_POST['trinh_do_hoc_van'] ?? '';
$lop_id = isset($_POST['lop_id']) ? intval($_POST['lop_id']) : NULL;

$diem = $_POST['diem'] ?? '';
$hanh_kiem = $_POST['hanh_kiem'] ?? '';


$sql_update = "UPDATE hocsinh SET trinh_do_hoc_van = ?, lop_id = ?, diem = ?, hanh_kiem = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
if (!$stmt_update) {
die("Lỗi chuẩn bị truy vấn cập nhật: " . $conn->error);
}
$stmt_update->bind_param("siisi", $trinh_do, $lop_id, $diem, $hanh_kiem, $hs_id);
$stmt_update->execute();
if ($stmt_update->affected_rows >= 0) {
$update_message = "<div class='success'>Cập nhật thông tin học sinh thành công!</div>";
} else {
$update_message = "<div class='error'>Lỗi cập nhật: " . $stmt_update->error . "</div>";
}
$stmt_update->close();
}


$sql = "SELECT * FROM hocsinh WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hs_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
die("Học sinh không tồn tại.");
}
$hs = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin học sinh</title>
    <?php include '../../DATABASE/body.php' ?>
</head>

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



.return-home {

    padding: 20px;
    display: flex;
    width: max-content;
    height: 10%;

}

.return-home img {
    transform: rotateY(179deg);
    height: 20%;
    width: 10%;
}

.return-home img:active {
    filter: invert(4) sepia(133) saturate(166) hue-rotate(1510deg);

}
</style>

<body>

    <a href="../../quan-tri/admin.php" class="return-home"><img
            src="http://localhost/high-school/public/asset/icon/right.svg" alt=""> </a>

    <div class="section-update-student">
        <h1 class="bold">Chỉnh sửa thông tin học sinh</h1>
        <?php 
        if (!empty($update_message)) {
            echo $update_message;
        }
        ?>
        <div class="div-background-class">
            <form method="POST" class="background-class">
                <label>Trình độ học vấn:</label>
                <input type="text" name="trinh_do_hoc_van" class="form-input"
                    value="<?php echo htmlspecialchars($hs['trinh_do_hoc_van']); ?>" required>

                <label>Lớp (ID):</label>
                <input type="number" name="lop_id" class="form-input"
                    value="<?php echo htmlspecialchars($hs['lop_id']); ?>">


                <label>Điểm:</label>
                <input type="text" name="diem" class="form-input"
                    value="<?php echo isset($hs['diem']) ? htmlspecialchars($hs['diem']) : ''; ?>">

                <label>Hạnh kiểm:</label>
                <input type="text" name="hanh_kiem" class="form-input"
                    value="<?php echo isset($hs['hanh_kiem']) ? htmlspecialchars($hs['hanh_kiem']) : ''; ?>">

                <button type="submit" name="update_student" class="btn-submit">Cập nhật thông tin</button>
            </form>
        </div>


    </div>

</body>

</html>