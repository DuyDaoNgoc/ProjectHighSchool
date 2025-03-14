<?php include_once '../DATABASE/them-khoa-hoc.php' ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Khoá Học</title>
    <?php include '../DATABASE/body.php' ?>
    <style>
    form {
        max-width: 600px;
    }

    label {
        display: block;
        margin-top: 10px;
    }

    input[type="text"],
    input[type="number"],
    select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        margin-top: 15px;
        padding: 10px 15px;
    }

    .thongbao {
        margin-top: 20px;
        color: green;
        text-align: center;
    }

    .form-them-khoa-hoc {
        box-shadow: 1px 1px 6px -1px;
        padding: 20px;
        margin: 24px auto;
    }
    </style>
</head>

<body>
    <?php include '../background/header.php' ?>
    <a href="../menu/index.php" class="return-home"><img src="http://localhost/high-school/public/asset/icon/right.svg"
            alt=""> </a>
    <h1 class="bold">Thêm Khoá Học</h1>

    <form action="" method="post" class="form-them-khoa-hoc">
        <?php
    if(isset($thongbao)){
        echo '<p class="thongbao">' . htmlspecialchars($thongbao) . '</p>';
    }
    ?>
        <label for="ten_khoahoc">Tên khoá học:</label>
        <input type="text" id="ten_khoahoc" name="ten_khoahoc" required>

        <label for="hinh_anh">Đường dẫn hình ảnh:</label>
        <input type="text" id="hinh_anh" name="hinh_anh" required>

        <label for="cap_hoc">Cấp học:</label>
        <select id="cap_hoc" name="cap_hoc">
            <option value="Đại học">Đại học</option>
            <option value="Thạc sĩ">Thạc sĩ</option>
            <option value="Tiến sĩ">Tiến sĩ</option>
        </select>

        <label for="gia_tien">Giá tiền (VNĐ):</label>
        <input type="number" step="0.01" id="gia_tien" name="gia_tien" required>

        <label for="thoi_gian_hoc">Thời gian học (năm):</label>
        <input type="number" id="thoi_gian_hoc" name="thoi_gian_hoc" required>

        <label for="hinh_thuc_hoc">Hình thức học:</label>
        <input type="text" id="hinh_thuc_hoc" name="hinh_thuc_hoc" required>

        <input type="submit" value="Thêm khoá học">
    </form>
    <?php include_once '../background/footer.php' ?>
</body>

</html>