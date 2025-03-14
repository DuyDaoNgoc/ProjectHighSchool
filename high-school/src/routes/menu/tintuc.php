<?php 
include '../DATABASE/sql.php';
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Trường Học ND</title>
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
    <?php 
    include '../background/header.php';
    ?>

    <div class="main">

        <div style="width: 100%;">

            <div>

                <section class="content">
                    <h2>Tin tức mới nhất</h2>
                    <ul class="ul-list">
                        <?php
                        $sql = "SELECT * FROM tintuc WHERE trang_thai = 'Hiển thị' ORDER BY ngay_dang DESC LIMIT 5";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()){
                                ?>
                        <li>
                            <a href="../menu/id-tintuc.php?id=<?php echo $row['id']; ?>">
                                <div class="tin_tuc">
                                    <div class="anh_asset">
                                        <img src="<?php echo $row['hinh_anh']; ?>"
                                            alt="<?php echo htmlspecialchars($row['tieu_de']); ?>">
                                    </div>
                                    <p><?php echo $row['tieu_de']; ?></p>
                                </div>
                            </a>
                        </li>
                        <?php
                            }
                        } else {
                            echo "<li>Không có tin tức mới.</li>";
                        }
                        ?>
                    </ul>
                </section>

            </div>

        </div>

    </div>

    <?php 
    include '../background/footer.php';
    ?>
</body>

</html>