<?php 

// Access modifiers
// Public - can access globally
// Protected - can access only in class and the class which extends the class
// Private - can only access inside the class

class User{

    private $name;
    private $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    // Getter Method to get private data outside the class
    public function getName()
    {
        return $this->name;
    }

    // Setter Method to set private data outside the class
    public function setName($name)
    {
        $this->name = $name;
    }

    // __get MAGIC METHOD
    public function __get($property)
    {
        if(property_exists($this, $property)){
            return $this->$property;
        } else {
            echo 'Get Property does not Exist.';
        }
    }

    // __set MAGIC METHOD
    public function __set($property, $value)
    {
        if(property_exists($this, $property)){
            $this->$property = $value;
        } else {
            $this->$property = 'Set Property does not Exist.';
        }
        return $this;
    }

}

$user1 = new User('John', 26);
//echo $user1->name; // Fatal Erroe

// With custom Getter and Setter Methods
// echo $user1->setName('Jeff');
// echo $user1->getName();

$user1->__set('name', 'Akay');
echo $user1->__get('name');

echo '<br>';

$user1->__set('age', 30);
echo $user1->__get('age');

echo '<br>';

// Error Set Property does not exists
$user1->__set('aage', 30);
echo $user1->__get('aage');

?>