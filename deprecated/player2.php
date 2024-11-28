<?php
// 資料庫連接設定

$conn = new mysqli();

if ($conn->connect_error) {
    die("資料庫連接失敗：" . $conn->connect_error);
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$athletes = [];
if (!empty($search)) {
    $sql = "SELECT athlete_id, name, country, sex, born 
            FROM olympic_athlete_biography 
            WHERE LOWER(name) LIKE LOWER(?) 
            ORDER BY country ASC, athlete_id ASC";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("SQL 錯誤：" . $conn->error);
    }
    $like_search = '%' . $search . '%';
    $stmt->bind_param("s", $like_search);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $athletes[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Player Search</title>
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
                This page shows the list of all athletes that have attended the Olympics games.
                You can filter the player by typing in the name at the top.
                Click on the name of the athlete to get their profile.
            </div>
            <div id="form">
                <form method="GET" action="player2.php">
                    <label for="name" class="oxygen-bold">Enter Name</label>
                    <input type="text" id="name" name="search" class="oxygen-light" value="<?php echo htmlspecialchars($search); ?>" placeholder="eg: Tai Tzu-ying">
                    <input type="submit" value="Search" id="submit" class="oxygen-bold">
                </form>
            </div>
            <div id="table">
                <table>
                    <colgroup>
                        <col style="width: 40%">
                        <col style="width: 20%">
                        <col style="width: 20%">
                        <col style="width: 20%">
                    </colgroup>
                    <tr class="attr">
                        <th>Athlete</th>
                        <th>Country</th>
                        <th>Born</th>
                        <th>Sex</th>
                    </tr>
                    <?php if (!empty($athletes)): ?>
                        <?php foreach ($athletes as $athlete): ?>
                            <tr class="row">
                            <td><a href="profile.php?athlete_id=<?php echo htmlspecialchars($athlete['athlete_id']); ?>" style="text-decoration: none; color: #007BFF;"><?php echo htmlspecialchars($athlete['name']); ?></a></td>
                                <td><?php echo htmlspecialchars($athlete['country']); ?></td>
                                <td><?php echo htmlspecialchars($athlete['born']); ?></td>
                                <td><?php echo htmlspecialchars($athlete['sex']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="row">
                            <td colspan="4" style="text-align: center;">Search the name of the player to show the list!</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </body>
</html>
