<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>奧運數據查詢系統</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <!-- Import Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Import Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Alatsi&family=Oxygen:wght@300;400;700&display=swap');

        /* 按鈕樣式 */
        .menu-button {
            display: block;
            text-align: center;
            width: 300px;
            margin: 15px auto; /* 垂直間距 */
            padding: 15px;
            font-size: 18px;
            font-family: 'Oxygen', sans-serif;
            background-color: #A0522D; /* 深咖啡色 */
            color: #ffffff;
            text-decoration: none;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .menu-button:hover {
            background-color: #A0522D; /* 淺咖啡色 */
            box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <!-- NavBar -->
    <div id="navBarContainer">
        <a class="menuBtn" href="index.php"><i class="material-icons home">home</i></a>
        <p class="center"><img src="olympics.png" style="width:60px; height:auto; padding-right: 10px"><b>OLYMPICS or smth idk</b></p>
    </div>

    <!-- Main Content -->
    <div id="content" style="padding-top: 80px; padding-left: 20px; padding-right: 20px">
        <div style="text-align: center; font-size: 18px; padding-bottom: 20px">
            <h1>Please Select the Function：</h1>
        </div>
        <div id="form">
            <!-- 功能按鈕 -->
            <a href="player2.php" class="menu-button">Profiles</a>
            <a href="year.php" class="menu-button">Year</a>
            <a href="country.php" class="menu-button">Countries</a>
            <a href="record.php" class="menu-button">Record</a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>
