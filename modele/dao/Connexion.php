<?php

namespace modele\dao;

use \PDO as PDO;
use \PDOException as PDOException;


/**
 * Classe Connexion: classe des objets Connexion
 */
class Connexion
{
    private $user;
    private $pass;
    private $driver;
    private $host;
    private $database;
    private $charset;


    /**
     * Méthode constructer de la classe Connexion
     * Cree un objet Connexion
     * @param void
     * @return void
     */
    public function __construct() 
    {
        $this->user="root";
        $this->pass="";
        $this->driver="mysql";
        $this->host="localhost";
        $this->database="db_test";
        $this->charset="utf8";
    }

    
    public function getConnection()
    {
        $dsn = $this->driver.':host='.$this->host.';dbname='.$this->database.';charset='.$this->charset;

        try
        {
            $connection = new PDO($dsn,$this->user, $this->pass);
            return $connection;
        }
        catch (PDOException $e)
        {
            throw new \Exception("Connexion impossible \n");
        }

    }
}