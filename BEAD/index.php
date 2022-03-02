<?php
include('storage.php');
session_start();
$teamsStorage = new Storage(new JsonIO('teams.json'));
$matchesStorage = new Storage(new JsonIO('matches.json'));
$teams = $teamsStorage->findAll();
$matches = $matchesStorage->findAll();
$lejatszott = [];
$nemjatszott = [];
foreach($matches as $match){
    if($match['home']['score'] !== "" && $match['away']['score'] !== ""){
        array_push($lejatszott,$match);
    }
}
foreach ($matches as $match) {
    if($match['home']['score'] == "" && $match['away']['score'] == ""){
        array_push($nemjatszott, $match);
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <title>Premjer Liga</title>
</head>
<body>
<script src="scroll.js"></script>
    <div class="cim">
        <h1>Premjer Liga</h1>
    </div>
    <div class="login">
    <?php if(isset($_SESSION['user']['username'])): ?>
        <p id="logged"><i>Logged in as <b><?=$_SESSION['user']['username']?></b></i></p>
    <?php endif ?>
    </div>

    <div class="leiras">
        <p>Premjer Liga or Russian Premier Liga is the top division professional association football league in Russia.
            On this page you can get informations about the Premjer Liga teams and their matches.
            Click on the teams logo to see all their matches.
        </p>
    </div>

    <div class="sidenav">
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="log_out.php">Log Out</a>
    </div>

    <div>
        <h2 class="teamsTitle">
            Teams
        </h2>
    </div>

    <div class="slideshow-container">

        <!-- Full-width images with number and caption text -->
        <div class="mySlides fade">
            <a href="allteams.php?id=1"><img src="1.png" style="width:30%" class="pic"></a>
            <div class="text">Akhmat Grozny</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=2"><img src="2.png" style="width:30%" class="pic"></a>
            <div class="text">Arsenal Tula</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=3"><img src="3.png" style="width:30%" class="pic"></a>
            <div class="text">CSKA Moscow</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=4"><img src="4.png" style="width:30%" class="pic"></a>
            <div class="text">Dynamo Moscow</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=5"><img src="5.png" style="width:30%" class="pic"></a>
            <div class="text">Khimki</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=6"><img src="6.png" style="width:30%" class="pic"></a>
            <div class="text">Krasnodar</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=7"><img src="7.png" style="width:30%" class="pic"></a>
            <div class="text">Krylia Sovetov</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=8"><img src="8.png" style="width:30%" class="pic"></a>
            <div class="text">Lokomotiv Moscow</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=9"><img src="9.png" style="width:30%" class="pic"></a>
            <div class="text">Nizhny Novgorod</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=10"><img src="10.png" style="width:30%" class="pic"></a>
            <div class="text">Rostov</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=11"><img src="11.png" style="width:30%" class="pic"></a>
            <div class="text">Rubin Kazan</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=12"><img src="12.png" style="width:30%" class="pic"></a>
            <div class="text">Sochi</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=13"><img src="13.png" style="width:30%" class="pic"></a>
            <div class="text">Spartak Moscow</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=14"><img src="14.png" style="width:30%" class="pic"></a>
            <div class="text">Ufa</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=15"><img src="15.png" style="width:30%" class="pic"></a>
            <div class="text">FC Ural Yekaterinburg</div>
        </div>

        <div class="mySlides fade">
            <a href="allteams.php?id=16"><img src="16.png" style="width:30%" class="pic"></a>
            <div class="text">Zenit Saint Petersburg</div>
        </div>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <br>
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
        <span class="dot" onclick="currentSlide(5)"></span>
        <span class="dot" onclick="currentSlide(6)"></span>
        <br>
        <span class="dot" onclick="currentSlide(7)"></span>
        <span class="dot" onclick="currentSlide(8)"></span>
        <span class="dot" onclick="currentSlide(9)"></span>
        <span class="dot" onclick="currentSlide(10)"></span>
        <span class="dot" onclick="currentSlide(11)"></span>
        <span class="dot" onclick="currentSlide(12)"></span>
        <br>
        <span class="dot" onclick="currentSlide(13)"></span>
        <span class="dot" onclick="currentSlide(14)"></span>
        <span class="dot" onclick="currentSlide(15)"></span>
        <span class="dot" onclick="currentSlide(16)"></span>
    </div>
<div class="lastFiveTitle">
    <h2>Last 5 matches</h2>
</div>
<div class="lastFive">
    <table class="styled-table">
        <tr>
            <th>
                ID
            </th>
            <th>
                Date
            </th>
            <th>
                Home
            </th>
            <th>
                Away
            </th>
            <th>
                Score
            </th>
        </tr>
        <?php foreach (array_reverse($lejatszott) as $match) :?>
            <?php if($match['id'] >= $lejatszott[count($lejatszott)-5]['id']) : ?>
                <tr>
                    <td>
                        <?= $match['id'] ?>
                    </td>
                    <td>
                        <?= $match['date'] ?>
                    </td>
                    <td>
                        <?php foreach ($teams as $team) : ?>
                            <?php if($match['home']['id'] === $team['id']):?>
                                <?= $team['name']?>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($teams as $team) : ?>
                            <?php if($match['away']['id'] === $team['id']):?>
                                <?= $team['name']?>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?=$match['home']['score']?> - <?=$match['away']['score']?>
                    </td>
                </tr>
            <?php endif ?>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
