<?php

session_set_cookie_params(0, "/");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../DATABASE/sql.php';




// ⚠️ Không xuất HTML trước phần này
if (!isset($_SESSION['user_id']) || !isset($_SESSION['vai_tro']) || !in_array($_SESSION['vai_tro'], ['GiaoVien', 'HocSinh', 'Admin'])) {
    header("Location: ../taikhoan/dangnhap.php");
    exit();

}



?>

<script>
// Toggle menu khi ấn vào avatar
function toggleDropdown() {
    document.getElementById("userDropdown").classList.toggle("show");
}
// Đóng menu nếu click ra ngoài
window.onclick = function(event) {
    if (!event.target.matches('.avatar-btn')) {
        var dropdowns = document.getElementsByClassName("user-dropdown");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains("show")) {
                openDropdown.classList.remove("show");
            }
        }
    }
};
</script>
<style>
.user-menu {
    position: relative;
    display: inline-block;
}

.user-dropdown {
    display: none;
    position: absolute;
    right: 0;
    background-color: #fff;
    min-width: 160px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 5px;
}

.user-dropdown.show {
    display: block;
}

.user-dropdown li {
    padding: 10px;
    list-style: none;
    border-bottom: 1px solid #ddd;
}

.user-dropdown li:last-child {
    border-bottom: none;
}

.user-dropdown li a {
    color: #000;
    text-decoration: none;
    display: block;
}

.user-dropdown li a:hover {
    background-color: #f1f1f1;
}

.avatar-btn {
    cursor: pointer;
    width: 40px;
    height: 40px;
    border-radius: 50%;
}
</style>
</head>

<body>
    <!-- <div id="loadingOverlay">
        <div class="spinner">
            <div>
                <div className="loading">

                    <span style="--i: 1">L</span>
                    <span style="--i: 2">o</span>
                    <span style="--i: 3">a</span>
                    <span style="--i: 4">d</span>
                    <span style="--i: 5">i</span>
                    <span style="--i: 6">n</span>
                    <span style="--i: 7">g</span>
                    <span style="--i: 8">.</span>
                    <span style="--i: 9">.</span>
                    <span style="--i: 10 ">.</span>
                </div>

                <img src="http://localhost/high-school/public/asset/img/gif/6oa.gif" alt="Loading..." />
            </div>

        </div>
    </div> -->
    <header>
        <div class="infomation">
            <p><b>Địa chỉ:</b> 99 Tô Hiến Thành, TP.Đà Nẵng</p>
            <p><b>Điện thoại:</b> 0123456789</p>
            <p><b>Email:</b> <a href="#">Kinbingo@gmail.com</a></p>
        </div>
        <div class="search">
            <div class="logo">
                <img src="http://localhost/high-school/public/asset/logo/logo-high-school.png" alt="Logo">
                <h1>Trường Đại Học ND</h1>
            </div>
            <form action="" method="post" class="form-search">
                <input type="text" name="search" id="search" placeholder="Tìm kiếm...">
                <button type="submit" class="btn-search">
                    <img src="http://localhost/high-school/public/asset/icon/search.svg" alt="Search">
                </button>
            </form>
        </div>
    </header>
    <div class="nav-ul">
        <nav>
            <ul class="nav-menu">
                <li><a href="../menu/index.php">Trang Chủ</a></li>
                <li><a href="../menu/gioithieu.php">Giới Thiệu</a></li>
                <li><a href="../menu/tintuc.php">Tin Tức</a></li>
                <li><a href="../menu/lienhe.php">Liên Hệ</a></li>
                <li>
                    <a href="#">Tuyển sinh</a>
                    <ul class="sub-menu">
                        <li><a href="#">Cổng sinh viên</a></li>
                        <li><a href="#">Thông tin tuyển sinh</a></li>
                        <li><a href="#">Hỗ trợ tuyển sinh</a></li>
                    </ul>
                </li>
                <?php

        if (isset($_SESSION['vai_tro']) && in_array($_SESSION['vai_tro'], [ 'GiaoVien', 'Admin'])) {

            echo "<li>
            
            <a>Quản lí</a>
            <ul class='sub-menu'>
            <li><a href='../quan-tri/admin.php'>Quản Lý</a></li>
                       <li><a href='../baiviet/tintuc_chitiet.php'>Thêm bài viết</a></li>
                       <li><a href='../ThemKhoaHoc/ThemKhoaHoc.php'>Thêm khoá học</a></li>
                    <li> <a href = '../lophoc/tao-lop-hoc.php'>Tạo lớp học </a></li>
                       </ul>
            
            </li>";
        }
        ?>
            </ul>
        </nav>
        <nav>
            <ul class="nav-li">
                <?php
        if (isset($_SESSION['user_id']) && isset($_SESSION['vai_tro'])) {
            $user_id = intval($_SESSION['user_id']);
            $vai_tro = $_SESSION['vai_tro'];
            
            $query_id = (isset($_SESSION['id_lien_ket']) && intval($_SESSION['id_lien_ket']) > 0)
                        ? intval($_SESSION['id_lien_ket'])
                        : $user_id;
            
            if ($vai_tro == "Admin") {
                $sql = "SELECT ho_ten, avatar FROM admin WHERE id = ?";
                $query_id = $user_id;
            } elseif ($vai_tro == "HocSinh") {
                $sql = "SELECT ho_ten, gioi_tinh, ten_dang_nhap FROM hocsinh WHERE id = ?";
            } elseif ($vai_tro == "GiaoVien") {
                $sql = "SELECT ho_ten, gioi_tinh, ten_dang_nhap FROM giaovien WHERE id = ?";
            } else {
                die("Vai trò không hợp lệ!");
            }
            
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Lỗi chuẩn bị truy vấn: " . $conn->error);
            }
            $stmt->bind_param("i", $query_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if ($vai_tro == "Admin") {
                    $avatar = !empty($user['avatar']) ? $user['avatar'] : "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
                } else {
                    // Với HocSinh và GiaoVien: nếu cột gioi_tinh có giá trị 'Nữ', dùng avatar nữ; ngược lại dùng avatar nam
                    if (isset($user['gioi_tinh']) && strtolower($user['gioi_tinh']) === 'nữ') {
                        $avatar = "http://localhost/high-school/public/asset/icon/avatar-nu.svg";
                    } else {
                        $avatar = "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
                    }
                }
                $ho_ten = htmlspecialchars($user['ho_ten']);
                $ten_dang_nhap = isset($user['ten_dang_nhap']) ? htmlspecialchars($user['ten_dang_nhap']) : $ho_ten;
                
                echo "<li class='user-menu'>";
                echo "<img src='$avatar' alt='Avatar' class='avatar-btn' onclick='toggleDropdown()'>";
                echo "<ul id='userDropdown' class='user-dropdown'>";
                echo "<li><a href='../taikhoan/thongtin.php'>Thông tin cá nhân</a></li>";
                echo "<li><a href='../taikhoan/doimatkhau.php'>Lịch học</a></li>";
                echo "<li><a href='../taikhoan/dangxuat.php'>Đăng xuất</a></li>";
                echo "</ul>";
                echo "</li>";
                echo "<li>$ho_ten</li>";
            }
            $stmt->close();
        } else {
            echo "<li><a href='../taikhoan/dangnhap.php'>Đăng nhập</a></li>";
            echo "<li><a href='../taikhoan/dangki.php'>Đăng kí</a></li>";
        }
        ?>
            </ul>
        </nav>
    </div>

    <?php ob_end_flush(); // Xóa bộ đệm và gửi nội dung ra trình duyệt
 ?>