<?php
include('database_connection.php');

$method = $_GET['m'] ?? '';

if ($method === 'getYears') {
    $type = $_GET['type'] ?? '';
    if ($type === 'Summer') {
        $query = "SELECT DISTINCT year FROM Games WHERE edition LIKE '%Summer%' ORDER BY year ASC";
    } elseif ($type === 'Winter') {
        $query = "SELECT DISTINCT year FROM Games WHERE edition LIKE '%Winter%' ORDER BY year ASC";
    } else {
        $query = "SELECT DISTINCT year FROM Games ORDER BY year ASC";
    }
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $years = [];
        while ($row = $result->fetch_assoc()) {
            $years[] = $row['year'];
        }
        echo json_encode($years);
    } else {
        echo json_encode([]);
    }
} elseif ($method === 'getSports') {
    $year = $_GET['year'] ?? '';
    if ($year) {
        $query = "SELECT DISTINCT sport FROM Details D INNER JOIN Games G ON D.edition_id = G.edition_id WHERE G.year = ? ORDER BY sport ASC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sports = [];
            while ($row = $result->fetch_assoc()) {
                $sports[] = $row['sport'];
            }
            echo json_encode($sports);
        } else {
            echo json_encode([]);
        }
    } else {
        echo json_encode([]);
    }
} elseif ($method === 'getResults') {
    $type = $_GET['type'] ?? '';
    $year = $_GET['year'] ?? '';
    $sport = $_GET['sport'] ?? '';

    if ($year && $sport) {
        $query = "
            SELECT 
                D.event AS event,
                GROUP_CONCAT(DISTINCT CASE 
                                 WHEN D.medal = 'Gold' THEN 
                                     CASE WHEN D.isTeamSport = '1' THEN D.country_noc ELSE A.name END 
                                 ELSE NULL END SEPARATOR ', ') AS gold,
                GROUP_CONCAT(DISTINCT CASE 
                                 WHEN D.medal = 'Silver' THEN 
                                     CASE WHEN D.isTeamSport = '1' THEN D.country_noc ELSE A.name END 
                                 ELSE NULL END SEPARATOR ', ') AS silver,
                GROUP_CONCAT(DISTINCT CASE 
                                 WHEN D.medal = 'Bronze' THEN 
                                     CASE WHEN D.isTeamSport = '1' THEN D.country_noc ELSE A.name END 
                                 ELSE NULL END SEPARATOR ', ') AS bronze
            FROM 
                Details D
            INNER JOIN 
                Games G ON D.edition_id = G.edition_id
            LEFT JOIN 
                Athlete A ON D.athlete_id = A.athlete_id
            WHERE 
                G.year = ? AND D.sport = ? AND G.edition LIKE ?
            GROUP BY 
                D.event
            ORDER BY 
                D.event ASC;
        ";

        $season = ($type === 'Summer') ? '%Summer%' : (($type === 'Winter') ? '%Winter%' : '%');
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $year, $sport, $season);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['event'] . '</td>
                        <td>' . $row['gold'] . '</td>
                        <td>' . $row['silver'] . '</td>
                        <td>' . $row['bronze'] . '</td>
                      </tr>';
            }
        } else {
            echo '<tr><td colspan="4">No results found for the selected filters.</td></tr>';
        }
    } else {
        echo '<tr><td colspan="4">Invalid year or sport selected.</td></tr>';
    }
}

mysqli_close($conn);
?>
