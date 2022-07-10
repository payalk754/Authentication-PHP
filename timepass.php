<?php
 
//require('./app/classes/Database.php');
//require('./app/classes/Hash.php');
//require('./app/classes/MailConfigHelper.php');
//echo Hash::make('abcd1234');
/*if(Hash::verify('abcd134','xfndnnnfmm')){
  echo  "Matched";
}else{
    echo "Not Matched";
}*/

/*$mail = MailConfigHelper::getMailer();
$mail->addAddress('payal@gmail.com');
$mail->Subject = "Auth!";
$mail->Body = "Test Mail From <strong>Auth</strong>";
$mail->send();
echo "Sent";*/

/*$database = new Database();
$rows = $database->table('users')->where('email','like', '%payal%')->get();
var_dump($rows);*/


require('./app/classes/Database.php');
$database = new Database();
//insert
$data['fname'] = "yash";
$data['lname'] = "motta";
$data['email'] = "yash@gmail.com";
echo "<br>INSERTED DATA IS:             ";
$inserted = $database->table('users')
            ->insert($data);
var_dump($inserted);

//deleted
echo "<br>NO OF DELETED ROWS:     ";
$deleted = $database->table('users')
           ->deleteWhere("email", "yash@gmail.com")
           ->count();

var_dump($deleted);




?>