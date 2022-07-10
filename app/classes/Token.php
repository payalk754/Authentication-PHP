<?php

class Token
{
    private Database $database;
    private static $REMEMBER_EXPIRY_TIME ='30 minutes';
    public static $REMEMBER_EXPIRY_TIME_FOR_COOKIE = 1800;
    
    private static $FORGET_PWD_EXPIRY_TIME = '10 minutes';

    private string $table = 'tokens';

    private const CREATE_QUERY = "CREATE TABLE IF NOT EXISTS tokens (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, user_id INT UNSIGNED, token VARCHAR(255) UNIQUE,expires_at DATETIME NOT NULL,is_remember TINYINT DEFAULT 0)";

    public function __construct(Database $database)
    {
        $this->database = $database;
 
    }
    public function build()
    {
        $this->database->raw(Token::CREATE_QUERY);
    }
    public function delete(string $userId,int $isRemember)
    {
        $sql = "DELETE FROM {$this->table} WHERE user_id = {$userId} AND is_remember = {$isRemember}";
        $this->database->raw($sql);
    }
    public function verify(string $token,int $isRemember):array|null 
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM {$this->table} WHERE token = '{$token}' AND is_remember = {$isRemember} AND expires_at >='{$currentDateTime}'";
        $token = $this->database->fetchAll($sql);
        if($token){
            return $token[0];
        }
        return null;
    }
    public function createRememberMeToken(int $userId):array|null
    {
        return $this->createToken($userId,1);
    }
    public function createForgetPassowordToken(int $userId):array|null 
    {
        return $this->createToken($userId,0);
    
    }
    private function getValidExistingToken(int $userId,int $isRemember):array|null 
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM {$this->table} WHERE user_id = {$userId} AND is_remember = {$isRemember} AND expires_at >='{$currentDateTime}'";
        $token = $this->database->fetchAll($sql);
        if($token){
            return $token[0];
        }
        return null;
    }
    private function createToken(int $userId,int $isRemember):array|null 
    {
        $validToken = $this->getValidExistingToken($userId,$isRemember);
        if($validToken != null)
        {
            return $validToken;
        }
          //otherwise enerate a new token,save in the DB and return the new Token
          $currentTime = date('Y-m-d H:i:s');
          $timeToBeAdded = $isRemember?self::$REMEMBER_EXPIRY_TIME : self::$FORGET_PWD_EXPIRY_TIME;

          $token = Hash::hash($userId);

          $expires_at = date('Y-m-d H:i:s', strtotime($currentTime . '+' .$timeToBeAdded));

          $data = [
              'user_id' => $userId,
              'token' => $token,
              'expires_at' => $expires_at,
              'is_remember' => $isRemember
          ];
          return $this->database->table($this->table)->insert($data)?$data : null;
        
    }
    
     
}