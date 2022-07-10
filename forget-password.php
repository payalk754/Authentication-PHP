<?php
require("./app/init.php");
if(isset($_POST['forgot'])) {
    $email = $_POST['email'];
    //Util::dd($email);
    $userData = $user->findByEmail($email);


    $tokenData = $token->createForgetPassowordToken($userData->id);
    if($tokenData){
        $mail = MailConfigHelper::getMailer();
        $mail->addAddress($email);
        $mail->Subject = "Forget Password!";
        $mail->Body = "Use the following link to reset your password.<br>Note the link be only valid for <strong>10 minutes</strong>.<br><a href='http://localhost:9999/reset-password.php?t={$tokenData['token']}'>Reset Password</a>";
        if($mail->send()) {
            echo "Please check your inbox for further instructions!";
        }
        else{
            echo "Error while sending email,please visit us later!";
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
    <title>Forget Password</title>
</head>
<body>
    <form action="forget-password.php" method="POST">
        <div style="margin-bottom: 10px">
            <label for="email">Enter Email</label><br>
             <input type="email" name="email">
         
         <div>
             <input type="submit" value = "Submit" name="forgot">
         </div>
</div>  
    </form>
</body>
</html>