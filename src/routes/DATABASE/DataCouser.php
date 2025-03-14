<?php

$dsn = 'mysql:host=localhost;dbname=truonghoc;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

    // Lấy danh sách giáo viên
    $sql_gv = "SELECT g.id, g.ho_ten, g.que_quan, g.nam_sinh, g.chuyen_nganh, g.trinh_do_hoc_van, 
                      g.mat_khau, g.trang_thai, g.vai_tro, g.gioi_tinh, nd.ten_dang_nhap
               FROM giaovien g
               JOIN nguoi_dung nd ON g.id = nd.id_lien_ket
               WHERE g.vai_tro = 'GiaoVien'";
    $stmt_gv = $pdo->prepare($sql_gv);
    $stmt_gv->execute();
    $result_gv = $stmt_gv->fetchAll();

    // Lấy tất cả khóa học
    $sql = "SELECT * FROM khoahoc";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $courses = $stmt->fetchAll();

    // Lấy danh sách khoá học duy nhất
    $sql_courses = "SELECT DISTINCT ten_khoahoc, cap_hoc, dieu_kien FROM khoahoc ORDER BY ten_khoahoc ASC";
    $stmt_courses = $pdo->prepare($sql_courses);
    $stmt_courses->execute();
    $course_options = $stmt_courses->fetchAll();
    
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

?>