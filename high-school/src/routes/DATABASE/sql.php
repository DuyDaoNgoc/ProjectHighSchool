<?php
$servername = "localhost";  
$username = "root";        
$password = "";            
$dbname = "truonghoc";     
$port = 3306;  


$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra lỗi kết nối
if ($conn->connect_error) {
    die("Lỗi kết nối MySQL: " . $conn->connect_error);
}


$conn->set_charset("utf8mb4");

?>