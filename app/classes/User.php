<?php
class User 
{
    protected Database $database;

    protected string $table = "users";
    public static string $sessionKey = "user";

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function build()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,email VARCHAR(255) NOT NULL UNIQUE,username VARCHAR(50) NOT NULL,password VARCHAR(255) NOT NULL)";
        $this->database->raw($sql);
    }
    public function update(array $data, int $id)
    {
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        return $this->database->table($this->table)->update($data,['id'=>$id]);   
    }
    public function create(array $data){
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        return $this->database
               ->table($this->table)
               ->insert($data);
              //die("hello");

    }
    public function findByEmail(string $email){
        return $this->database->table($this->table)->where('email','=',$email)->first();
    }
    public function findById(int $id){
        return $this->database->table($this->table)->where('id','=',$id)->first();
    }

    public function signIn(array $data): bool {
        $username = $data['username'];
        $password = $data['password'];

        $user = $this->database
                     ->table($this->table)
                     ->orWhere(['username'=>$data['username'],'email'=>$data['username']]);
        if($user->count()) {
            $user = $user->first();
            if(Hash::verify($password,$user->password)) {
                $this->setAuthSession($user->id);
                return true;
            }
            return false;
        }
        return false;
    }
    public function signout()
    {
        unset($_SESSION[self::$sessionKey]);
    }
    protected function setAuthSession(int $id){
        $_SESSION[self::$sessionKey]=$id;
    }
    public function check() {
        return isset($_SESSION[self::$sessionKey]);
    }
   

}