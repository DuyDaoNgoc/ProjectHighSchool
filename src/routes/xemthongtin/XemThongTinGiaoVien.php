<?php
session_start();
include '../DATABASE/sql.php';

if (!isset($_GET['id'])) {
    die("Không có ID được cung cấp.");
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
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin Giáo viên</title>
    <?php include '../DATABASE/body.php'; ?>
    <style>
    .info-container {
        max-width: 600px;
        margin: 20px auto;
        text-align: center;
    }

    .info-container img {
        max-width: 200px;
        border-radius: 50%;
    }
    </style>
</head>

<body>
    <?php include '../background/header.php';?>
    <div class="info-container">
        <h2>Thông tin Giáo viên</h2>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($gv['id']); ?></p>
        <?php 

            if (!empty($gv['avatar'])) {
                $avatar = $gv['avatar'];
            } else {
              
                if (isset($gv['gioi_tinh']) && strtolower($gv['gioi_tinh']) === 'nữ') {
                    $avatar = "http://localhost/high-school/public/asset/icon/avatar-nu.svg";
                } else {
                    $avatar = "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
                }
            }
        ?>
        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar của Giáo viên">
        <h1><?php echo htmlspecialchars($gv['ho_ten']); ?></h1>

    </div>

    <?php include '../background/footer.php'; ?>
</body>

</html>