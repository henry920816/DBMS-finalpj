<?php
include('database_connection.php');

$method = $_GET['m'] ?? '';

if ($method === 'all') {
    $query = "SELECT sport AS event, athlete_id, country, name, grade, year FROM AthleteRecords";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['event']) . '</td>
                    <td>' . htmlspecialchars($row['athlete_id']) . '</td>
                    <td>' . htmlspecialchars($row['country']) . '</td>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['grade']) . '</td>
                    <td>' . htmlspecialchars($row['year']) . '</td>
                  </tr>';
        }
    } else {
        echo '<tr><td colspan="6">No data found.</td></tr>';
    }
} elseif ($method === 'search') {
    $event = $_GET['event'] ?? '';
    if (!empty($event)) {
        $query = "SELECT sport AS event, athlete_id, country, name, grade, year FROM AthleteRecords WHERE sport = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $event);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . htmlspecialchars($row['event']) . '</td>
                            <td>' . htmlspecialchars($row['athlete_id']) . '</td>
                            <td>' . htmlspecialchars($row['country']) . '</td>
                            <td>' . htmlspecialchars($row['name']) . '</td>
                            <td>' . htmlspecialchars($row['grade']) . '</td>
                            <td>' . htmlspecialchars($row['year']) . '</td>
                          </tr>';
                }
            } else {
                echo '<tr><td colspan="6">No data found.</td></tr>';
            }
        } else {
            echo '<tr><td colspan="6">Query execution failed.</td></tr>';
        }
        $stmt->close();
    } else {
        echo '<tr><td colspan="6">No event selected.</td></tr>';
    }
} else {
    echo '<tr><td colspan="6">Invalid request.</td></tr>';
}

mysqli_close($conn);
?>
