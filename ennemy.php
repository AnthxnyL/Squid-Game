<?php 

// Cette classe représente un ennemi avec des méthodes pour gérer les victoires et les défaites.
class ennemy extends character{

    public $name;
    public $marbleNumber;
    public $age;

    public function __construct($name, $marbleNumber, $age){
        $this->name = $name;
        $this->marbleNumber = $marbleNumber;
        $this->age = $age;
    }

    public function win($character){
        $this->marbleNumber += $character->marbleNumber;
    }

    public function lose($character){
        $this->marbleNumber = 0;
    }
}

?>