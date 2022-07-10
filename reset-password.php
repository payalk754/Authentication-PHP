<?php
require("./app/init.php");
if(isset($_POST['reset'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userData = $user->findByEmail($email);
    $data['password'] = $password;
    $daa['email'] = $email;
    $updated = $user->update($data,$userData->id);
    if($updated)
    {
        $token->delete($userData->id,0);
        die("Your password was successfully updated.
        Please <a href='login.php'>Login</a>");
    }
    else{
        die("There was some issue at the server side!Please contact support for further help!");
    }

}
if(!isset($_GET['t'])){
    die("403 Bad Request!");
}
else{
    $t = $_GET['t'];
    $tokenData = $token->verify($t,0);
    if($tokenData == null){
        die("Your token has been expired,please regenerat!");
    }
    $userId = $tokenData['user_id'];
    $userData = $user->findById($userId);
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
    <form action="reset-password.php" method = "POST">
            <div style = "margin-bottom: 10px;">
            <label for="email"> Email</label><br>
            <input type = "text" id = "email" readonly name = "email" value="<?=$userData->email;?>">
        </div>

        <div style = "margin-bottom: 10px;">
            <label for="password"> Enter Your Password</label><br>
            <input type = "password" id = "password" name = "password">
        </div>
            <input type = "submit" value="Reset Password" name = "reset">
        </div>
        </form>
</body>
</html>