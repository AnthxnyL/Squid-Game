<?php

require("character.php");
require("heros.php");
require("ennemy.php");
require("game.php");

// Une instance de la classe game est créée à la fin du script,
$game = new game();

// et la méthode game() est appelée pour démarrer le jeu.
$game->game();

?>