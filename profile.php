<?php
// 連接到 MySQL 資料庫
$servername = "localhost";
$username = "root";
$password = "12345678"; // 替換為您的 MySQL 密碼
$dbname = "olympic"; // 替換為您的資料庫名稱

$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("資料庫連接失敗：" . $conn->connect_error);
}

// 獲取選手 ID
$athlete_id = isset($_GET['athlete_id']) ? $_GET['athlete_id'] : null;
$athlete_data = null;

if ($athlete_id) {
    // 查詢選手詳細資料
    $sql = "SELECT * FROM olympic_athlete_biography WHERE athlete_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("SQL 錯誤：" . $conn->error);
    }
    $stmt->bind_param("i", $athlete_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $athlete_data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>選手資料</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .athlete-details {
            margin-top: 20px;
            line-height: 1.8;
            font-size: 16px;
            color: #555;
        }
        .athlete-details strong {
            font-size: 18px;
            color: #333;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>選手資料</h1>
        <?php if ($athlete_data): ?>
            <div class="athlete-details">
                <p><strong>姓名：</strong><?php echo htmlspecialchars($athlete_data['name']); ?></p>
                <p><strong>性別：</strong><?php echo htmlspecialchars($athlete_data['sex']); ?></p>
                <p><strong>出生日期：</strong><?php echo htmlspecialchars($athlete_data['born']); ?></p>
                <p><strong>身高：</strong><?php echo htmlspecialchars($athlete_data['height']); ?> cm</p>
                <p><strong>體重：</strong><?php echo htmlspecialchars($athlete_data['weight']); ?> kg</p>
                <p><strong>國家：</strong><?php echo htmlspecialchars($athlete_data['country']); ?></p>
                <p><strong>備註：</strong><?php echo htmlspecialchars($athlete_data['special_notes']); ?></p>
            </div>
        <?php else: ?>
            <p>未找到選手資料。</p>
        <?php endif; ?>
        <a href="index.php" class="back-button">返回首頁</a>
        <a href="athlete.php" class="back-button">返回選手列表</a>
    </div>
</body>
</html>
