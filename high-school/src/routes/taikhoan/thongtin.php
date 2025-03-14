    <?php
    session_start();
    include '../DATABASE/sql.php';


    if (!isset($_SESSION['user_id']) || !isset($_SESSION['vai_tro'])) {
        header("Location: ../taikhoan/dangnhap.php");
        exit();
    }

    $user_id = intval($_SESSION['user_id']);
    $role = $_SESSION['vai_tro'];

    if ($role === 'HocSinh') {
        // Không lấy hs.avatar nữa vì cột này không tồn tại
        $sql = "SELECT nd.*, hs.ho_ten AS ten, hs.email AS email, hs.gioi_tinh, 
                    lh.ten_lop, lh.nganh
                FROM nguoi_dung nd
                JOIN hocsinh hs ON nd.id_lien_ket = hs.id
                LEFT JOIN lophoc lh ON hs.lophoc_id = lh.id
                WHERE nd.id = ?";
    } elseif ($role === 'GiaoVien') {
        $sql = "SELECT nd.*, gv.ho_ten AS ten, gv.email AS email, gv.gioi_tinh 
                FROM nguoi_dung nd
                JOIN giaovien gv ON nd.id_lien_ket = gv.id
                WHERE nd.id = ?";
    } elseif ($role === 'Admin') {
        $sql = "SELECT nd.*, ad.ho_ten AS ten, ad.email AS email, ad.avatar AS ad_avatar
                FROM nguoi_dung nd
                JOIN admin ad ON nd.id_lien_ket = ad.id
                WHERE nd.id = ?";
    } else {
        die("Vai trò không hợp lệ.");
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        die("Không tìm thấy thông tin người dùng.");
    }

    // Xác định avatar
    if ($role === 'HocSinh') {
        $avatar = (isset($user['gioi_tinh']) && strtolower($user['gioi_tinh']) === 'nữ')
                ? "http://localhost/high-school/public/asset/icon/avatar-nu.svg"
                : "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
    } elseif ($role === 'GiaoVien') {
        $avatar = (isset($user['gioi_tinh']) && strtolower($user['gioi_tinh']) === 'nữ')
                ? "http://localhost/high-school/public/asset/icon/avatar-nu.svg"
                : "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
    } else { // Admin
        $avatar = !empty($user['ad_avatar']) 
                ? $user['ad_avatar'] 
                : "http://localhost/high-school/public/asset/icon/avatar-nam.svg";
    }
    ?>
    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <title>Dashboard Cá Nhân - Trường Học ND</title>
        <?php include '../DATABASE/body.php'; ?>
        <style>
        .dashboard {
            width: 54%;
            margin: 30px 0;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: flex;
            background-color: #f9f9f9;
            align-items: center;
            justify-content: space-around;
        }

        .dashboard img {
            max-width: 150px;
            border-radius: 50%;
            border: 1px solid #000;
        }
        </style>
    </head>

    <body>
        <?php include '../background/header.php'; ?>
        <div class="dashboard">
            <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar của người dùng">
            <div>
                <h1>Họ tên: <?php echo htmlspecialchars($user['ho_ten'] ?? 'Không có thông tin'); ?></h1>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                <p><strong>Vai trò:</strong> <?php echo htmlspecialchars($role); ?></p>
                <p><strong>ID (nguoi_dung):</strong> <?php echo htmlspecialchars($user_id); ?></p>
                <?php if ($role === 'HocSinh'): ?>
                <p><strong>Lớp:</strong> <?php echo htmlspecialchars($user['ten_lop'] ?? 'Chưa có lớp'); ?></p>
                <p><strong>Ngành:</strong> <?php echo htmlspecialchars($user['nganh'] ?? 'Chưa có ngành'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </body>

    </html>