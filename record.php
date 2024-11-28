<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Record Search</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <!-- Import Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Alatsi&family=Oxygen:wght@300;400;700&display=swap');
        </style>
    </head>

    <body>
        <!-- NavBar -->
        <div id="navBarContainer">
            <a class="menuBtn" href="index.php"><i class="material-icons home">home</i></a>
            <p class="center"><img src="olympics.png" style="width:60px; height:auto; padding-right: 10px"><b>OLYMPICS or smth idk</b></p>
        </div>
        <!-- Filter Section -->
        <div id="content" style="padding-top: 80px; padding-left: 20px; padding-right: 20px">
            <div style="text-align: center; font-size: 18px; padding-bottom: 20px">
                Select a sport to view its record and details.
            </div>
            <div id="form">
                <form name="form">
                    <label class="oxygen-bold">Select</label>
                    <select id="record-option">
                        <option id="record-option-default" value="0">Select Event</option>
                    </select>
                    <input type="submit" value="Search" id="submit" class="oxygen-bold">
                </form>
            </div>
            <div id="table">
                <table>
                    <colgroup>
                        <col style="width: 30%">
                        <col style="width: 20%">
                        <col style="width: 30%">
                        <col style="width: 20%">
                    </colgroup>
                    <thead>
                        <tr class="attr">
                            <th>Sport</th>
                            <th>Record</th>
                            <th>Holder</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="table-content"></tbody>
                </table>
                <div id="default">Loading...</div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">
            // import jquery //
        </script>
        <script src="record.js">
            // includes query requests, search, and webpage animations //
        </script>
    </body>
</html>
