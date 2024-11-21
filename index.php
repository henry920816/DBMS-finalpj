<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <!-- Import Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Import Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Alatsi&family=Oxygen:wght@300;400;700&display=swap');

        .menu-button {
            display: block;
            text-align: center;
            width: 300px;
            margin: 15px auto; 
            padding: 15px;
            font-size: 18px;
            font-family: 'Oxygen', sans-serif;
            background-color: #A0522D; 
            color: #ffffff;
            text-decoration: none;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .menu-button:hover {
            background-color: #A0522D; 
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
            <a href="player2.php" class="menu-button">Profiles</a>
            <a href="year.php" class="menu-button">Year</a>
            <a href="country.php" class="menu-button">Countries</a>
            <a href="record.php" class="menu-button">Record</a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>
