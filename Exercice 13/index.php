<?php

// Inclusion du fichier contenant la classe Cat
require 'DTO/Animal.php';

// La classe Animal étant enfermée dans la namespace Pets, on l'importe pour être utilisable directement dans ce fichier
use Pets\Animal;

try{

    // Hydratation des animaux
    $minou = new Animal('Minou', 'chat', new DateTime('2000-01-01'));
    $minou->introduce();

    $rex = new Animal('Rex', 'chien', new DateTime('2008-02-02'));
    $rex->introduce();

    $alex = new Animal('Alex', 'cochon d\'inde', new DateTime('2013-03-03'));
    $alex->introduce();


} catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
} catch(TypeError $e){
    die('Erreur : ' . $e->getMessage());
}