<?php
    // read init.php if you run into any problems
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "db";

    // create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $mode = $_REQUEST['m'];
    switch ($mode) {
        // Search Player
        case 'search':
            $name = $_REQUEST['p'];
            $sql = "SELECT A.name, 
                    A.sex, 
                    A.born, 
                    A.height, 
                    A.weight, 
                    A.country, 
                    A.athlete_id,
                    COUNT(E.athlete_id) AS total_events, -- Total events participated in
                    COUNT(CASE WHEN E.medal = 'Gold' THEN 1 END) AS gold_medals, -- Gold medal count
                    COUNT(CASE WHEN E.medal = 'Silver' THEN 1 END) AS silver_medals, -- Silver medal count
                    COUNT(CASE WHEN E.medal = 'Bronze' THEN 1 END) AS bronze_medals, -- Bronze medal count
                    GROUP_CONCAT(DISTINCT E.event) AS events -- List of distinct events
                    FROM Athlete A
                    LEFT JOIN Details E ON A.athlete_id = E.athlete_id
                    WHERE A.name LIKE '%$name%'
                    GROUP BY A.athlete_id";
            
            // check
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $rowString = '<tr class="row"> data-value="'.$row["athlete_id"].'">
                                        <td>'.$row["name"].'</td>
                                        <td>'.$row["country"].'</td>
                                        <td>'.$row["born"].'</td>
                                        <td>'.$row["sex"].'</td>
                                  </tr>';
                    echo $rowString;
                }
            }
            else {
                $rowString = '<tr class="search-empty">
                                    <td colspan="4">No Players Found</td>
                              </tr>';
                echo $rowString;
            }
            break;
        
        // Display Profile
        case 'profile':
            // also temp
            echo '
                    <p><strong>姓名：</strong>Name</p>
                    <p><strong>性別：</strong>Sex</p>
                    <p><strong>出生日期：</strong>B.Year</p>
                    <p><strong>身高：</strong>Height cm</p>
                    <p><strong>體重：</strong>Weight kg</p>
                    <p><strong>國家：</strong>Country</p>
                    <p><strong>備註：</strong>Notes</p>';
            break;
        
        // Edit Record
        case 'edit':
            break;
    }

    // close connection
    $conn->close();
?>