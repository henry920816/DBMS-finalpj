<?php
include "database_connection.php";

$method = $_GET['m'] ?? '';

if ($method === 'getYears') {
    $type = $_GET['type'] ?? '';
    if ($type === 'Summer Olympics') {
        $query = "SELECT DISTINCT year FROM Games WHERE edition LIKE '%Summer%' ORDER BY year ASC";
    } elseif ($type === 'Winter Olympics') {
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
} elseif ($method === 'getResults') {
    $year = $_GET['y'] ?? '';
    $type = $_GET['type'] ?? '';

    if ($year) {
        $query = "
            SELECT 
                G.edition AS edition,
                R.sport AS sport,
                R.event_title AS event,
                GROUP_CONCAT(DISTINCT CASE 
                    WHEN D.medal = 'Gold' THEN 
                        CASE WHEN D.isTeamSport = 'true' THEN D.country_noc ELSE A.name END 
                END ORDER BY CASE WHEN D.isTeamSport = 'true' THEN D.country_noc ELSE A.name END ASC SEPARATOR ', ') AS gold,
                GROUP_CONCAT(DISTINCT CASE 
                    WHEN D.medal = 'Silver' THEN 
                        CASE WHEN D.isTeamSport = 'true' THEN D.country_noc ELSE A.name END 
                END ORDER BY CASE WHEN D.isTeamSport = 'true' THEN D.country_noc ELSE A.name END ASC SEPARATOR ', ') AS silver,
                GROUP_CONCAT(DISTINCT CASE 
                    WHEN D.medal = 'Bronze' THEN 
                        CASE WHEN D.isTeamSport = 'true' THEN D.country_noc ELSE A.name END 
                END ORDER BY CASE WHEN D.isTeamSport = 'true' THEN D.country_noc ELSE A.name END ASC SEPARATOR ', ') AS bronze
            FROM 
                Details D
            INNER JOIN 
                Games G ON D.edition_id = G.edition_id
            INNER JOIN 
                Results R ON D.result_id = R.result_id
            LEFT JOIN 
                Athlete A ON D.athlete_id = A.athlete_id
            WHERE 
                G.year = ?
        ";

        if ($type === 'Summer Olympics') {
            $query .= " AND G.edition LIKE '%Summer%'";
        } elseif ($type === 'Winter Olympics') {
            $query .= " AND G.edition LIKE '%Winter%'";
        }

        $query .= "
            GROUP BY G.edition, R.sport, R.event_title
            ORDER BY G.edition ASC, R.sport ASC, R.event_title ASC
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . htmlspecialchars($row['edition']) . '</td>
                        <td>' . htmlspecialchars($row['sport']) . '</td>
                        <td>' . htmlspecialchars($row['event']) . '</td>
                        <td>' . htmlspecialchars($row['gold']) . '</td>
                        <td>' . htmlspecialchars($row['silver']) . '</td>
                        <td>' . htmlspecialchars($row['bronze']) . '</td>
                      </tr>';
            }
        } else {
            echo '<tr><td colspan="6">No results found for this year.</td></tr>';
        }
    } else {
        echo '<tr><td colspan="6">Invalid year selected.</td></tr>';
    }
}

mysqli_close($conn);
?>
