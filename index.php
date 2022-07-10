<?php
require('./app/init.php');

$tokenData = isset($_COOKIE['remember'])?$token->verify($_COOKIE['remember'],1) : null;
if($tokenData != null){
  $_SESSION[User::$sessionKey] = $tokenData['user_id'];
}

if(isset($_SESSION[User::$sessionKey])){
    $userId = $_SESSION[User::$sessionKey];

    $userObj = $database->table('users')->where('id','=',$userId)->first();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if($user->check()):  ?>
      <p>You are signed In <?= $userObj->username; ?><a href="signout.php"> Sign Out!</a></p>
    <?php else: ?>
      <p>You look new, please either <a href="login.php">Login! </a> or <a href="signup.php">Sign Up</a></p>
    <?php endif; ?>
</body>
</html>