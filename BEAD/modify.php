<?php
include ('storage.php');
$matches = new Storage(new JsonIO('matches.json'));
$teamsLoad = new Storage(new JsonIO('teams.json'));
$teams=$teamsLoad->findAll();
$temp=[];
$error=[];
$id = $_GET['id'];
$team = $_GET['team'];
$match = $matches->findById($id);
if(!$match){
    $errors['global'] = "ID doesn't belong to a team";
}

//pun intended
function valiDate($in, &$error, &$temp){
    if(!isset($in['date']) || $in['date'] == ""){
        $error['date']= 'You must enter a date';
    }
    else{
        $temp['date']= $in['date'];
    }

    if(!isset($in['home'])){
        $error['home']= 'You must enter an ID';
    }
    else{
        if($in['home'] < 1 || $in['home'] > 16 || !is_numeric($in['home'])){
            $error['home']= 'The ID must be between 1 and 16';
        }
        if($in['home'] == $in['away']){
            $error['home']= 'The two teams cannot be the same';
        }
        else{
            $temp['home']['id'] = $in['home'];
        }
    }

    if(!isset($in['hscore'])){
        $error['hscore']= 'You must enter a score';
    }
    else{
        if(intval($in['hscore']) < 0 || !is_numeric($in['hscore'])){
            $error['hscore']= 'Score is not valid';
        }
        else{
            $temp['home']['score'] = $in['hscore'];
        }
    }

    if(!isset($in['away'])){
        $error['away']= 'You must enter an ID';
    }
    else{
        if($in['away'] < 1 || $in['away'] > 16 || !is_numeric($in['away'])){
            $error['away']= 'The ID must be between 1 and 16';
        }
        if($in['away'] == $in['home']){
            $error['away']= 'The two teams cannot be the same';
        }
        else{
            $temp['away']['id'] = $in['away'];
        }
    }

    if(!isset($in['ascore'])){
        $error['ascore']= 'You must enter a score';
    }
    else{
        if(intval($in['ascore']) < 0 || !is_numeric($in['ascore'])){
            $error['ascore']= 'Score is not valid';
        }
        else{
            $temp['away']['score'] = $in['ascore'];
        }
    }
    return count($error);
}

if(count($_POST) > 0){
    if(valiDate($_POST, $error, $temp) == 0){
        $temp['id'] = $id;
        $matches->update($id, $temp);
        header('Location: allteams.php?id='.$team);
        exit();
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
    <link rel="stylesheet" href="reg.css">
    <title>Modify match</title>
</head>
<body>
<div class="cim">
    <h1>Modify Match</h1>
</div>
<div class="sidenav">
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="log_out.php">Log Out</a>
</div>
<div class="form">
    <form action="" method="post">
        Date: <input type="date" name="date" value="<?=$_POST['date'] ?? $match['date'] ?? ''?>"> <br>
            <?php if(isset($error['date'])) : ?>
                <p style="color: red"><?= $error['date'] ?></p> <br>
            <?php endif ?>

        Home team's ID: <input type="text" name="home" value="<?=$_POST['home'] ?? $match['home']['id'] ?? ''?>"> <br>
            <?php if(isset($error['home'])) : ?>
                <p style="color: red"><?= $error['home'] ?></p> <br>
            <?php endif ?>

        Home team's score: <input type="text" name="hscore" value="<?=$_POST['hscore'] ?? $match['home']['score'] ?? ''?>"> <br>
            <?php if(isset($error['hscore'])) : ?>
                <p style="color: red"><?= $error['hscore'] ?></p> <br>
            <?php endif ?>

        Away team's ID: <input type="text" name="away" value="<?=$_POST['away'] ?? $match['away']['id'] ?? ''?>"> <br>
            <?php if(isset($error['away'])) : ?>
                <p style="color: red"><?= $error['away'] ?></p> <br>
            <?php endif ?>

        Away team's score: <input type="text" name="ascore" value="<?=$_POST['ascore'] ?? $match['away']['score'] ?? ''?>"> <br>
            <?php if(isset($error['ascore'])) : ?>
                <p style="color: red"><?= $error['ascore'] ?></p> <br>
            <?php endif ?>
            <br>
        <button type="submit">Modify match</button>
    </form>
</div>

</body>
</html>
