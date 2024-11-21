<?php
$servername = "localhost";
$username = "root";
$password = "12345678"; 
$dbname = "olympic"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("資料庫連接失敗：" . $conn->connect_error);
}

$sql = "SELECT DISTINCT year FROM olympic_games_summary ORDER BY year ASC";
$result = $conn->query($sql);

$years = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $years[] = $row['year'];
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Select Olympic Year</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <!-- Import Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!-- Import Fonts -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Alatsi&family=Oxygen:wght@300;400;700&display=swap');
        </style>
    </head>

    <body>
        <!-- NavBar -->
        <div id="navBarContainer">
            <a class="menuBtn" href="index.php"><i class="material-icons home">home</i></a>
            <p class="center"><img src="olympics.png" style="width:60px; height:auto; padding-right: 10px"><b>OLYMPICS or smth idk</b></p>
        </div>
        <!-- Filter Section -->
        <div id="content" style="padding-top: 80px; padding-left: 20px; padding-right: 20px">
            <div style="text-align: center; font-size: 18px; padding-bottom: 20px">
                Select an Olympic year to view the top three players for all sports in that year.
            </div>
            <div id="form">
                <form method="GET" action="year_query.php">
                    <label for="year" class="oxygen-bold">Select Year</label>
                    <select id="year" name="year" class="oxygen-light">
                        <option value="" disabled selected>Choose a year</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Submit" id="submit" class="oxygen-bold">
                </form>
            </div>
        </div>
    </body>
</html>
