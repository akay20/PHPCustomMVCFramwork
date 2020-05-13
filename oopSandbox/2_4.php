<?php 
// constructor and Destructor

class User {

    // Properties
    public $name;
    public $age;

    // Methods
    // Construct - Predefined Magic Method
    // Runs when a object is created or instantiated
    public function __construct($name, $age)
    {
        // __CLASS__ - Predefined Magic Constant
        echo 'Class ' . __CLASS__ . ' instantiated.<br>';
        $this->name = $name;
        $this->age = $age;
    }

    // User defined Method
    public function sayHello($aName)
    {
        return $this->name . ' and ' . $aName . ' Says Hello.';
    }

    // Destruct - Predefined Magic Method
    // Called when no other refrences to certain object
    // Used for cleanup, closing connections, etc
    public function __destruct()
    {
        echo 'This is distructor.';
    }

}

// Object
$user1 = new User('Brad', 26);
echo $user1->name . ' is ' . $user1->age . ' years old.';
echo '<br>';
echo $user1->sayHello('Jeff');

echo '<br><br>';

$user2 = new User('Sarah', 25);
echo $user2->name . ' is ' . $user2->age . ' years old.';
echo '<br>';
echo $user2->sayHello('Akay');

?>