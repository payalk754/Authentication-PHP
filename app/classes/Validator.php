<?php

class Validator{

    private ErrorHandler $errorHandler;
    private Database $db;
    private $rules = ['required','minlength','maxlength','email','unique'];

    private $messages = [
        'required' => 'The :field is required',
        'minlength' => 'The :field must be minimum of :satisfier character',
        'maxlength' => 'The :field must be minimum of :satisfier character',
        'email' => 'This is not a valid email address',
        'unique' => 'The :field is already taken'
    ];
    public function __construct(Database $database)
    {
        $this->db = $database;
        $this->errorHandler = new ErrorHandler();
    }
    public function fails(): bool{
        return $this->errorHandler->hasErrors();
    }

    public function validate(array $data, array $rules)
    {
        foreach($data as $key => $value){
            if(in_array($key,array_keys($rules))) {
                $this->check([
                    'field' => $key,
                    'value' => $value,
                    'rules' => $rules[$key]
                ]);
            }
        }
    }

    
    public function check(array $item)
    {
        $field = $item['field'];
        foreach($item['rules'] as $rule=>$satisfier)
        {
            if(! call_user_func_array([$this, $rule], [$field, $item['value'],$satisfier]))
            {
                $errorMessage = $this->messages[$rule];
                $errorMessage = str_replace([':field', ':satisfier'], [$field, $satisfier], $errorMessage);
                $this->errorHandler->addError($errorMessage,$field);

            }
        }
    }

    private function required($field, $value, $satisfier):bool
    {
        return $satisfier ? !empty(trim($value)) : true;
    }

    public function minLength($field, $value,$satisfier): bool
    {
        return mb_strlen($value) >= $satisfier;
    }
    
    public function maxLength($field, $value,$satisfier): bool
    {
        return mb_strlen($value) <= $satisfier;
    }

    public function email($field,$value,$satisfier): bool
    {
        return filter_var($value,FILTER_VALIDATE_EMAIL);
    } 
    private function unique($field,$value, $satisfier): bool
    {
        $temp = explode("." ,$satisfier);
        $tableName = $temp[0];
        $columnName = $temp[1];

        return ! $this->db->table($tableName)->exists($columnName,$value);
    }
    //explode -->split krega
    public function errors() {
        return $this->errorHandler;
    }
    
}


?>