<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Country Search</title>
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
                This page shows the list of all countries ever attended in Olympics.
                You can rank the list by <span class="tooltip">points<span class="tooltiptext oxygen-light">Golds*3+Silver*2+Bronze*1</span></span>, medal counts, or names.
                Click on the country to get its profile.
            </div>
            <div id="form">
                <form name="form">
                    <label class="oxygen-bold">Sort By</label>
                    <select id="country-sort-option">
                        <option value="0">Points</option>
                        <option value="1">Gold</option>
                        <option value="2">Silver</option>
                        <option value="3">Bronze</option>
                        <option value="4">Name</option>
                    </select>
                    <select style="border-radius: 0" id="country-sort-order">
                        <option value="0">Descend</option>
                        <option value="1">Ascend</option>
                    </select>
                    <input type="submit" value="Go" id="submit" class="oxygen-bold">
                </form>
            </div>
            <div id="table">
                <table>
                    <colgroup>
                        <col style="width: 7.5%">
                        <col style="width: 32.5%">
                        <col style="width: 20%">
                        <col style="width: 20%">
                        <col style="width: 20%">
                    </colgroup>
                    <thead>
                        <tr class="attr">
                            <th>Rank</th>
                            <th>Country</th>
                            <th style="background-color: #FFE142">Gold</th>
                            <th style="background-color: #C0C0C0">Silver</th>
                            <th style="background-color: #D18841">Bronze</th>
                        </tr>
                    </thead>
                    <tbody id="table-content"></tbody>
                </table>
                <div id="default">Loading Query...</div>
            </div>
            <div id="profile">
                <div id="profile-content">
                    <div id="inner">
                        <span id="test"></span>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">
            // import jquery //
        </script>
        <script src="country.js">
            // includes query requests, search, and webpage animations //
        </script>
    </body>
</html>