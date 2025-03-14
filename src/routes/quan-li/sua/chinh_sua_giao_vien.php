<?php
session_start();
include '../../DATABASE/sql.php'; 

if (!isset($_SESSION['user_id']) || ($_SESSION['vai_tro'] != 'Giaovien  ' && $_SESSION['vai_tro'] !== 'Admin')) {
    header('Location: ../../taikhoan/dangnhap.php'); 
    exit();
}


$gv_id = intval($_GET['id']);
$sql = "SELECT g.*, nd.ten_dang_nhap, nd.avatar 
        FROM giaovien g 
        JOIN nguoi_dung nd ON g.id = nd.id_lien_ket 
        WHERE g.id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $gv_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Giáo viên không tồn tại.");
}

$gv = $result->fetch_assoc();
$stmt->close();

$mess = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob']; 

    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $education = $_POST['education'];
    $major = $_POST['major'];
    

    $sqlUpdate = "UPDATE giaovien 
                  SET ho_ten = ?, gioi_tinh = ?, nam_sinh = ?, que_quan = ?, 
                      dien_thoai = ?, email = ?, trinh_do_hoc_van = ?, chuyen_nganh = ? 
                  WHERE id = ?";
    $stmt = $conn->prepare($sqlUpdate);
    if (!$stmt) {
        die("Lỗi prepare (update giáo viên): " . $conn->error);
    }
    $stmt->bind_param("ssssssssi", $name, $gender, $dob, $address, 
                      $phone, $email, $education, $major, $gv_id);
    if ($stmt->execute()) {
        $mess = "Thông tin đã được cập nhật!";
        header('location: ../../quan-tri/admin.php');
        exit();
    } else {
        $mess = "Lỗi khi cập nhật thông tin: " . $stmt->error;
    }
    $stmt->close();
}
?>
<?php include '../../DATABASE/body.php' ?>

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

<a href="../../quan-tri/admin.php" class="return-home"><img
        src="http://localhost/high-school/public/asset/icon/right.svg" alt=""> </a>



<section class="section-update-student">
    <h2 class="bold">Sửa thông tin cá nhân</h2>
    <div class="div-background-class">
        <form method="post" action="" class="background-class">
            <label>Tên:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($gv['ho_ten']); ?>" required
                class="form-input">
            <br>

            <label>Giới tính:</label>
            <select name="gender" required class="form-input">
                <option value="Nam" <?php echo ($gv['gioi_tinh'] == 'Nam' ? 'selected' : ''); ?>>Nam</option>
                <option value="Nữ" <?php echo ($gv['gioi_tinh'] == 'Nữ' ? 'selected' : ''); ?>>Nữ</option>
                <option value="khác" <?php echo ($gv['gioi_tinh'] == 'Khác' ? 'selected' : ''); ?>>Khác</option>
            </select>
            <br>

            <label>Ngày sinh:</label>
            <input type="date" name="dob" value="<?php echo htmlspecialchars($gv['nam_sinh']); ?>" required
                class="form-input">

            <br>

            <label>Địa chỉ:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($gv['que_quan']); ?>" required
                class="form-input">
            <br>

            <label>Điện thoại:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($gv['dien_thoai']); ?>"
                class="form-input">
            <br>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($gv['email']); ?>" class="form-input">
            <br>

            <label>Trình độ học vấn:</label>
            <input type="text" name="education" value="<?php echo $gv['trinh_do_hoc_van']; ?>" class="form-input">
            <br>

            <label>Chuyên ngành:</label>
            <input type="text" name="major" value="<?php echo $gv['chuyen_nganh']; ?>" class="form-input">
            <br>

            <p style="color: green;"><?php echo $mess; ?></p>
            <input type="submit" value="Cập nhật" class="btn-submit">
        </form>
    </div>
</section>