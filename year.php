<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Select Olympic Year</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <!-- Import Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!-- Import Fonts -->
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
                Here you can see the top three players/countries of a sports event in a given year.
            </div>
            <div id="form">
                <form name="form">
                    <label class="oxygen-bold">Select</label>
                    <select id="year-option">
                        <option id="year-option-default" value="0">Select Year</option>
                    </select>
                    <input type="submit" value="Search" id="submit" class="oxygen-bold">
                </form>
            </div>
            <div id="table">
                <table>
                    <colgroup>
                        <col style="width: 25%">
                        <col style="width: 25%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                    </colgroup>
                    <thead>
                        <tr class="attr">
                            <th>Event</th>
                            <th>Sport</th>
                            <th style="background-color: #FFE142">Gold</th>
                            <th style="background-color: #C0C0C0">Silver</th>
                            <th style="background-color: #D18841">Bronze</th>
                        </tr>
                    </thead>
                    <tbody id="table-content"></tbody>
                </table>
                <div id="default">Search the year of the game to show the list!</div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">
            // import jquery //
        </script>
        <script src="year.js">
            // includes query requests, search, and webpage animations //
        </script>
    </body>
</html>
