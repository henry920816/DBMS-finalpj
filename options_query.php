<?php
    include "database_connection.php";

    $mode = $_REQUEST["m"];
    switch ($mode) {
        case "year":
            $season = $_REQUEST["s"];
            $sql = "select year
                    from Games
                    where edition LIKE '%$season%' and competition_date != '—'
                    order by year desc";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value=".$row["year"].">".$row["year"]."</option>";
            }
            echo "<option value='new'>(Other)</option>";
            break;

        case "sport":
            $season = $_REQUEST["s"];
            $year = ($_REQUEST["y"] != "new") ? $_REQUEST["y"] : "%";
            $sql = "select distinct d.sport
                    from  Details d
                    where d.edition like '$year $season%'
                    order by d.sport";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row["sport"]."'>".$row["sport"]."</option>";
            }
            echo "<option value='new'>(Other)</option>";
            break;
        
        case "event":
            $season = $_POST["season"];
            $year = ($_POST["year"] != "new") ? $_POST["year"] : "%";
            $sport = $_POST["sport"];
            $sex_opposite = ($_POST["sex"] == "Male") ? "Women" : "Men";
            $sql = "select distinct d.event
                    from Details d
                    where d.edition like '$year $season%' and d.sport = '$sport'
                    and d.event not like '%, $sex_opposite'
                    order by d.event";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row["event"]."'>".$row["event"]."</option>";
            }
            echo "<option value='new'>(Other)</option>";
            break;
    }
?>