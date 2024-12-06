<?php
include "database_connection.php";

$mode = $_REQUEST['m'];
switch ($mode) {
    case 'search':
        $sort = $_GET['sort'] ?? 'points';  
        $order = $_GET['order'] ?? 'DESC'; 
        
        $query = "SELECT country, country_noc,
                         SUM(gold) AS gold, SUM(silver) AS silver, SUM(bronze) AS bronze,
                         SUM(gold * 3 + silver * 2 + bronze) AS points
                  FROM Medal
                  GROUP BY country, country_noc";
        
        $query .= " ORDER BY $sort $order"; 
        
        $result = mysqli_query($conn, $query);
        
        if ($result->num_rows > 0) {
            $rank = 1; 
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='row' data-value='" . $row['country_noc'] . "'>";
                echo "<td>" . $rank++ . "</td>"; 
                echo "<td>" . htmlspecialchars($row['country']) . "</td>";
                echo "<td>" . htmlspecialchars($row['gold']) . "</td>";
                echo "<td>" . htmlspecialchars($row['silver']) . "</td>";
                echo "<td>" . htmlspecialchars($row['bronze']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found.</td></tr>";
        }
        break;
    case 'profile':
        $country = $_REQUEST['c'];
        echo 'Not Yet';
}

mysqli_close($conn);
?>
