<?php 

class game {

   //La méthode chooseHeros() crée un tableau de héros avec des caractéristiques spécifiques et renvoie un héros choisi aléatoirement.
    public function chooseHeros(){
        $herosArray = array(
            new heros ("Seong Gi-hun", 15, 2, 1),
            new heros ("Kang Sae-byeok", 25, 1, 2),
            new heros ("Cho Sang-woo", 35, 0, 3)
        );

        $randomChoice = rand(0, count($herosArray) - 1);
        return $herosArray[$randomChoice];
    }

    // La méthode createEnnemy($difficulty) génère des ennemis en fonction de la difficulté choisie. Les ennemis ont des noms aléatoires et des caractéristiques aléatoires.
    public function createEnnemy($difficulty){
        $arrayEnnemyName = array("Jhon","Charles", "Celia", "Axel", "Mark", "Timmy", "Nathan", "Silvia", "Xavier", "Steve", "Kevin", "Jude", "Caleb", "Jack", "Bobby", "Erik", "Willy", "Jim", "Max", "Todd");

        $arrayEnnemy = array();
        for($i = 0; $i < $difficulty; $i++){ 
            $chooseName = $arrayEnnemyName[rand(0, count($arrayEnnemyName) - 1)];
            array_push($arrayEnnemy, new ennemy ($chooseName, rand(1, 20), rand(50, 100)));
        }
        return $arrayEnnemy;
    }

    //La méthode chooseDifficulty() détermine la difficulté du jeu de manière aléatoire et retourne un nombre de niveaux correspondant à la difficulté.
    public function chooseDifficulty(){
        $difficulty = rand(1, 3);
        if($difficulty == 1){
             echo "Vous avez choisi la difficulté : Facile" . "</br>";
             return 5;
         }else if($difficulty == 2){
                echo "Vous avez choisi la difficulté : Moyen" . "</br>";
                return 10;
         }else{
                echo "Vous avez choisi la difficulté : Difficile" . "</br>";
                return 20;
         }
    }

    // La méthode beLoyal($player, $ennemy) simule le choix d'être loyal ou de tricher en fonction de l'âge de l'ennemi. Si l'ennemi a plus de 70 ans, le joueur peut choisir de tricher avec une probabilité de 50%.
    public function beLoyal($player, $ennemy){
        if($ennemy->age > 70){
            $randomChoice = rand(1, 2);
            if($randomChoice == 1){
                $player->cheat($ennemy);
            }else{
                echo "Vous êtes resté loyal" . "</br>";
                return true;
            }
        }else {
            return true;
        }
    }

    // La méthode game() est le cœur du jeu, où le joueur choisit un héros, la difficulté est déterminée, et le joueur affronte des ennemis successifs.
    public function game(){
        $player = $this->chooseHeros();
        echo "Vous avez choisi " . $player->name . " avec " . $player->marbleNumber . " billes " . "</br>";
        $difficulty = $this->chooseDifficulty();
        $ennemy = $this->createEnnemy($difficulty);

        $currentLevel = 1;
        while($player->marbleNumber > 0 && $currentLevel <= $difficulty){
            echo "<hr></br>" . "Niveaux " . $currentLevel . "<hr></br>";
            echo "Vous avez : " . $player->marbleNumber . " billes" . "</br>";

         
            // Appel de la fonction beLoyal pour déterminer si le joueur triche ou non
            if($this->beLoyal($player, $ennemy[$currentLevel-1])){   
                $choice = $player->chooseOddOrEven();
                echo "Vous avez choisi : " . $choice . "</br>";
                $player->getCheckOddOrEven($ennemy[$currentLevel-1], $choice);
            }


            $currentLevel++;
        } 
        
        // Affichage du résultat final du jeu
        if($player->marbleNumber > 0){
            echo "<hr><br> Vous avez gagné 45,6 milliards de Won sud-coréen !" . "</br>" . "Vous avez " . $player->marbleNumber . " billes </br> <hr>";
        }else if($player->marbleNumber <= 0){
            echo "<hr><br>Vous avez perdu !" . "</br><hr>";
        }
    }

}  

// Cette classe déclare des méthodes abstraites win et lose que les classes dérivées (heros et ennemy) doivent implémenter.
abstract class character{

    abstract function win($char);
    
    abstract function lose($char);

}

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


// Une instance de la classe game est créée à la fin du script,
$game = new game();

// et la méthode game() est appelée pour démarrer le jeu.
$game->game();

?>