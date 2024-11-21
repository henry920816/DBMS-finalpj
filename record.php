<?php
// 模擬資料
$records = [
    ['sport' => '100m Sprint', 'record' => '9.58s', 'holder' => 'Usain Bolt', 'start_date' => '2009-08-16'],
    ['sport' => 'Marathon', 'record' => '2:01:39', 'holder' => 'Eliud Kipchoge', 'start_date' => '2018-09-16'],
    ['sport' => 'High Jump', 'record' => '2.45m', 'holder' => 'Javier Sotomayor', 'start_date' => '1993-07-27'],
];

$selectedSport = isset($_GET['sport']) ? trim($_GET['sport']) : '';

$filteredRecords = array_filter($records, function ($record) use ($selectedSport) {
    return empty($selectedSport) || $record['sport'] === $selectedSport;
});
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Sports Records</title>
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
                Select a sport to view its record and details.
            </div>
            <div id="form">
                <form method="GET" action="record.php">
                    <label for="sport" class="oxygen-bold">Select Sport</label>
                    <select id="sport" name="sport" class="oxygen-light">
                        <option value="" <?php echo empty($selectedSport) ? 'selected' : ''; ?>>All Sports</option>
                        <?php foreach ($records as $record): ?>
                            <option value="<?php echo htmlspecialchars($record['sport']); ?>" <?php echo $selectedSport === $record['sport'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($record['sport']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Filter" id="submit" class="oxygen-bold">
                </form>
            </div>
            <div id="table">
                <table>
                    <colgroup>
                        <col style="width: 30%">
                        <col style="width: 20%">
                        <col style="width: 30%">
                        <col style="width: 20%">
                    </colgroup>
                    <tr class="attr">
                        <th>Sport</th>
                        <th>Record</th>
                        <th>Holder</th>
                        <th>Start Date</th>
                    </tr>
                    <?php if (!empty($filteredRecords)): ?>
                        <?php foreach ($filteredRecords as $record): ?>
                            <tr class="row">
                                <td><?php echo htmlspecialchars($record['sport']); ?></td>
                                <td><?php echo htmlspecialchars($record['record']); ?></td>
                                <td><?php echo htmlspecialchars($record['holder']); ?></td>
                                <td><?php echo htmlspecialchars($record['start_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="row">
                            <td colspan="4" style="text-align: center;">No records found for the selected sport.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </body>
</html>
