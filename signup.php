<?php
require('./app/init.php');
$errors = $validator->errors();
if(!empty($_POST))
{
   
    $validator->validate($_POST, [
        'email' => [
          'required' => true,
          'maxlength' => 255,
          'unique' => 'users.email',
          'email' => true
        ],
        'password' => [
             'required' =>true,
             'minlength' => 4
        ],
        'username' => [
            'required' => true,
            'minlength' => 2,
            'maxlength'=>255,
            'unique' => 'users.username',
        ]
        ]);
        if(! $validator->fails()) {
            $created = $user->create($_POST);
            if($created) {
                header('Location: index.php');
            }
        }
        //die(var_dump($validator->errors()->errors));
        //die(var_dump($errorHandler->all('email')));
      

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
    <h1>Sign Up</h1>
    <form action ="signup.php" method="POST">
        <div>
            <label for="username">Username</label>
            <br>
            <input type="text" name="username">
            <br>
            <?php
            if($errors->has('username')):
                echo"<span style = 'color: red; font-size: 12px'>{$errors->first('username')}</span>";
            endif
            ?>
        </div>
        <div>
            <label for="email">Email</label>
            <br>
            <input type="text" name="email">
            <br>
            <?php
            if($errors->has('email')):
                echo"<span style = 'color: red; font-size: 12px'>{$errors->first('email')}</span>";
            endif
            ?>
        </div>
        <div>
            <label for="password">Password</label>
            <br>     
            <input type="password" name="password">
            <br>
            <?php
            if($errors->has('password')):
                echo"<span style = 'color: red; font-size: 12px'>{$errors->first('password')}</span>";
            endif
            ?>
        </div>
        <div>
            <input type="Submit">
        </div>
    </form>
</body>
</html>