<?php
include("database_connection.php");
header('Content-Type: application/json');

if (!isset($_GET['m'])) {
    echo json_encode(['error' => 'No mode provided']);
    exit;
}

$mode = $_GET['m'];

if ($mode == 'getYears') {
    $query = "SELECT DISTINCT year FROM olympic_event_results ORDER BY year";
    $result = $conn->query($query);

    if ($result) {
        $years = array();
        while ($row = $result->fetch_assoc()) {
            $years[] = $row['year'];
        }
        echo json_encode($years);
    } else {
        error_log("Failed to execute query: " . $conn->error);
        echo json_encode(['error' => 'Failed to fetch years']);
    }
    exit;
}

if ($mode == 'search') {
    $year = intval($_GET['y']);

    $query = "SELECT E.event_title, S.sport, G.gold_medalist, G.silver_medalist, G.bronze_medalist
              FROM olympic_event_results E
              JOIN olympic_sports S ON E.sport_id = S.sport_id
              LEFT JOIN (
                  SELECT event_id,
                         MAX(CASE WHEN medal = 'Gold' THEN athlete_name END) AS gold_medalist,
                         MAX(CASE WHEN medal = 'Silver' THEN athlete_name END) AS silver_medalist,
                         MAX(CASE WHEN medal = 'Bronze' THEN athlete_name END) AS bronze_medalist
                  FROM olympic_medal_results
                  GROUP BY event_id
              ) G ON E.event_id = G.event_id
              WHERE E.year = '$year'
              ORDER BY E.event_title";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['event_title']}</td>
                    <td>{$row['sport']}</td>
                    <td>{$row['gold_medalist']}</td>
                    <td>{$row['silver_medalist']}</td>
                    <td>{$row['bronze_medalist']}</td>
                  </tr>";
        }
    } else {
        echo ""; 
    }
    exit;
}

echo json_encode(['error' => 'Invalid mode']);
?>
