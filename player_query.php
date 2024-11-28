<?php
include("database_connection.php");

if ($_GET['m'] == 'list') {
    $query = "SELECT athlete_id, name, country, born, sex FROM olympic_athlete_biography ORDER BY country, name";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='row' data-value='{$row['athlete_id']}'>
                    <td>{$row['name']}</td>
                    <td>{$row['country']}</td>
                    <td>{$row['born']}</td>
                    <td>{$row['sex']}</td>
                  </tr>";
        }
    }
}

if ($_GET['m'] == 'search') {
    $name = trim($_GET['p']); 
    $name = strtolower($name);

    $query = "SELECT athlete_id, name, country, born, sex 
              FROM olympic_athlete_biography 
              WHERE LOWER(name) = '$name' 
              ORDER BY country, name";
    $result = $conn->query($query);

    if ($result->num_rows == 0) {
        $query = "SELECT athlete_id, name, country, born, sex 
                  FROM olympic_athlete_biography 
                  WHERE LOWER(name) LIKE '%$name%' 
                  ORDER BY country, name";
        $result = $conn->query($query);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='row' data-value='{$row['athlete_id']}'>
                    <td>{$row['name']}</td>
                    <td>{$row['country']}</td>
                    <td>{$row['born']}</td>
                    <td>{$row['sex']}</td>
                  </tr>";
        }
    } else {
        echo "<p>找不到符合條件的運動員。</p>";
    }
}

if ($_GET['m'] == 'profile') {
    $playerId = $_GET['p'];
    $query = "SELECT A.name, A.sex, A.born, A.height, A.weight, A.country,
              COUNT(CASE WHEN E.medal = 'Gold' THEN 1 END) AS gold_medals,
              COUNT(CASE WHEN E.medal = 'Silver' THEN 1 END) AS silver_medals,
              COUNT(CASE WHEN E.medal = 'Bronze' THEN 1 END) AS bronze_medals,
              GROUP_CONCAT(DISTINCT E.event) AS events
              FROM olympic_athlete_biography A
              LEFT JOIN olympic_athlete_event_details E ON A.athlete_id = E.athlete_id
              WHERE A.athlete_id = '$playerId'
              GROUP BY A.athlete_id";

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='profile-header'>{$row['name']}</div>";
            echo "<div class='profile-content'>";
            echo "<p class='profile-detail'><strong>性別:</strong> {$row['sex']}</p>";
            echo "<p class='profile-detail'><strong>出生日期:</strong> {$row['born']}</p>";
            echo "<p class='profile-detail'><strong>身高:</strong> {$row['height']} cm</p>";
            echo "<p class='profile-detail'><strong>體重:</strong> {$row['weight']} kg</p>";
            echo "<p class='profile-detail'><strong>國家:</strong> {$row['country']}</p>";
            echo "<p class='profile-detail'><strong>金牌數:</strong> {$row['gold_medals']}</p>";
            echo "<p class='profile-detail'><strong>銀牌數:</strong> {$row['silver_medals']}</p>";
            echo "<p class='profile-detail'><strong>銅牌數:</strong> {$row['bronze_medals']}</p>";
            echo "<p class='profile-detail event-list'><strong>參加的項目:</strong> {$row['events']}</p>";
            echo "</div>";
        }
    } else {
        echo "<p>沒有找到該運動員的資料。</p>";
    }
}
?>
