<?php

class Hash{
    public static function make(string $plainText): string{
              return password_hash($plainText,PASSWORD_BCRYPT,['cost'=>10]);//string hash password
    }

    public static function verify(string $plainText, string $hashedPassword){
               return password_verify($plainText, $hashedPassword);//return true or false
    }
    public static function hash(int $userId){
        return hash('sha256',$userId.Util::getCurrentTimeInMillis() . strrev($userId) . rand());
    }
    //1207:41:0921.234567
}


?>