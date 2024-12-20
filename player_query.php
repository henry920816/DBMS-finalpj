<?php
    ############################
    ##   REQUEST ATTRIBUTES   ##
    ############################
    //  m: the sql query we want to use
    //   ?-> search: search the player
    //    -> profile: display profile
    //    -> edit-ui: display edit ui
    //    -> edit: update player profile
    //    -> delete-ui: display delete ui (unused)
    //    -> delete: delete player profile
    //    -> new-ui: display create ui
    //    -> new: insert new player
    //
    //  p: player id

    include "database_connection.php";

    // Attribute Constants
    $sexes = ["Male", "Female"];

    $countries = [];
    $country_query = $conn->query("SELECT DISTINCT country
                                          FROM Medal
                                          ORDER BY country ASC");
    while ($country = $country_query->fetch_assoc()) {
        $countries[] = $country["country"];
    }
    
    $mode = $_REQUEST['m'];
    switch ($mode) {
        // Search Player
        case 'search':
            $name = $_POST['player'];
            $country = ($_POST['country'] == "all")? "" : $_POST['country'];
            $sex = ($_POST['sex'] == "all") ? "" : $_POST['sex'];
            $sql = "SELECT A.name, A.sex, A.born, A.height, A.weight, A.country, A.athlete_id
                    FROM Athlete A
                    LEFT JOIN Details E ON A.athlete_id = E.athlete_id
                    WHERE A.name LIKE '%$name%' AND A.country LIKE '%$country%' AND A.sex LIKE '$sex%'
                    GROUP BY A.athlete_id";
            
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $rowString = '<tr class="row" data-value="'.$row["athlete_id"].'">
                                        <td>'.$row["name"].'</td>
                                        <td>'.$row["country"].'</td>
                                        <td>'.formatDate($row["born"]).'</td>
                                        <td>'
                                            .$row["sex"].'
                                            <div style="position: relative">
                                                <button class="edit">
                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>
                                                </button>
                                                <button class="delete">
                                                    <span class="material-symbols-outlined">
                                                        delete
                                                    </span>
                                                </button>
                                            </div>
                                        </td>
                                  </tr>';
                    echo $rowString;
                }
            }
            else {
                $rowString = '<tr class="search-empty">
                                    <td colspan="4">No Player Found</td>
                              </tr>';
                echo $rowString;
            }
            break;
        
        // Display Profile
        case 'profile':
            $playerId = $_GET['p'];
            $query = "SELECT A.name, A.sex, A.born, A.height, A.weight, A.country,
                      COUNT(CASE WHEN E.medal = 'Gold' THEN 1 END) AS gold_medals,
                      COUNT(CASE WHEN E.medal = 'Silver' THEN 1 END) AS silver_medals,
                      COUNT(CASE WHEN E.medal = 'Bronze' THEN 1 END) AS bronze_medals,
                      GROUP_CONCAT(DISTINCT E.event) AS events
                      FROM Athlete A
                      LEFT JOIN Details E ON A.athlete_id = E.athlete_id
                      WHERE A.athlete_id = '$playerId'
                      GROUP BY A.athlete_id";
            
            $query_event = "select d.edition as edition , d.sport as sport ,d.event as event , if(d.medal != '', d.medal, 'None') as medal
                            from Details d
                            inner join Athlete a on a.athlete_id = d.athlete_id
                            where a.athlete_id = '$playerId'
                            order by edition desc , event";
            $events = $conn->query($query_event);

            $query_record = "select ar.sport,ar.year,ar.grade
                             from AthleteRecords ar
                             inner join Athlete a on a.athlete_id = ar.athlete_id
                             where a.athlete_id = '$playerId'
                             order by ar.year desc , ar.sport";
            $records = $conn->query($query_record);
        
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo   "<div class='profile-header'>
                                <h3>{$row['name']} ///</h3>
                            </div>
                            <div class='profile-content'>
                                <div style='float: left; width: 300px; line-height: 30px'>
                                    <strong>Sex: </strong> {$row['sex']}<br>
                                    <strong>Born: </strong>".formatDate($row["born"])."<br>
                                    <strong>Height: </strong>".checkEmpty($row["height"])."cm<br>
                                    <strong>Weight: </strong>".checkEmpty($row["weight"])."kg<br>
                                    <strong>Country: </strong> {$row['country']}<br>
                                    <strong>Gold: </strong> {$row['gold_medals']}<br>
                                    <strong>Silver: </strong> {$row['silver_medals']}<br>
                                    <strong>Bronze: </strong> {$row['bronze_medals']}<br>
                                </div>
                                <div id='profile-events-container' class='modal-right' style='margin-left: 300px'>
                                    <strong>Attended Events: </strong><br>"
                                    .genRows($events)."<br>"
                                    .genRecords($records)."
                                </div>
                            </div>";
                }
            } else {
                echo "<p>Failed to fetch athlete data. Try to recreate the profile manually.</p>";
            }
            break;
        
        // Display Edit
        case 'edit-ui':
            $playerId = $_REQUEST["p"];
            $sql = "SELECT A.name, A.sex, A.born, A.height, A.weight, A.country,
                    GROUP_CONCAT(DISTINCT E.event) AS events
                    FROM Athlete A
                    LEFT JOIN Details E ON A.athlete_id = E.athlete_id
                    WHERE A.athlete_id = '$playerId'
                    GROUP BY A.athlete_id";
            $result = $conn->query($sql);

            $sql_event = "select d.edition as edition , d.sport as sport ,d.event as event , d.result_id as id
                            from Details d
                            inner join Athlete a on a.athlete_id = d.athlete_id
                            where a.athlete_id = '$playerId'
                            order by edition desc , event";
            $events = $conn->query($sql_event);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $date = getDateArr($row["born"]);
                    $months = range(1, 12);
                    $days = getDays($date["month"], $date["year"]);
                    $str = "<h3>Athlete ID: $playerId</h3>
                            <div style='float: left; width: 400px'>
                                <table>
                                    <colgroup>
                                        <col style='width: 85px'>
                                        <col style='width: 315px'>
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td><input type='text' id='edit-name' class='single' value='".$row["name"]."'></td>
                                        </tr>
                                        <tr>
                                            <td>Sex</td>
                                            <td><select id='edit-sex' class='single'>".createOptions($sexes, $row["sex"])."</select></td>
                                        </tr>
                                        <tr>
                                            <td>Born</td>
                                            <td>
                                                <input type='text' id='edit-byear' class='left' value='".$date["year"]."'> /
                                                <select id='edit-bmonth'>".createOptions($months, $date["month"])."</select> / 
                                                <select id='edit-bday' class='right'>".createOptions($days, $date["day"])."</select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Height</td>
                                            <td><input type='text' id='edit-height' class='single' value='".$row["height"]."'></td>
                                        </tr>
                                        <tr>
                                            <td>Weight</td>
                                            <td><input type='text' id='edit-weight' class='single' value='".$row["weight"]."'></td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td><select id='edit-country' class='single'>".createOptions($countries, $row["country"])."</select></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style='margin-left: 380px; padding-left: 0' class='modal-right'>
                                <div style='padding-bottom: 10px'>
                                    <b style='font-size: 18px; padding-right: 20px'>Attended Events</b>
                                    <button id='edit-new-event-btn'>Add</button>
                                </div>
                                <div id='edit-events-container'>
                                    <table id='edit-events-table'>
                                        <colgroup>
                                            <col style='width: 40px'>
                                            <col style='width: 800px'>
                                        </colgroup>
                                        <tbody>
                                            ".genEvents($events)."
                                        </tbody>
                                    </table>
                                </div>
                            </div>";
                    echo $str;
                }
            }
            break;
        // Edit Record
        case "edit":
            $target = $_POST["target"];
            if ($target == "basic") {
                // Update: Athlete
                $sql = "update Athlete
                        set name = '".$_POST["name"]."',
                            sex = '".$_POST["sex"]."',
                            born = '".$_POST["birthday"]."',
                            height = '".$_POST["height"]."',
                            weight = '".$_POST["weight"]."',
                            country = '".$_POST["country"]."'
                        where athlete_id = '".$_POST["id"]."'";
                $result = $conn->query($sql);
                echo $result;
            }
            else if ($target == "event") {
                // Insert: Details, Games, Results, AthleteRecords, Medal
                // [Details]
                // EDITION & EDITION_ID
                $year = "";
                $edition = "";
                $edition_id = "";
                if ($_POST["new-year"] == "true") {
                    $year = $_POST["year"];
                    $edition = $year." ".$_POST["season"]." Olympics";
                    // generate new id
                    $sql = "SELECT DISTINCT max(convert(edition_id, SIGNED INT)) AS id
                            FROM Medal";
                    $edition_id = $conn->query($sql)->fetch_assoc()["id"] + 1;
                }
                // get year from edition_id
                else {
                    $sql = "SELECT edition
                            FROM Medal
                            WHERE edition_id = '{$_POST['year']}'";
                    $edition = $conn->query($sql)->fetch_assoc()["edition"];
                    $edition_id = $_POST["year"];
                    $year = explode(" ", $edition)[0];
                }

                // COUNTRY_NOC
                $sql = "SELECT noc
                        FROM country
                        WHERE country = '{$_POST['country']}'";
                $noc = $conn->query($sql)->fetch_assoc()["noc"];

                // SPORT
                $sport = $_POST["sport"];

                // EVENT
                $event = "";
                if ($_POST["new-event"] == "true") {
                    $event = $_POST["event"];
                }
                else {
                    $sql = "SELECT DISTINCT event
                            FROM Details AS d
                            WHERE d.result_id = '{$_POST['event']}'";
                    $event = $conn->query($sql)->fetch_assoc()["event"];
                }

                // RESULT_ID
                // ISTEAMSPORT (empty unless exists)
                $result_id = "";
                $isTeamSport = "";
                if ($_POST["new"] == "true") {
                    $sql = "SELECT DISTINCT max(convert(result_id, SIGNED INT)) AS id
                            FROM Details";
                    $result_id = $conn->query($sql)->fetch_assoc()["id"];
                }
                else {
                    $result_id = $_POST["event"];
                    $sql = "SELECT isTeamSport
                            FROM Details
                            WHERE result_id = '{$_POST['event']}'";
                    $isTeamSport = $conn->query($sql)->fetch_assoc()["isTeamSport"];
                }

                // ATHLETE
                $athlete = $_POST["athlete"];

                // ATHLETE_ID
                $athlete_id = $_POST["athleteID"];

                // POS (empty)
                // MEDAL (empty)

                $sql = "INSERT INTO Details (edition, edition_id, country_noc, sport, event, result_id, athlete, athlete_id, pos, medal, isTeamSport)
                        VALUES
                        ('$edition', '$edition_id', '$noc', '$sport', '$event', '$result_id', '$athlete', '$athlete_id', '', '', '$isTeamSport')";
                $conn->query($sql);

                // [Results]
                if ($_POST['new'] == "true") {
                    $sql = "INSERT INTO Results (result_id, event_title, edition, edition_id, sport, sport_url, result_date, result_location, result_participants, result_format, result_detail, result_description)
                            VALUES
                            ('$result_id', '$event', '$edition', '$edition_id', '$sport', '', '', '', '', '', '', '')";
                    $conn->query($sql);
                }

                // [Medal]
                if ($_POST["new-year"] == "true") {
                    // check duplicates
                    $check = $conn->query("SELECT country_noc FROM Medal WHERE edition = '$edition' AND country_noc = '$noc'")->num_rows;
                    if ($check == "0") {
                        $sql = "INSERT INTO Medal (edition_id, edition, year, country, country_noc, gold, silver, bronze)
                                VALUES
                                ('$edition_id', '$edition', '$year', '{$_POST['country']}', '$noc', 0, 0, 0)";
                        $conn->query($sql);
                    }
                }

                // [AthleteRecords]
                // check if it's olympic record
                if ($_POST["rec"] == "1") {
                    $grade = (float)$_POST["grade"];
                    $sql = "SELECT grade, ascend, s
                            FROM (SELECT DISTINCT d.sport AS sport, d.event AS event, grade, ascend, a.sport AS s
                                  FROM AthleteRecords a, Details d
                                  WHERE a.result_id = d.result_id
                                  ORDER BY sport) AS Q,
                                 (SELECT DISTINCT d.sport, d.event
                                  FROM Details d
                                  WHERE d.result_id = '$result_id'
                                  ORDER BY sport) AS P
                            WHERE Q.sport = P.sport AND Q.event = P.event";
                    $result = $conn->query($sql)->fetch_assoc();
                    $old_record = $result["grade"];
                    $asc = $result["ascend"];
                    $sport = $result["s"];

                    // get unit
                    $arr = explode("(",$old_record);
                    $old_record = (float)$arr[0];
                    $unit = "(".$arr[1];

                    // compare
                    if (($asc == 0 && $grade < $old_record) || ($asc == 1 && $grade > $old_record)) {
                        $sql = "update AthleteRecords
                                set athlete_id = '$athlete_id',
                                result_id = '$result_id',
                                country = '$noc',
                                name = '$athlete',
                                grade = '$grade$unit',
                                year = '$year',
                                ascend = '$asc'
                                where sport = ".'"'.$sport.'"';
                        $conn->query($sql);
                    }
                }
            }
            break;

        // Delete Record
        case 'delete':
            if ($_POST["target"] == "event") {
                // Delete: Details
                $result_id = $_POST["resultID"];
                $player_id = $_POST["playerID"];
                $sql = "delete from Details where result_id = '$result_id' and athlete_id = '$player_id'";
                $conn->query($sql);
            }
            break;
    }

    // close connection
    $conn->close();


    #############################
    ##   Function Definition   ##
    #############################

    function formatDate(string $date) {
        $arr = explode(" ", trim($date));

        // check if format is correct (dirty data!)
        if (count($arr) == 0 || count($arr) > 3) {
            return "(not provided)";
        }
        else if (!is_numeric($arr[0])) {
            $arr = explode("-", $arr[0]);
            if (is_numeric($arr[0])) {
                return $date;
            }
            return "(not provided)";
        }
        // only year
        else if (count($arr) == 1) {
            return "<i>circa</i> $arr[0]";
        }
        // day-month-year
        else {
            $day = str_pad($arr[0], 2, "0", STR_PAD_LEFT);
            $month = str_pad(date_parse($arr[1])['month'], 2, "0", STR_PAD_LEFT);
            $year = $arr[2];
            return "$year-$month-$day";
        }
    }

    function getDateArr(string $date) {
        $output = ["year" => "", "month" => "", "day" => ""];
        $date = formatDate($date);
        $check = explode(" ", $date);
        if (count($check) > 1) {
            if ($check[0] == "<i>circa</i>") {
                $output['year'] = $check[1];
            }
            $output["month"] = "1";
            $output["day"] = "1";
        } else {
            $arr = explode("-", $date);
            $output = ["year" => $arr[0], "month"=> $arr[1], "day"=> $arr[2]];
        }
        return $output;
    }

    function checkEmpty(string $value) {
        if (trim($value) == "") {
            return "? ";
        }
        else {
            return $value;
        }
    }

    function createOptions(array $options, string $select) {
        $output = "";
        foreach ($options as $key) {
            $output .= "<option value='$key' ";
            if ($key == trim($select)) {
                $output .= "selected";
            }
            $output .= ">$key</option>";
        }
        return $output;
    }

    function getDays(string $month, string $year) {
        if ($year == "") {
            $year = /*literally*/"1984";
        }
        return range(0, cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year));
    }

    function genRows(mysqli_result $query) {
        $output = "";
        while ($row = $query->fetch_assoc()) {
            $output .= "<span>".$row["edition"].", ".$row["sport"]." - ".$row["event"];
            if ($row["medal"] != "None") {
                if ($row["medal"] == "Gold") {
                    $output .= "<span class='medal gold'>1</span>";
                }
                else if ($row["medal"] == "Silver") {
                    $output .= "<span class='medal silver'>2</span>";
                }
                else if ($row["medal"] == "Bronze") {
                    $output .= "<span class='medal bronze'>3</span>";
                }
            }
            $output .= "</span><br>";
        }
        return $output;
    }

    function genRecords(mysqli_result $query) {
        $output = "";
        if ($query->num_rows > 0) {
            $output .= "<strong>Olympic Record: </strong><br>";
            while ($row = $query->fetch_assoc()) {
                $output .= "<span style='line-height: 30px'>".$row["sport"]." (".$row["year"].") - ".$row["grade"]."</span><br>";
            }
        }
        return $output;
    }

    function genEvents(mysqli_result $query) {
        $output = "";
        while ($row = $query->fetch_assoc()) {
            $output .= "<tr>
                            <td>
                                <label>
                                    <input type='checkbox' class='edit-events-remove' value='".$row["id"]."'>
                                    <span class='edit-remove-label'>
                                        <span class='material-symbols-outlined prevent-select' style='font-size: 15px'>
                                            <span>
                                                close
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </td>
                            <td>".$row["edition"].", ".$row["sport"]." - ".$row["event"]."</td>
                        </tr>";
        }
        return $output;
    }
?>