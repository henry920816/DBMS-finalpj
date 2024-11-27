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

    // get query
    $sql = "";
    // $result = $conn->query($sql);  // commented for now
    
    $mode = $_REQUEST['m'];
    if ($mode == 'search') {
        $name = $_REQUEST['p'];
        // temporary sample return table
        echo '
                    <tr class="row" data-value="1">
                        <td>ad</td>
                        <td>astra</td>
                        <td>per</td>
                        <td>aspera</td>
                    </tr>
                    <tr class="row" data-value="2">
                        <td>'.$name.'</td>
                        <td>Brazil</td>
                        <td>Those Who Know</td>
                        <td>Sigma</td>
                    </tr>
                    <tr class="row" data-value="3">
                        <td>Skibidi</td>
                        <td>Brazil</td>
                        <td>Those Who Know</td>
                        <td>Sigma</td>
                    </tr>';
    }
    else if ($mode == 'profile') {
        // also temp
        echo '
                <p><strong>姓名：</strong>Name</p>
                <p><strong>性別：</strong>Sex</p>
                <p><strong>出生日期：</strong>B.Year</p>
                <p><strong>身高：</strong>Height cm</p>
                <p><strong>體重：</strong>Weight kg</p>
                <p><strong>國家：</strong>Country</p>
                <p><strong>備註：</strong>Notes</p>';
    }

    // close connection
    $conn->close();
?>