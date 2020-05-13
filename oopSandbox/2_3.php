<?php 

// Define a class
class User {

    // Properties (Attributes)
    public $name;

    // Methods (Functions)
    public function sayHello(){
        return $this->name .' Says Hello';
    }

    public function accessMethod($aName){
        return $aName . ' Says Hello';
    }

}

// Instatiate a user object from the user class
$user1 = new User();
$user1->name = 'John';
echo $user1->sayHello();
echo '<br>';


// Create new user
$user2 = new User();
//$user2->name = 'Jeff';
echo $user2->accessMethod('Jeff');
?>