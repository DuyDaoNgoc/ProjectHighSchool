<?php
    ob_start();
session_start();
require  '../DATABASE/sql.php';



if (!isset($_SESSION['user_id']) || !in_array($_SESSION['vai_tro'], ['Admin', 'GiaoVien'])) {
    header("Location: ../taikhoan/dangnhap.php");
    exit();
}

$post_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_news'])) {

    $tieu_de   = trim($_POST['tieu_de'] ?? '');
    $noi_dung  = trim($_POST['noi_dung'] ?? '');
    $hinh_anh  = trim($_POST['hinh_anh'] ?? '');
    $trang_thai = "Hiển thị"; 
    $user_id   = $_SESSION['user_id'];
    $ngay_dang = date('Y-m-d H:i:s'); 


    if (empty($tieu_de) || empty($noi_dung)) {
        $post_message = "<div class='error'>Tiêu đề và nội dung không được để trống!</div>";
    } else {
        $sql = "INSERT INTO tintuc (tieu_de, noi_dung, hinh_anh, ngay_dang, trang_thai, user_id)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssssi", $tieu_de, $noi_dung, $hinh_anh, $ngay_dang, $trang_thai, $user_id);
            $stmt->execute();
            $stmt->close();
            $post_message = "<div class='success'>Bài đăng thành công!</div>";
          
        } else {
            $post_message = "<div class='error'>Lỗi khi đăng bài: " . $conn->error . "</div>";
        }
    }
}


$sql = "SELECT t.*, n.ten_dang_nhap FROM tintuc t
        JOIN nguoi_dung n ON t.user_id = n.id
        ORDER BY ngay_dang DESC";
$result = $conn->query($sql);

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang Tin Tức - Quản lý bài đăng</title>
    <link rel="stylesheet" href="http://localhost/high-school/public/css/reset.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/style.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/gerenal.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/tintuc.css">
    <link rel="stylesheet" href=" http://localhost/high-school/public/css/return-home.css">
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
    <a href="../menu/index.php" class="return-home"><img src="http://localhost/high-school/public/asset/icon/right.svg"
            alt=""> </a>
    <div class="post-form">
        <h2>Đăng bài tin tức</h2>
        <?php 
        if (!empty($post_message)) {
            echo $post_message;
        }
        ?>
        <form method="POST">
            <label>Tiêu đề:</label>
            <input type="text" name="tieu_de" required>

            <label>Nội dung:</label>
            <textarea name="noi_dung" rows="5" required></textarea>

            <label>Hình ảnh (URL):</label>
            <input type="text" name="hinh_anh">

            <button type="submit" name="post_news">Đăng bài</button>
        </form>
    </div>

    <div class="news-list">
        <h2>Danh sách bài đăng</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
        <div class="news-item">
            <h3><?php echo htmlspecialchars($row['tieu_de']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($row['noi_dung'])); ?></p>
            <?php if (!empty($row['hinh_anh'])) { ?>
            <img src="<?php echo $row['hinh_anh']; ?>" alt="Hình ảnh" style="max-width:29%;">
            <?php } ?>
            <p>
                <em>Đăng bởi: <?php echo htmlspecialchars($row['ten_dang_nhap']); ?> vào
                    <?php echo $row['ngay_dang']; ?></em>
                | <a class="action"
                    href="http://localhost/high-school/src/routes/menu/id-tintuc.php?id=<?php echo $row['id']; ?>">Xem
                    chi tiết</a>
                | <a class="action" href="../menu/tintuc_edit.php?id=<?php echo $row['id']; ?>">Sửa</a>
                | <a class="action" href="../menu/tintuc_delete.php?id=<?php echo $row['id']; ?>"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">Xóa</a>
            </p>
        </div>
        <?php
            }
        } else {
            echo "<p>Không có bài đăng nào.</p>";
        }
        ?>
    </div>


</body>

</html>