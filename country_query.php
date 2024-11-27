<?php
    // connect to database
    // Create connection
    $conn = new mysqli();
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // get query
    $sql = "";
    // $result = $conn->query($sql);  // commented for now

    $mode = $_REQUEST["m"];
    if ($mode == "search") {
        echo '
                    <tr class="row">
                        <td>1</td>
                        <td>USA</td>
                        <td>50</td>
                        <td>80</td>
                        <td>112</td>
                    </tr>
                    <tr class="row">
                        <td>2</td>
                        <td>USB</td>
                        <td>40</td>
                        <td>30</td>
                        <td>117</td>
                    </tr>
                    <tr class="row">
                        <td>3</td>
                        <td>USC</td>
                        <td>1</td>
                        <td>32</td>
                        <td>40</td>
                    </tr>
                ';
    }
    else if ($mode == "profile") {
        echo 'Query Load Successfully';
    }
?>