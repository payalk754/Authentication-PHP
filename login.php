<?php
require('./app/init.php');

if(isset($_POST['login'])) {
    $rememberMe = isset($_POST['remember']);
    $loggedIn = $user->signIn($_POST);

    if($loggedIn){
        $userId = $_SESSION[USER::$sessionKey];
        $tokenData = $token->createRememberMeToken($userId);
        setcookie("remember",$tokenData['token'],time() + Token::$REMEMBER_EXPIRY_TIME_FOR_COOKIE);
        header('Location: index.php');
    }
    else{
        echo "Error in username/password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
     <div>
         <label for="username">Username</label><br>
         <input type ="text" name="username"placeholder="Username or Registered Email">
     </div>
     <div>
         <label for="password">Password</label><br>
         <input type ="text" name="password"placeholder="password">
     </div>
     <div>
         <label>
             <input type="checkbox" name="remember"value="1">Remember Me
         </label>
     </div>
     <div>
            <input type="Submit" name="login" value="Login">
     </div>
    </form>
</body>
</html>