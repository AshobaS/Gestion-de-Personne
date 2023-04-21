<?php

namespace modele\entite;

/**
 * Classe Connection: classe des objets Connection
 */
class Connection
{
    private $ip;
    private $pseudo;
    private $connected;

    /**
     * Méthode constructer de la classe Connnection
     * Crée un objet Connection
     * Positionne la valeur des attributs $ip, $pseudp, $connect
     */
    public function __construct($ip,$pseudo,$connect)
    {
        $this->ip = $ip;
        $this->pseudo = $pseudo;
        $this->connected = $connect;
    }


    /**
     * Méthode getter de l'attribut $ip
     * Renvoie la valeur de l'attribut $ip
     * @param void
     * @return string $ip adresse ip de la personne qui a tenté de se connecter
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Méthode getter de l'attribut $pseudo
     * Renvoie la valeur de l'attribut $pseudo
     * @param void
     * @return string $pseudo indentifiant de connection de la personne qui a tenté de se connecter
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Méthode getter de l'attribut $connected
     * Renvoie la valeur de l'attribut $connected
     * @param void
     * @return bool $connected booleen qui indique si la personne a réussit à se connecter
     */
    public function getConnected()
    {
        return $this->connected;
    }


    /**
     * Méthode setter de l'attribut $ip
     * Positionne la valeur de l'attribut $ip
     * @param string $ip adresse ip de la personne qui a tenté de se connecter
     * @return void
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Méthode setter de l'attribut $pseudo
     * Positionne la valeur de l'attribut $pseudo
     * @param string $pseudo indentifiant de connection de la personne qui a tenté de se connecter
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * Méthode setter de l'attribut $connected
     * Positionne la valeur de l'attribut $connected
     * @param bool $connect booleen qui indique si la personne a réussi à se connecter
     * @return void
     */
    public function setConnected($connect)
    {
        $this->connected = $connect;
    }
}