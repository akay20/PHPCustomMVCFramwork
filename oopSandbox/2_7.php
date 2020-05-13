<?php // Static Methods and Properties

class User {
    public $name;
    public $age;
    public static $minPassLength = 6;

    public static function validatePass($pass)
    {
        // Self - used to access property inside the same class
        if(strlen($pass) >= self::$minPassLength){
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

$password = 'hello1';

if(User::validatePass($password)){
    echo 'Password Valid';
} else {
    echo 'Password Not Valid';
}

?>