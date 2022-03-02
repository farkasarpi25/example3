<?php
include('storage.php');
session_start();
$teamsStorage = new Storage(new JsonIO('teams.json'));
$matchesStorage = new Storage(new JsonIO('matches.json'));
$commentsStorage = new Storage(new JsonIO('comments.json'));
$teams = $teamsStorage->findAll();
$error=[];
$commentError = $_GET['error'];
$error['comment'] = $commentError;

$id = $_GET['id'];
$team = $teamsStorage->findById($id);

$matches = $matchesStorage->findAll();
$comments = $commentsStorage->findAll();
$teamMatches=[];
$teamComments =[];

foreach($matches as $match){
    $home=$match['home'];
    $away=$match['away'];
    if($home['id'] == $id || $away['id'] == $id){
        array_push($teamMatches, $match);
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
    <link rel="stylesheet" href="details.css">
    <title>Team details</title>
</head>
<body>
<div class="cim">
    <h1><?= $team['name'] ?></h1>
</div>
<div class="login">
    <?php if(isset($_SESSION['user']['username'])): ?>
        <p id="logged"><i>Bejelentkezve mint <b><?=$_SESSION['user']['username']?></b></i></p>
    <?php endif ?>
</div>
<div class="sidenav">
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="log_out.php">Log Out</a>
</div>
<div class="pic">
    <img src="<?= $team['id'] ?>.png" alt="Logo of the team" style="width:30%">
</div>
<div class="teamMatches">
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
                -
            </th>
            <th>
                Away
            </th>
            <th>
                Score
            </th>
        </tr>
    <?php foreach (array_reverse($teamMatches) as $match) : ?>
    <tr>
        <td>
            <?= $match['id'] ?>
        </td>
        <td>
            <?= $match['date'] ?>
        </td>
        <?php if($match['home']['id'] == $team['id']) : ?>
            <?php if($match['home']['score'] > $match['away']['score']) : ?>
                <td style="background-color:#90EE90"><?= $team['name']?></td>
            <?php elseif($match['home']['score'] < $match['away']['score']) : ?>
                <td style="background-color:#DE3163"><?= $team['name']?></td>
            <?php elseif($match['home']['score'] == $match['away']['score'] && $match['home']['score'] != "") : ?>
                <td style="background-color:#FFFF8F"><?= $team['name']?></td>
            <?php else : ?>
                <td><?= $team['name'] ?></td>
            <?php endif ?>
        <?php else : ?>
            <?php foreach($teams as $team2) : ?>
                <?php if($match['home']['id'] == $team2['id']) : ?>
                    <td><?= $team2['name'] ?></td>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>
        <td>
            -
        </td>
        <?php if($match['away']['id'] == $team['id']) : ?>
            <?php if($match['away']['score'] > $match['home']['score']) : ?>
                <td style="background-color: #90EE90"><?= $team['name']?></td>
            <?php elseif($match['away']['score'] < $match['home']['score']) : ?>
                <td style="background-color: #DE3163"><?= $team['name']?></td>
            <?php elseif($match['away']['score'] == $match['home']['score'] && $match['away']['score'] != "") : ?>
                <td style="background-color: #FFFF8F"><?= $team['name']?></td>
            <?php else: ?>
                <td><?= $team['name']?></td>
            <?php endif ?>
        <?php else : ?>
            <?php foreach($teams as $team2): ?>
                <?php if($match['away']['id'] == $team2['id']) : ?>
                    <td><?= $team2['name']?></td>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>
        <td>
            <?php if($match['home']['id'] == $team['id'] || $match['away']['id'] == $team['id']) : ?>
                <?= $match['home']['score'] ?> - <?= $match['away']['score'] ?>
            <?php endif ?>
        </td>
        <?php if(isset($_SESSION['user']) && $_SESSION['user']['username']=="admin"): ?>
            <td>
                <a href="modify.php?id=<?=$match['id']?>&team=<?=$team['id']?>">Modify</a>
            </td>
            <td>
                <a href="remove.php?id=<?=$match['id']?>&team=<?=$team['id']?>">Delete</a>
            </td>
        <?php endif ?>
    </tr>
    <?php endforeach; ?>
    </table>
</div>
<?php if(isset($_SESSION['user'])) : ?>
    <div class="comment">
        <h2>Add new comment</h2>
        <textarea rows="4" cols="50" name="comment" form="commentform" class="textarea" placeholder="Yada, yada"></textarea>
        <form action="comment.php?id=<?=$team['id']?>" id="commentform" method="post">
            <input type="submit" value="Add comment" class="inputButton"><br>
            <?php if(isset($error['comment'])) : ?>
                <small style="color:red"><?= $error['comment'] ?></small> <br>
            <?php endif ?>
        </form>
        <br>
    </div>
    <?php else : ?>
        <div class="commentNotLogged">
            <p>
                You must <a href="login.php">login</a> to write a new comment!
            </p>
        </div>
<?php endif ?>
<div class="commentsH2">
    <h2>
        Previous comments
    </h2>
</div>
<?php foreach (array_reverse($comments) as $comment) : ?>
    <?php if($comment['team'] == $team['id']) : ?>
        <div class="commentShow">
            <div class="commmentPic">
                <img src="comment.png" alt="comment" width="8%">
                <?php if(isset($_SESSION['user']) && $_SESSION['user']['username']=="admin"): ?>
                    <a href="removeComment.php?id=<?=$comment['id']?>"><img src="x.png" alt="delete" width="5%"></a>
                <?php endif ?>
                <p><?= $comment['text'] ?></p>
            </div>
            <div class="author">
                <?= $comment['date'] ?>
                <?= $comment['author'] ?>
            </div>
        </div>
    <?php endif ?>
<?php endforeach; ?>
</body>
</html>
