<?php
session_start();
session_destroy(); 
header("Location: ../menu/index.php"); 
exit();
?>