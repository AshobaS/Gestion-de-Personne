<?php

namespace modele\entite;

/**
 * Classe Genre: classe des objets Genre
 */
class Genre
{
    private $id;
    private $libelle;

    /**
     * Méthode constructer de la classe Genre
     * Cree un objet Genre
     * Positionne la valeur de l'attribut $libelle
     * @param void
     * @return void
     */
    public function __construct()
    {
        $this->libelle = "";
    }


    /**
     * Méthode getter de l'attribut $id
     * Renvoie la valeur de l'attribut $id
     * @param void
     * @return int $id indentifiant du genre
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode getter de l'attribut $libelle
     * Renvoie la valeur de l'attribut $libelle
     * @param void
     * @return string $libelle nom du genre
     */
    public function getLibelle()
    {
        return $this->libelle;
    }


    /**
     * Méthode setter de l'attribut $id
     * Positionne la valeur de l'attribut $id
     * @param int $id identifiant du genre
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Méthode setter de l'attribut $libelle
     * Positionne la valeur de l'attribut $libelle
     * @param string $libelle nom du genre
     * @return void
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }


    /**
     * Méthode afficher de la classe Genre
     * Afficher la traduction du nom du genre
     * @param array $tab_lang tableau de traduction
     * @return void
     */
    public function afficher($tab_lang)
    {
        if($this->id == 1)
            echo $tab_lang["class_genre_hom"];
        elseif($this->id == 2)
            echo $tab_lang["class_genre_fem"];
    }
}