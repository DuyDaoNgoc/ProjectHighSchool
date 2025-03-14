-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 05, 2025 lúc 06:36 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `truonghoc1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `ten_dang_nhap` varchar(255) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `vai_tro` varchar(50) NOT NULL DEFAULT 'Admin',
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `ho_ten`, `ten_dang_nhap`, `mat_khau`, `email`, `vai_tro`, `avatar`) VALUES
(1, 'admin', 'admin', '$2y$10$nbDBISAbf.DUj8QT0BfxX.PIyPvgnB9gqfbBkl2mqw4Hp0S9QrAxu', 'admin@example.com', 'Admin', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangky_bituchoi`
--

CREATE TABLE `dangky_bituchoi` (
  `id` int(11) NOT NULL,
  `hocsinh_id` int(11) NOT NULL,
  `khoahoc_id` int(11) NOT NULL,
  `ten_khoahoc` varchar(255) NOT NULL,
  `ngay_tu_choi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dangky_bituchoi`
--

INSERT INTO `dangky_bituchoi` (`id`, `hocsinh_id`, `khoahoc_id`, `ten_khoahoc`, `ngay_tu_choi`) VALUES
(1, 14, 4, 'Công nghệ sinh học - Phát triển thuốc', '2025-03-03 11:41:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangky_khoahoc`
--

CREATE TABLE `dangky_khoahoc` (
  `id` int(11) NOT NULL,
  `hocsinh_id` int(11) NOT NULL,
  `khoahoc_id` int(11) NOT NULL,
  `lophoc_id` int(11) DEFAULT NULL,
  `ten_khoahoc` varchar(255) NOT NULL,
  `trang_thai` varchar(20) DEFAULT 'Chờ duyệt',
  `ho_ten` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dang_ky_tu_van`
--

CREATE TABLE `dang_ky_tu_van` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL,
  `que_quan` varchar(255) NOT NULL,
  `nganh_quan_tam` varchar(255) NOT NULL,
  `ngay_dang` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dang_ky_tu_van`
--

INSERT INTO `dang_ky_tu_van` (`id`, `ho_ten`, `email`, `so_dien_thoai`, `que_quan`, `nganh_quan_tam`, `ngay_dang`) VALUES
(27, 'Lê Văn Lợi', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ Kỹ thuật Cơ điện tử', '2025-03-05 17:26:56'),
(28, 'Lê Văn Lợi', 'tricklo22222@outlook.com', '0905536704', 'Đà Nẵng', 'Vũ trụ: Viễn thám – Vật lý thiên văn – Công nghệ vệ tinh (SPACE)', '2025-03-05 17:27:07'),
(29, 'Lê Văn Lợi', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ Kỹ thuật Cơ điện tử', '2025-03-05 17:29:29'),
(30, 'Lê Văn Lợi', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ Kỹ thuật Cơ điện tử', '2025-03-05 17:30:54'),
(31, 'Lê Văn Lợi', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ Kỹ thuật Cơ điện tử', '2025-03-05 17:31:13'),
(32, 'Lê Văn Lợi', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ Kỹ thuật Cơ điện tử', '2025-03-05 17:32:23'),
(33, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Vũ trụ: Viễn thám – Vật lý thiên văn – Công nghệ vệ tinh (SPACE)', '2025-03-05 17:32:32'),
(34, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Vũ trụ: Viễn thám – Vật lý thiên văn – Công nghệ vệ tinh (SPACE)', '2025-03-05 17:32:33'),
(35, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Vũ trụ: Viễn thám – Vật lý thiên văn – Công nghệ vệ tinh (SPACE)', '2025-03-05 17:32:34'),
(36, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Vũ trụ: Viễn thám – Vật lý thiên văn – Công nghệ vệ tinh (SPACE)', '2025-03-05 17:32:34'),
(37, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Vũ trụ: Viễn thám – Vật lý thiên văn – Công nghệ vệ tinh (SPACE)', '2025-03-05 17:32:34'),
(38, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Vũ trụ: Viễn thám – Vật lý thiên văn – Công nghệ vệ tinh (SPACE)', '2025-03-05 17:32:34'),
(39, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Vũ trụ: Viễn thám – Vật lý thiên văn – Công nghệ vệ tinh (SPACE)', '2025-03-05 17:32:35'),
(40, 'Lê Văn Lợi', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ Kỹ thuật Cơ điện tử', '2025-03-05 17:33:01'),
(41, 'Lê Văn Lợi', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ Kỹ thuật Cơ điện tử', '2025-03-05 17:33:26'),
(42, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ thông tin - Truyền thông', '2025-03-05 17:33:40'),
(43, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ thông tin - Truyền thông', '2025-03-05 17:33:41'),
(44, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ thông tin - Truyền thông', '2025-03-05 17:33:41'),
(45, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ thông tin - Truyền thông', '2025-03-05 17:33:41'),
(46, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ thông tin - Truyền thông', '2025-03-05 17:33:41'),
(47, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ thông tin - Truyền thông', '2025-03-05 17:33:41'),
(48, 'Phương bóng bang', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ thông tin - Truyền thông', '2025-03-05 17:33:41'),
(49, 'Lê Văn Lợi', 'kinbingo18@gmail.com', '0905536704', 'Đà Nẵng', 'Công nghệ Kỹ thuật Cơ điện tử', '2025-03-05 17:33:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giaovien`
--

CREATE TABLE `giaovien` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `dien_thoai` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `que_quan` varchar(255) DEFAULT NULL,
  `nam_sinh` date NOT NULL,
  `chuyen_nganh` varchar(255) NOT NULL,
  `trinh_do_hoc_van` varchar(50) DEFAULT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `trang_thai` enum('Chờ duyệt','Đã duyệt') NOT NULL DEFAULT 'Chờ duyệt',
  `gioi_tinh` varchar(10) NOT NULL,
  `ten_dang_nhap` varchar(100) NOT NULL,
  `vai_tro` varchar(50) NOT NULL DEFAULT 'GiaoVien'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giaovien`
--

INSERT INTO `giaovien` (`id`, `ho_ten`, `dien_thoai`, `email`, `que_quan`, `nam_sinh`, `chuyen_nganh`, `trinh_do_hoc_van`, `mat_khau`, `trang_thai`, `gioi_tinh`, `ten_dang_nhap`, `vai_tro`) VALUES
(1, 'truong nguyen anh', 'Chưa cập nhật', 'kinbingo@gmail.com', '590/3 Núi Thành', '2004-03-02', 'Công nghệ thông tin', 'Thạc sĩ', '$2y$10$ebwW8EK52vrfVn3c2q/GFON1iBtyGLC6oQL.qs2PEE0OZ1TqEX9Pu', 'Đã duyệt', 'Nam', 'duy04', 'GiaoVien');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hocsinh`
--

CREATE TABLE `hocsinh` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `que_quan` varchar(255) DEFAULT NULL,
  `nam_sinh` date NOT NULL,
  `trinh_do_hoc_van` varchar(50) DEFAULT NULL,
  `lop_id` int(11) DEFAULT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `trang_thai` enum('Chờ duyệt','Đã duyệt') NOT NULL DEFAULT 'Chờ duyệt',
  `gioi_tinh` varchar(10) NOT NULL,
  `ngay_sinh` date NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `vai_tro` varchar(50) NOT NULL DEFAULT 'HocSinh',
  `ten_dang_nhap` varchar(100) NOT NULL,
  `hanh_kiem` varchar(50) DEFAULT 'Chưa có hạnh kiểm',
  `diem` varchar(20) DEFAULT 'Chưa có điểm',
  `ten_lop` varchar(50) NOT NULL,
  `nien_khoa` varchar(20) DEFAULT NULL,
  `nganh` varchar(255) NOT NULL DEFAULT 'Chưa xác định',
  `khoahoc_id` int(11) DEFAULT NULL,
  `kihoc_id` int(11) DEFAULT NULL,
  `dien_thoai` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `chuyen_nganh` varchar(255) NOT NULL DEFAULT 'Chưa cập nhật',
  `lophoc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hocsinh`
--

INSERT INTO `hocsinh` (`id`, `ho_ten`, `que_quan`, `nam_sinh`, `trinh_do_hoc_van`, `lop_id`, `mat_khau`, `trang_thai`, `gioi_tinh`, `ngay_sinh`, `admin_id`, `vai_tro`, `ten_dang_nhap`, `hanh_kiem`, `diem`, `ten_lop`, `nien_khoa`, `nganh`, `khoahoc_id`, `kihoc_id`, `dien_thoai`, `email`, `chuyen_nganh`, `lophoc_id`) VALUES
(10, 'Cô Tú', 'Đà Nẵng', '0000-00-00', 'Cao đẳng', NULL, '', 'Chờ duyệt', 'Nữ', '1999-03-03', NULL, 'HocSinh', 'mina', 'Chưa có hạnh kiểm', 'Chưa có điểm', '', NULL, 'Chưa xác định', NULL, NULL, '0905536709', 'kinbingo18@gmail.com', 'Chưa cập nhật', NULL),
(13, 'Cô Tú', 'Đà Nẵng', '0000-00-00', 'Chưa cập nhật', NULL, '', 'Chờ duyệt', 'Nữ', '2025-03-03', NULL, 'HocSinh', 'chauanh02', 'Chưa có hạnh kiểm', 'Chưa có điểm', '', NULL, 'Chưa xác định', NULL, NULL, '0905536709', 'tricklo22222@outlook.com', 'Chưa cập nhật', NULL),
(14, 'anh', 'Huế', '0000-00-00', 'Chưa cập nhật', NULL, '', '', 'Nữ', '2025-03-03', NULL, 'HocSinh', 'ALon', 'Chưa có hạnh kiểm', 'Chưa có điểm', '', NULL, 'Chưa xác định', NULL, NULL, '0905536709', 'thanhdubai@gmail.com', 'Chưa cập nhật', NULL),
(15, 'Phương', 'Đà Nẵng', '0000-00-00', 'Chưa cập nhật', NULL, '', 'Chờ duyệt', 'Nữ', '2005-03-03', NULL, 'HocSinh', 'phuong05', 'Chưa có hạnh kiểm', 'Chưa có điểm', '', NULL, 'Chưa xác định', NULL, NULL, '0905536709', 'phuong@gmail.com', 'Chưa cập nhật', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoahoc`
--

CREATE TABLE `khoahoc` (
  `id` int(11) NOT NULL,
  `ten_khoahoc` varchar(255) NOT NULL,
  `hinh_anh` varchar(255) NOT NULL,
  `cap_hoc` varchar(50) NOT NULL,
  `gia_tien` decimal(10,2) NOT NULL,
  `thoi_gian_hoc` int(11) NOT NULL,
  `hinh_thuc_hoc` varchar(100) NOT NULL,
  `dieu_kien` varchar(255) NOT NULL DEFAULT 'Không có điều kiện',
  `nganh` varchar(50) NOT NULL DEFAULT 'Chưa xác định'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khoahoc`
--

INSERT INTO `khoahoc` (`id`, `ten_khoahoc`, `hinh_anh`, `cap_hoc`, `gia_tien`, `thoi_gian_hoc`, `hinh_thuc_hoc`, `dieu_kien`, `nganh`) VALUES
(1, 'Công nghệ Kỹ thuật Cơ điện tử', 'http://localhost/high-school/public/asset/img/khoahoc/cong-nghe-co-dien-tu.jpg', 'Đại học', 100.00, 4, 'Chính quy', 'tốt nghiệp cấp 3', 'cntt'),
(4, 'Công nghệ sinh học - Phát triển thuốc', 'http://localhost/high-school/public/asset/img/khoahoc/Cong-nghe-sinh-hoc.jpg', 'Đại học', 4000.00, 4, 'Do đặc tính của chương trình cử nhân, nội dung các khóa học chuyên môn được thiết kế nhằm đảm bảo cu', 'Không có điều kiện', 'Chưa xác định'),
(5, 'Khoa Học Công Nghệ Thực Phẩm', 'http://localhost/high-school/public/asset/img/khoahoc/khoa-hoc-cong-nghe-thuc-pham.jpg', 'Đại học', 4000.00, 4, 'Khoa học và công nghệ thực phẩm ngày nay đóng vai trò cực kỳ quan trọng trong việc phát triển, đa dạ', 'Không có điều kiện', 'Chưa xác định'),
(6, 'Khoa học và Công nghệ y khoa', 'http://localhost/high-school/public/asset/img/khoahoc/y-khoa.jpg', 'Đại học', 4000.00, 4, 'Khoa học Y sinh là ngành khoa học nghiên cứu về cơ thể sống và sản xuất những sản phẩm nguồn gốc sin', 'Không có điều kiện', 'Chưa xác định'),
(7, 'Công nghệ thông tin - Truyền thông', 'http://localhost/high-school/public/asset/img/khoahoc/truyen-thong.jpg', 'Đại học', 4000.00, 4, 'Công nghệ Thông tin Truyền thông thường (ICT) được viết tắt từ Information & Communication Technolog', 'Không có điều kiện', 'Chưa xác định'),
(8, 'Vũ trụ: Viễn thám – Vật lý thiên văn – Công nghệ vệ tinh (SPACE)', 'http://localhost/high-school/public/asset/img/thacsi/khoa-hoc-vat-lieu-tien-tien-va-cong-nghe-nano-(AMSN).jpg', 'Thạc sĩ', 4000.00, 4, 'Công nghệ kỹ thuật điện, điện tử được nhận định là một ngành không bao giờ “lỗi mốt”. Trong những nă', 'Không có điều kiện', 'Chưa xác định');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kihoc`
--

CREATE TABLE `kihoc` (
  `id` int(11) NOT NULL,
  `nam_hoc` varchar(50) NOT NULL,
  `ki` varchar(50) NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date NOT NULL,
  `trang_thai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `kihoc`
--

INSERT INTO `kihoc` (`id`, `nam_hoc`, `ki`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`) VALUES
(1, '2025-2026', 'Học kỳ 1', '2025-09-01', '2025-12-31', 'Đang hoạt động');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lophoc`
--

CREATE TABLE `lophoc` (
  `id` int(11) NOT NULL,
  `ten_lop` varchar(50) NOT NULL,
  `si_so` int(11) NOT NULL DEFAULT 0,
  `so_hoc_sinh_vang` int(11) NOT NULL DEFAULT 0,
  `hoc_ky` varchar(50) NOT NULL,
  `nam_hoc` varchar(50) NOT NULL,
  `nganh` varchar(50) NOT NULL,
  `kihoc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lophoc`
--

INSERT INTO `lophoc` (`id`, `ten_lop`, `si_so`, `so_hoc_sinh_vang`, `hoc_ky`, `nam_hoc`, `nganh`, `kihoc_id`) VALUES
(4, 'Công nghệ Kỹ thuật Cơ điện tử', 0, 0, '', '', '', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ten_dang_nhap` varchar(255) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `vai_tro` enum('Admin','GiaoVien','HocSinh') NOT NULL,
  `id_lien_ket` int(11) DEFAULT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `sdt` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ten_dang_nhap`, `mat_khau`, `email`, `avatar`, `vai_tro`, `id_lien_ket`, `ho_ten`, `sdt`) VALUES
(1, 'duy04', '$2y$10$ebwW8EK52vrfVn3c2q/GFON1iBtyGLC6oQL.qs2PEE0OZ1TqEX9Pu', '', NULL, 'GiaoVien', 1, '', ''),
(2, 'duyo', '$2y$10$JuTH3PwzWcU3K1fyZbJZ4eowldlRaDopmG90N9CfcZ0UcHZXEISH2', 'kinbingo48@gmail.com', 'default.jpg', 'HocSinh', NULL, '', ''),
(5, 'duyo', '$2y$10$WLYTXtgP6ZVRx/ivY4VBA.uXgrhu6FaIhuwXRGisWwQIikgl7e/4W', 'tricklo22222@outlook.com', 'default.jpg', 'HocSinh', 6, '', ''),
(6, 'duyo', '$2y$10$pw153xiFi4TVrcWLMaGOGOIQwIAe3jYNU1oINxa6aSwQ.LYOffiCO', 'kinbingo48@gmail.com', 'default.jpg', 'HocSinh', 9, '', ''),
(9, 'mina', '$2y$10$tMqye/KOF6a06gR.pm9TmeYZHImHCyuFpADuEQgtwb33duwwa1YXK', 'kinbingo18@gmail.com', NULL, 'HocSinh', 10, '', ''),
(10, 'duyl04', '$2y$10$5L1aEJVU0SI2F1RLdOmXmeqmMI2Vpc6tDcXPJ9kNPBBCaIS/LFtFG', 'kinbingo@gmail.com', NULL, 'HocSinh', 11, '', ''),
(11, 'chauanh01', '$2y$10$tYPQq50DCfDKuEByCS71lem1J3BQjPtv26pXvXbr0UoFrnjI6p1Z6', 'kinbingo18@gmail.com', NULL, 'HocSinh', 0, '', ''),
(12, 'chauanh02', '$2y$10$5XIsX4bkxsKlX.oo8FrGsep3NX4Q7yJidrDH2G0eBSSeS18REJIy6', 'tricklo22222@outlook.com', NULL, 'HocSinh', 13, '', ''),
(13, 'ALon', '$2y$10$u1ddzlPK6hlSTnxR0.gzJ.jje8aiW5DeA8ufyUpMs9ubCE53Bxvx.', 'thanhdubai@gmail.com', NULL, 'HocSinh', 14, '', ''),
(14, 'phuong05', '$2y$10$0DSFNbrDX/ZgVyI8wypV4u.Z1KZWbSON85kw6qzfECEonFkvQH/fe', 'phuong@gmail.com', NULL, 'HocSinh', 15, '', ''),
(15, 'anh09102005', '$2y$10$BpGyd00Y3NshaMFwMejHeeAEa.j/vXCxhgLWSvComcDQh0qZIiRaW', 'thanhdubai@gmail.com', NULL, 'HocSinh', 0, '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tintuc`
--

CREATE TABLE `tintuc` (
  `id` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `noi_dung` text NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `ngay_dang` datetime DEFAULT current_timestamp(),
  `trang_thai` enum('Hiển thị','Ẩn') DEFAULT 'Hiển thị',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tintuc`
--

INSERT INTO `tintuc` (`id`, `tieu_de`, `noi_dung`, `hinh_anh`, `ngay_dang`, `trang_thai`, `user_id`) VALUES
(1, 'USTH công bố đề thi mẫu của bài kiểm tra kiến thức phục vụ kỳ thi đánh giá năng lực năm 2025', 'tuyển sinh', 'http://localhost/high-school/public/asset/img/tuyen_sinh.jpg', '2025-03-03 02:33:26', 'Hiển thị', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dangky_bituchoi`
--
ALTER TABLE `dangky_bituchoi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hocsinh_id` (`hocsinh_id`),
  ADD KEY `khoahoc_id` (`khoahoc_id`);

--
-- Chỉ mục cho bảng `dangky_khoahoc`
--
ALTER TABLE `dangky_khoahoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hocsinh_id` (`hocsinh_id`),
  ADD KEY `khoahoc_id` (`khoahoc_id`),
  ADD KEY `lophoc_id` (`lophoc_id`);

--
-- Chỉ mục cho bảng `dang_ky_tu_van`
--
ALTER TABLE `dang_ky_tu_van`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `giaovien`
--
ALTER TABLE `giaovien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `hocsinh`
--
ALTER TABLE `hocsinh`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_lop_id` (`lop_id`),
  ADD KEY `idx_khoahoc_id` (`khoahoc_id`),
  ADD KEY `idx_kihoc_id` (`kihoc_id`);

--
-- Chỉ mục cho bảng `khoahoc`
--
ALTER TABLE `khoahoc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `kihoc`
--
ALTER TABLE `kihoc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lophoc_kihoc` (`kihoc_id`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tintuc`
--
ALTER TABLE `tintuc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `dangky_bituchoi`
--
ALTER TABLE `dangky_bituchoi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `dangky_khoahoc`
--
ALTER TABLE `dangky_khoahoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `dang_ky_tu_van`
--
ALTER TABLE `dang_ky_tu_van`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `giaovien`
--
ALTER TABLE `giaovien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `hocsinh`
--
ALTER TABLE `hocsinh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `khoahoc`
--
ALTER TABLE `khoahoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `kihoc`
--
ALTER TABLE `kihoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `tintuc`
--
ALTER TABLE `tintuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `dangky_bituchoi`
--
ALTER TABLE `dangky_bituchoi`
  ADD CONSTRAINT `dangky_bituchoi_ibfk_1` FOREIGN KEY (`hocsinh_id`) REFERENCES `hocsinh` (`id`),
  ADD CONSTRAINT `dangky_bituchoi_ibfk_2` FOREIGN KEY (`khoahoc_id`) REFERENCES `khoahoc` (`id`);

--
-- Các ràng buộc cho bảng `dangky_khoahoc`
--
ALTER TABLE `dangky_khoahoc`
  ADD CONSTRAINT `dangky_khoahoc_ibfk_1` FOREIGN KEY (`hocsinh_id`) REFERENCES `hocsinh` (`id`),
  ADD CONSTRAINT `dangky_khoahoc_ibfk_2` FOREIGN KEY (`khoahoc_id`) REFERENCES `khoahoc` (`id`),
  ADD CONSTRAINT `dangky_khoahoc_ibfk_3` FOREIGN KEY (`lophoc_id`) REFERENCES `lophoc` (`id`);

--
-- Các ràng buộc cho bảng `hocsinh`
--
ALTER TABLE `hocsinh`
  ADD CONSTRAINT `fk_hocsinh_khoahoc` FOREIGN KEY (`khoahoc_id`) REFERENCES `khoahoc` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_hocsinh_ki_hoc` FOREIGN KEY (`kihoc_id`) REFERENCES `kihoc` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_hocsinh_lophoc` FOREIGN KEY (`lop_id`) REFERENCES `lophoc` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  ADD CONSTRAINT `fk_lophoc_kihoc` FOREIGN KEY (`kihoc_id`) REFERENCES `kihoc` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `tintuc`
--
ALTER TABLE `tintuc`
  ADD CONSTRAINT `tintuc_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
