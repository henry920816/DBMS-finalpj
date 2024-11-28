<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Athlete Search</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <!-- Import Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!-- Import Fonts -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Alatsi&family=Oxygen:wght@300;400;700&family=Sono:wght@600&display=swap');
        </style>
    </head>

    <body>
        <!-- NavBar -->
        <div id="navBarContainer">
            <a class="menuBtn" href="index.php"><i class="material-icons home prevent-select">home</i></a>
            <p class="center"><img src="olympics.png" style="width:60px; height:auto; padding-right: 10px"><b>OLYMPICS or smth idk</b></p>
            <span class="edit-switch">
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider prevent-select sono">
                        1 0
                    </span>
                </label>
                Edit Mode
            </span>
        </div>
        <!-- Filter Section -->
        <div id="content" style="padding-top: 80px; padding-left: 20px; padding-right: 20px">
            <div style="text-align: center; font-size: 18px; padding-bottom: 20px">
                This page shows the list of all athletes that have attended the Olympics games.
                You can filter the player by typing in the name at the top.
                Click on the name of the athlete to get their profile.
            </div>
            <div id="form">
                <form name="form">
                    <label for="name" class="oxygen-bold">Enter Name</label>
                    <input type="text" id="name" class="oxygen-light" value="" placeholder="eg: Tai Tzu-ying">
                    <input type="submit" value="Search" id="submit" class="oxygen-bold">
                </form>
            </div>
            <div id="table">
                <table>
                    <colgroup>
                        <col style="width: 40%">
                        <col style="width: 20%">
                        <col style="width: 20%">
                        <col style="width: 20%">
                    </colgroup>
                    <thead>
                        <tr class="attr">
                            <th>Athlete</th>
                            <th>Country</th>
                            <th>Born</th>
                            <th>Sex</th>
                        </tr>
                    </thead>
                    <tbody id="table-content"></tbody>
                </table>
                <div id="default">Search the name of the player to show the list!</div>
            </div>
            <div id="profile">
                <div id="profile-content">
                    <div id="inner">
                        <h2 style="letter-spacing: 1.5px;">Profile</h2>
                        <div id="test"></div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="player.js"></script>
    </body>
</html>
