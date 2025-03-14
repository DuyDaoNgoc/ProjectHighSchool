<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Trường Học ND</title>
    <link rel="stylesheet" href="http://localhost/high-school/public/css/reset.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/style.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/gerenal.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/dataTab.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/tabs.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/tuvan.css">
    <link rel="stylesheet" href="http://localhost/high-school/public/css/course.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Các font chữ -->
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="http://localhost/high-school/public/js/ThongTinTuyenSinh.js"></script>
    <script src="http://localhost/high-school/public/js/tabs.js"></script>
    <script src="http://localhost/high-school/public/js/onclick-course.js"></script>

    <!-- CSS cho overlay loading -->

<body>
    <?php include '../background/header.php'; ?>




    <div class="main">
        <div></div>
        <div class="container">
            <div style="display: grid;">
                <?php include '../background/silde.php' ?>
                <div>
                    <section class="content-1">
                        <h1 class="bold">Lý do lựa chọn <span style="color: #EC2227;">ND</span></h1>
                        <div class="content-1-item">
                            <ul class="content-1-list">
                                <li>
                                    <div class="post-list-img">
                                        <img src="http://localhost/high-school/public/asset/icon/cooperation.svg"
                                            alt="">
                                    </div>
                                    <h3>Dự án hợp tác giáo dục đại học giữa Việt Nam và Pháp</h3>
                                    <p>Trường đại học công lập quốc tế tiên phong được thành lập theo Hiệp định Liên
                                        chính phủ giữa Việt Nam và Pháp</p>
                                </li>
                                <li>
                                    <div class="post-list-img">
                                        <img src="http://localhost/high-school/public/asset/icon/training.svg" alt="">
                                    </div>
                                    <h3>Chương trình đào tạo chuẩn châu Âu</h3>
                                    <p>Chương trình đại học được tổ chức kiểm định hàng đầu châu Âu công nhận đạt chuẩn
                                    </p>
                                </li>
                                <li>
                                    <div class="post-list-img">
                                        <img src="http://localhost/high-school/public/asset/icon/airplane.svg" alt="">
                                    </div>
                                    <h3>Cơ hội trao đổi và thực tập nước ngoài đa dạng</h3>
                                    <p>Trải nghiệm môi trường quốc tế tại các trường đại học, tổ chức nghiên cứu, doanh
                                        nghiệp khắp thế giới.</p>
                                </li>
                                <li>
                                    <div class="post-list-img">
                                        <img src="http://localhost/high-school/public/asset/icon/teacher.svg" alt="">
                                    </div>
                                    <h3>Đội ngũ giảng viên trình độ cao</h3>
                                    <p>Giảng viên là các nhà khoa học tận tâm, giàu kinh nghiệm từ Việt Nam, Pháp và
                                        nhiều quốc gia khác</p>
                                </li>
                            </ul>
                        </div>
                        <button>Xem thêm</button>
                        <div class="TOP">
                            <h1 class="title">Những con số nổi bật</h1>
                            <div class="top-number">
                                <div class="top-number-high-school">
                                    <h1>30 +</h1>
                                    <p>Trường đại học, tổ chức nghiên cứu Pháp hỗ trợ đào tạo và nghiên cứu</p>
                                </div>
                                <div class="top-number-high-school">
                                    <h1>84%</h1>
                                    <p>Giảng viên đạt trình độ tiến sĩ trở lên...</p>
                                </div>
                                <div class="top-number-high-school">
                                    <h1>200+</h1>
                                    <p>Đơn vị nhận thực tập tại hơn 20 quốc gia</p>
                                </div>
                                <div class="top-number-high-school">
                                    <h1>97%</h1>
                                    <p>Sinh viên có việc làm hoặc học tiếp lên</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="background-hr"><span></span></div>
                    <?php include '../content/ChuongTrinhDaoTao.php'; ?>
                    <div class="background-hr"><span></span></div>
                    <?php include '../content/ThongTinTuyenSinh.php'; ?>
                    <div class="background-hr"><span></span></div>
                    <?php include '../taikhoan/dang-ki-tu-van.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include '../background/footer.php'; ?>
</body>

</html>