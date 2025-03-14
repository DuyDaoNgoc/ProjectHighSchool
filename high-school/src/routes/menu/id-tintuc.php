<?php
session_start();
require '../DATABASE/sql.php';

if (!isset($_GET['id'])) {
    die("Không có bài viết được chọn.");
}

$id = intval($_GET['id']);

$sql = "SELECT t.*, n.ten_dang_nhap FROM tintuc t
        JOIN nguoi_dung n ON t.user_id = n.id
        WHERE t.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Bài viết không tồn tại.");
}

$post = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['tieu_de']); ?></title>
    <link rel="stylesheet" href="http://localhost/high-school/public/css/reset.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/style.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/gerenal.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/tintuc.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include '../background/header.php'; ?>
    <div style="    width: 90%;
    max-width: 800px;
    margin: 20px auto;
    padding: 15px;">
        <h1><?php echo htmlspecialchars($post['tieu_de']); ?></h1>
        <p><em>Đăng bởi: <?php echo htmlspecialchars($post['ten_dang_nhap']); ?> |
                <?php echo $post['ngay_dang']; ?></em></p>
        <?php if (!empty($post['hinh_anh'])) { ?>
        <img src="<?php echo $post['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($post['tieu_de']); ?>"
            style="max-width:100%;">
        <?php } ?>
        <div style="margin-top:15px;">
            <?php echo nl2br(htmlspecialchars($post['noi_dung'])); ?>
        </div>
        <p><a href="tintuc.php">&laquo; Quay lại danh sách tin tức</a></p>
    </div>
    <?php include '../background/footer.php'; ?>
</body>

</html>