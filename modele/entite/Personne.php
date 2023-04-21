<?php

namespace modele\entite;

/**
 * Classe Personne: classe des objets Personne
 */
class Personne
{
    private $id;
    private $nom;
    private $prenom;
    private $mail;
    private $age;
    private Genre $genre;
    private Role $role;
    private $identif;
    private $pass;

    /**
     * Méthode constructer de la classe Personne
     * Cree un objet Personne
     * Positionne les attributs $nom ,$prenom, $mail, $age, $identif et $pass
     * @param string $nom nom de la personne
     * @param string $prenom prenom de la personne
     * @param string $mail mail de la personne
     * @param int $age age de la personne
     * @param string $identif identifiant de connection de la personne
     * @param string $pass mot de passe de la personne
     * @return void
     */
    public function __construct($nom,$prenom,$mail,$age,$identif,$pass)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
        $this->age = $age;
        $this->identif = $identif;
        $this->pass = $pass;
    }


    /**
     * Méthode getter de l'attribut $id
     * Renvoie la valeur de l'attribut $id
     * @param void
     * @return int $id identifiant de la personne
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode getter de l'attribut $nom
     * Renvoie la valeur de l'attribut $nom
     * @param void
     * @return string $nom nom de la personne
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode getter de l'attribut $prenom
     * Renvoie la valeur de l'attribut $prenom
     * @param void
     * @return string $prenom prenom de la personne
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Méthode getter de l'attribut $mail
     * Renvoie la valeur de l'attribut $mail
     * @param void
     * @return string $mail mail de la personne
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Méthode getter de l'attribut $age
     * Renvoie la valeur de l'attribut $age
     * @param void
     * @return int $age age de la personne
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Méthode getter de l'attribut $genre
     * Renvoie la valeur de l'attribut $genre
     * @param void
     * @return GENRE $genre genre de la personne
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Méthode getter de l'attribut $role
     * Renvoie la valeur de l'attribut $role
     * @param void
     * @return ROLE $role rôle de la personne
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Méthode getter de l'attribut $identif
     * Renvoie la valeur de l'attribut $identif
     * @param void
     * @return string $identif identifiant de connection de la personne
     */
    public function getIdentif()
    {
        return $this->identif;
    }

    /**
     * Méthode getter de l'attribut $pass
     * Renvoie la valeur de l'attribut $pass
     * @param void
     * @return string $pass mot de passe de la personne
     */
    public function getPass()
    {
        return $this->pass;
    }
    

    /**
     * Méthode setter de l'attribut $nom
     * Positionne la valeur de l'attribut $nom
     * @param string $nom nom de la personne
     * @return void
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode setter de l'attribut $prenom
     * Positionne la valeur de l'attribut $prenom
     * @param string $prenom prenom de la personne
     * @return void
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Méthode setter de l'attribut $mail
     * Positionne la valeur de l'attribut $mail
     * @param string $mail mail de la personne
     * @return void
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Méthode setter de l'attribut $age
     * Positionne la valeur de l'attribut $age
     * @param int $age age de la personne
     * @return 
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * Méthode setter de l'attribut $genre
     * Positionne la valeur de l'attribut $genre
     * @param GENRE $genre genre de la personne
     * @return void
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * Méthode setter de l'attribut $role
     * Positionne la valeur de l'attribut $role
     * @param ROLE $role role de la personne
     * @return void
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Méthode setter de l'attribut $id
     * Postionne la valeur de l'attribut $id
     * @param int $id identifiant de la personne
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Méthode setter de l'attribut $identif
     * Positionne la valeur de l'attribut $identif
     * @param string $identif identifiant de connection de la personne
     * @return void
     */
    public function setIdentif($identif)
    {
        $this->identif = $identif;
    }

    /**
     * Méthode setter de l'attribut $pass
     * Positionne la valeur de l'attribut $pass 
     * @param string $pass mot de passe de la personne
     * @return void
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }


    /**
     * Méthode isAdmin de la classe Personne
     * Determine si la personne à le role administrateur
     * @param void
     * @return bool booleen qui indique si la personne a le role administrateur ou non
     */
    public function isAdmin()
    {
        if($this->getRole()->getId() == 2)
            return 1;
        else
            return 0;
    }

    
    public function __toString()
    {
        $retour = "Personne : ".$this->id." - ".$this->nom." - ".$this->prenom." - ".$this->mail." - ".$this->age." - ".$this->genre.$this->role." - ".$this->identif;
        return $retour;
    }
}