<?php
// 獲取參數
$country = isset($_GET['country']) ? trim($_GET['country']) : '';
$medal = isset($_GET['medal']) ? trim($_GET['medal']) : '';

// 模擬資料
$results = [
    ['year' => 2020, 'event' => '100m Sprint'],
    ['year' => 2016, 'event' => '200m Freestyle'],
    ['year' => 2012, 'event' => 'Gymnastics All-Around'],
];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title><?php echo htmlspecialchars($country . " - " . $medal); ?></title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <!-- Import Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Alatsi&family=Oxygen:wght@300;400;700&display=swap');
        </style>
    </head>

    <body>
        <!-- NavBar -->
        <div id="navBarContainer">
            <a class="menuBtn" href="country.php"><i class="material-icons home">home</i> Back</a>
            <p class="center"><img src="olympics.png" style="width:60px; height:auto; padding-right: 10px"><b>OLYMPICS or smth idk</b></p>
        </div>
        <!-- Results Section -->
        <div id="content" style="padding-top: 80px; padding-left: 20px; padding-right: 20px">
            <div style="text-align: center; font-size: 18px; padding-bottom: 20px">
                Showing results for <?php echo htmlspecialchars($country); ?> - <?php echo htmlspecialchars($medal); ?>:
            </div>
            <div id="table">
                <table>
                    <colgroup>
                        <col style="width: 50%">
                        <col style="width: 50%">
                    </colgroup>
                    <tr class="attr">
                        <th>Year</th>
                        <th>Event</th>
                    </tr>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $result): ?>
                            <tr class="row">
                                <td><?php echo htmlspecialchars($result['year']); ?></td>
                                <td><?php echo htmlspecialchars($result['event']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="row">
                            <td colspan="2" style="text-align: center;">No data available.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </body>
</html>
