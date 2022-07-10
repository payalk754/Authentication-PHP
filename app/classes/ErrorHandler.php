<?php

class ErrorHandler
{
    private $errors = [];

    public function addError($error, $key){
        $this->errors[$key][] = $error;
    }
    //errors we have taken two dimensional arrays to catch all the errors
    //if we have taken one dimensional array then remove the previous which was caught.
    
    public function hasErrors(): bool {//count how many
        return count($this->errors) > 0;
    }

    public function has(string $key): bool {//list mein se kuch error hai kya
        return isset($this->errors[$key]);
    }

    public function first(string $key): string {//zeroth index wala error display krega
        if($this->has($key)){
            return $this->errors[$key][0];
        }
        return null;
        //return $this->errors[$key][0] ?? null;
    }

   /* public function all(string|null $key = null): array|null{
        if($key==null){
            return $this->errors;
        }
        return $this->errors[$key] ?? null;
    }*/
    public function all(string $key = null){
        if($key==null){
            return $this->errors;
        }
        return $this->errors[$key] != null ? $this->errors[$key]: null;
    }
   
 
}