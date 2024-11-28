<?php
$servername = "localhost"; 
$username = "root"; 
$password = "11111111"; // 我的db密碼
$dbname = "olympic"; // 我在xampp上建立的資料庫名稱

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
?>
