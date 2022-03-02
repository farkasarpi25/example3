<?php
include('storage.php');

session_start();
$temp = [];
$error = [];
$users = new Storage(new JsonIO('users.json'));

function validate($in, &$temp, &$error) {
    if($in['username'] == ""){
        $error['username']= 'You must choose a username!';
    }
    else{
        $temp['username'] = $in['username'];
    }

    if($in['password'] == ""){
        $error['password']= 'You must choose a password!';
    }
    else{
        $temp['password'] = $in['password'];
    }

    $temp = $in;
    return count($error);
}

function userExists($user, $username, $password){
    return ($user["username"] === $username && $password === $user["password"]);
}

function checkUsers($users, $user){
    $found = $users->findAll(["username" => $user["username"]]);
    return array_shift($found);
}

function login($user) {
    $_SESSION["user"] = $user;
}

if ($_POST) {
    if (validate($_POST, $temp, $error) == 0) {
        $loggedUser = checkUsers($users, $temp);
        if (!(userExists($loggedUser, $temp["username"], $temp["password"]))) {
            $error['global'] = "Wrong username or password.";
        } else {
            login($loggedUser);
            header('Location: index.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=0, initial-scale=1.0">
    <link rel="stylesheet" href="reg.css">
    <title>Login</title>
</head>
<body>
<div class="cim">
    <h1>Login</h1>
</div>
<div class="sidenav">
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="log_out.php">Log Out</a>
</div>
<div class="register">
    <?php if (isset($error['global'])) : ?>
        <p><span class="error"><?= $error['global'] ?></span></p>
    <?php endif; ?>
    <form action="" method="post">
        <div>
            <label for="username">Username: </label><br>
            <input type="text" name="username" id="username" value="<?= $_POST['username'] ?? "" ?>">
            <?php if (isset($error['username'])) : ?>
                <br><span class="error"><?= $error['username'] ?></span>
            <?php endif; ?>
        </div>
        <div>
            <label for="password">Password: </label><br>
            <input type="password" name="password" id="password">
            <?php if (isset($error['password'])) : ?>
                <br><span class="error"><?= $error['password'] ?></span>
            <?php endif; ?>
        </div>
        <div>
            <br><button type="submit">Login</button>
        </div>
    </form>
</div>
</body>
</html>
