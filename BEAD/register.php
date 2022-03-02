<?php
include('storage.php');

$users = new Storage(new JsonIO('users.json'));
$error = [];
$temp = [];

function validate($in, &$temp, &$error) {

    if($in['username'] == "" || !isset($in['username'])){
        $error['username']= 'You must enter a username!';
    }
    else{
        $temp['username'] = $in['username'];
    }

    if($in['email'] == "" || !isset($in['email'])){
        $error['email'] = 'You must enter an email!';
    }
    else{
        if (!filter_var($in['email'], FILTER_VALIDATE_EMAIL)){
            $error['email'] = 'Email is not correct!';
        }
        else{
            $temp['email'] = $in['email'];
        }
    }

    if($in['password'] == "" || !isset($in['password'])){
        $error['password'] = 'You must enter a password!';
    }
    if($in['password2'] == "" || !isset($in['password2'])){
        $error['password'] = 'You must enter a password!';
    }
    if(!($in['password'] == "") && !($in['password2'] == "")){
        if($in['password'] != $in['password2']){
            $error['password'] = 'Passwords must match!';
        }
        else{
            $temp['password'] = $in['password'];
        }
    }

    $temp = $in;
    return count($error);
}

function userExists($users, $user) {
    $found = $users->findAll(["username" => $user["username"]]);
    return (count($found) > 0);
}
function addUser($users, $temp) {
    $newUser = [
        'username' => $temp['username'],
        'email' => $temp['email'],
        'password' => $temp['password'],
    ];
    $users->add($newUser);
}

if ($_POST) {
    if (validate($_POST, $temp, $error) == 0) {
        if (userExists($users, $temp)) {
            $error['global'] = "Username already exists!";
        } else {
            addUser($users, $temp);
            header('Location: login.php');
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="reg.css">
</head>
<body>
<div class="cim">
    <h1>Register</h1>
</div>
<div class="sidenav">
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="log_out.php">Log Out</a>
</div>
<?php if (isset($error['global'])) : ?>
    <p><span class="error" style="color:red"><?= $error['global'] ?></span></p>
<?php endif; ?>
<div class="register">
    <form action="" method="post">
        <div>
            <label for="username">Username: </label><br>
            <input type="text" name="username" id="username" value="<?= $_POST['username'] ?? "" ?>">
            <?php if (isset($error['username'])) : ?>
                <br><span class="error" style="color:red"><?= $error['username'] ?></span>
            <?php endif; ?>
        </div>
        <div>
            <label for="email">Email address: </label><br>
            <input type="text" name="email" id="email" value="<?= $_POST['email'] ?? "" ?>">
            <?php if (isset($error['email'])) : ?>
                <br><span class="error" style="color:red"><?= $error['email'] ?></span>
            <?php endif; ?>
        </div>
        <div>
            <label for="password">Password: </label><br>
            <input type="password" name="password" id="password">
            <?php if (isset($error['password'])) : ?>
                <br><span class="error" style="color:red"><?= $error['password'] ?></span>
            <?php endif; ?>
        </div>
        <div>
            <label for="password">Password again: </label><br>
            <input type="password" name="password2" id="password2">
            <?php if (isset($error['password2'])) : ?>
                <br><span class="error" style="color:red"><?= $error['password2'] ?></span>
            <?php endif; ?>
        </div>

        <div>
            <br><button type="submit">Register</button>
        </div>
    </form>
</div>
</body>
</html>