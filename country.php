<?php
// 靜態模擬資料
$countries = [
    ['country' => 'USA', 'gold' => 39, 'silver' => 41, 'bronze' => 33, 'points' => 233],
    ['country' => 'China', 'gold' => 38, 'silver' => 32, 'bronze' => 18, 'points' => 196],
    ['country' => 'Japan', 'gold' => 27, 'silver' => 14, 'bronze' => 17, 'points' => 126],
];

// 接收篩選條件
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filteredCountries = array_filter($countries, function ($country) use ($search) {
    return empty($search) || stripos($country['country'], $search) !== false;
});
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Country Rankings</title>
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
            <a class="menuBtn" href="index.php"><i class="material-icons home">home</i></a>
            <p class="center"><img src="olympics.png" style="width:60px; height:auto; padding-right: 10px"><b>OLYMPICS or smth idk</b></p>
        </div>
        <!-- Filter Section -->
        <div id="content" style="padding-top: 80px; padding-left: 20px; padding-right: 20px">
            <div style="text-align: center; font-size: 18px; padding-bottom: 20px">
                Search and view rankings by country.
            </div>
            <div id="form">
                <form method="GET" action="country.php">
                    <label for="search" class="oxygen-bold">Enter Country Name</label>
                    <input type="text" id="search" name="search" class="oxygen-light" value="<?php echo htmlspecialchars($search); ?>" placeholder="eg: USA">
                    <input type="submit" value="Search" id="submit" class="oxygen-bold">
                </form>
            </div>
            <div id="table">
                <table>
                    <colgroup>
                        <col style="width: 20%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <col style="width: 20%">
                    </colgroup>
                    <tr class="attr">
                        <th>Country</th>
                        <th>Gold</th>
                        <th>Silver</th>
                        <th>Bronze</th>
                        <th>Points</th>
                        <th>Rank</th>
                    </tr>
                    <?php if (!empty($filteredCountries)): ?>
                        <?php 
                        $rank = 1; 
                        foreach ($filteredCountries as $country): ?>
                            <tr class="row">
                                <td><?php echo htmlspecialchars($country['country']); ?></td>
                                <td><a href="country_query.php?country=<?php echo urlencode($country['country']); ?>&medal=Gold"><?php echo htmlspecialchars($country['gold']); ?></a></td>
                                <td><a href="country_query.php?country=<?php echo urlencode($country['country']); ?>&medal=Silver"><?php echo htmlspecialchars($country['silver']); ?></a></td>
                                <td><a href="country_query.php?country=<?php echo urlencode($country['country']); ?>&medal=Bronze"><?php echo htmlspecialchars($country['bronze']); ?></a></td>
                                <td><?php echo htmlspecialchars($country['points']); ?></td>
                                <td><?php echo $rank++; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="row">
                            <td colspan="6" style="text-align: center;">No countries found.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </body>
</html>
