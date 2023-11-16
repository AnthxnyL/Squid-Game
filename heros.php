<?php


// Cette classe représente le héros avec des méthodes pour gérer les victoires, les défaites, et le choix entre impair et pair.
class heros extends character{

    public $name;
    public $marbleNumber;
    public $loss;
    public $gain;

    public function __construct($name, $marbleNumber, $gain, $loss){
        $this->name = $name;
        $this->marbleNumber = $marbleNumber;
        $this->gain = $gain;
        $this->loss = $loss;
    }

    public function win($character){
            $this->marbleNumber += $character->marbleNumber + $this->gain;
            $character->marbleNumber = 0;
            echo "Vous avez battu " . $character->name . " et vous avez maintenant " . $this->marbleNumber . " billes." . "</br>";
    }

    public function lose($character){
        $this->marbleNumber -= $character->marbleNumber + $this->loss;
        echo "Vous avez perdu contre "  . $character->name .  " et vous avez maintenant " . $this->marbleNumber . " billes.". "</br>"; 
    }

    // La méthode chooseOddOrEven() retourne une chaîne "odd" ou "even" de manière aléatoire.
    public function chooseOddOrEven(){
        $randomChoice = rand(1, 2);
        if($randomChoice == 1){
            return "odd";
        }else{
            return "even";
        }
    }

    // La méthode cheat($character) permet au joueur de tricher et de voler les billes d'un ennemi.
    public function cheat($character){
        $this->marbleNumber += $character->marbleNumber;
        $character->marbleNumber = 0;
        echo "Vous avez volé les billes de " . $character->name . " et vous avez maintenant " . $this->marbleNumber . " billes." . "</br>";
    }

    // La méthode checkOddOrEven($character, $choice) compare le choix du joueur avec le nombre de billes de l'adversaire pour déterminer le résultat de la manche.
    private function checkOddOrEven( $character, $choice){
        if ($choice == "odd" && $character->marbleNumber % 2 != 0 || $choice == "even" && $character->marbleNumber % 2 == 0){
            $this->win($character);
            $character->lose($this);
        }else{
                $this->lose($character);
                $character->win($this);
            }
    }

    // Permet d'avoir accès à la méthode checkOddOrEven() en dehors de la classe.
    public function getCheckOddOrEven( $character, $choice){
        $this->checkOddOrEven($character, $choice);
    }
    
}

?>