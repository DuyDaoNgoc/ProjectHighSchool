<?php
require '../DATABASE/sql.php';

$maxTerm = 2;   



$sql = "UPDATE lophoc 
        SET HocKy = CASE 
                        WHEN HocKy < $maxTerm THEN HocKy + 1 
                        ELSE 1 
                    END,
            NamHoc = CASE 
                        WHEN HocKy = $maxTerm THEN NamHoc + 1 
                        ELSE NamHoc 
                     END";


if ($conn->query($sql)) {
    echo "Cập nhật học kỳ thành công!";
} else {
    echo "Có lỗi xảy ra: " . $conn->error;
}
?>