<?php


// Cette classe déclare des méthodes abstraites win et lose que les classes dérivées (heros et ennemy) doivent implémenter.
abstract class character{

    abstract function win($char);
    
    abstract function lose($char);

}

?>