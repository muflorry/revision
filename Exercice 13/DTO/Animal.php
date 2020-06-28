<?php

// Le code de ce fichier sera dans le namespace Pets
namespace Pets;

// Importation dans ce fichier des classes DateTime et Exception depuis le namespace global
use \DateTime;
use \Exception;

/**
 * Classe Animal matérialisant les animaux
 */

class Animal{
    /**
     *  Attributs
     */
    private $name;
    private $species;
    private $birthdate;

    /**
     * Constructeur de la classe permettant d'hydrater les animaux
     */
    public function __construct($name, $species, $birthdate){
        $this->setName($name);
        $this->setSpecies($species);
        $this->setBirthdate($birthdate);
    }

    // Getters
    public function getName(){
        return $this->name;
    }

    public function getSpecies(){
        return $this->species;
    }

    public function getBirthdate(){
        return $this->birthdate;
    }

    // Setters
    public function setName(string $name){

        if(!preg_match('/^.{2,60}$/i', $name)){
            throw new Exception('Le nom de l\'animal invalide(entre 2 et 60 caractères)');
        }

        $this->name = $name;
    }

    public function setSpecies(string $species){

        if(!preg_match('/^.{2,60}$/i', $species)){
            throw new Exception('L\espèce de l\'animal invalide(entre 2 et 60 caractères)');
        }

        $this->species = $species;
    }

    public function setBirthdate(DateTime $birthdate){

        $this->birthdate = $birthdate;
    }

    // Fonction permettant aux animaux de se présenter avec un écho
    public function introduce(){

        // Calcul de l'âge de l'animal à partir de sa date de naissance
        $birthDate = $this->getBirthdate();                //Date de naissance du chat
        $currentDate = new DateTime('now');                //Date d'aujourd'hui

        // Calcul de la différence entre les deux dates récupérées au dessus
        $differenceBetweenDates = $birthDate->diff($currentDate);

        // Récupération du nombre d'années (->y) dans la différence entre les deux dates
        $age = $differenceBetweenDates->y;

        // Affichage de la phrase
        echo 'Bonjour, je m\'appelle ' . htmlspecialchars($this->getName()) . ' je suis un ' . htmlspecialchars($this->getSpecies()) . ' et j\'ai ' . $age . ' ans !<br>';
    }
}