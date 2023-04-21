<?php

namespace modele\entite;

/**
 * Classe Role: classe des objets Role
 */
class Role
{
    private $id;
    private $libelle;

    /**
     * Méthode constructer de la classe Role
     * Cree un objet Role
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
     * @return int $id identifiant du rôle
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode getter de l'attribut $libelle
     * Renvoie la valeur de l'attribut $libelle
     * @param void
     * @return string $libelle nom du rôle
     */
    public function getLibelle()
    {
        return $this->libelle;
    }


    /**
     * Méthode setter de l'attribut $id
     * Positionne la valeur de l'attribut $id
     * @param int $id identifiant du rôle
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Méthode setter de l'attribut $libelle
     * Positionne la valeur de l'attribut $libelle
     * @param string $libelle nom du rôle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }


    /**
     * Méthode afficher de la classe Role
     * Affiche la traduction du nom du rôle
     * @param array $tab_lang tableau de traduction
     * @return void
     */
    public function afficher($tab_lang)
    {

        if($this->id == 1)
            echo $tab_lang["class_role_usr"];
        elseif($this->id == 2)
            echo $tab_lang["class_role_admin"];
    }
}