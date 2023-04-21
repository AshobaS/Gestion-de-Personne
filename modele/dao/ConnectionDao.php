<?php

namespace modele\dao;

use modele\dao\exception\ExceptionDao as ExceptionDao;
use \PDO as PDO;


/**
 * Classe ConnectionDao: classe des objets ConnectionDao
 */
class ConnectionDao
{
    private const TABLE = "T_CONNECTION";
    private $hconnection;

    /**
     * Méthode constructer de la classe ConnectionDao
     * Cree un objet ConnectionDao
     * Positionne l'attribut $hconnection
     * Leve une exception si la création se passe mal
     * @param void
     * @return void
     */
    public function __construct()
    {
        try 
        {
            $hconnection = new Connexion();
            $this->hconnection = $hconnection->getConnection();
        }
        catch (\Exception $e) 
        {
            throw new ExceptionDao($e->getMessage());
        }
    }   


    /**
     * Méthode exist_connect() de la classe ConnectionDao
     * Prépare et exécute une requete select by ip
     * @param Connection $connect caractéristiques de la connection
     * @return int $id identifiant de la connection correspondant si il existe
     * Sinon renvoie 0
     */
    public function exist_connect($connect)
    {
        $requete = $this->hconnection->prepare("SELECT id_connection FROM ".self::TABLE." where ip = ? and connected = 1");
        $requete->execute(array($connect->getIp()));
        $value = $requete->fetch(PDO::FETCH_ASSOC);
        if($value != false)
        {
            $id = $value['id_connection'];
            return $id;
        }
        else
        {
            return 0;
        }
    }


    /**
     * Méthode exist_connect() de la classe ConnectionDao
     * Prépare et exécute une requete select by ip
     * @param Connection $connect caractéristiques de la connection
     * @return int $id identifiant de la connection correspondant si il existe
     * Sinon renvoie 0
     */
    public function exist_unconnect($connect)
    {
        $requete = $this->hconnection->prepare("SELECT id_connection FROM ".self::TABLE." where ip = ? and connected = 0");
        $requete->execute(array($connect->getIp()));
        $value = $requete->fetch(PDO::FETCH_ASSOC);
        if($value != false)
        {
            $id = $value['id_connection'];
            return $id;
        }
        else
        {
            return 0;
        }
    }

    /**
     * Méthode updatebyId() de la classe ConnectionDao
     * Prepare et exécute une requete update by id
     * @param int $id identification de la connection à modifier
     * @return bool $resultat booléen qui indique si la requete s'est executee ou non
     */
    public function updatebyId($id)
    {
        $requete = $this->hconnection->prepare("UPDATE ".self::TABLE." SET essais = essais + 1, derniere_co = now() where id_connection = ?");
        $resultat = $requete->execute(array($id));
        $this->hconnection = NULL;
        return $resultat;
    }

    /**
     * Méthode create() de la classe ConnectionDao
     * Prepare et execute une requete insert into
     * @param Connection $connect caracteristiques de la connection à creer
     * @return bool $resultat booleen qui indique si la requete s'est executee ou non
     */
    public function create($connect)
    {
        $requete = $this->hconnection->prepare("INSERT INTO ".self::TABLE." (ip,pseudo,essais,derniere_co,connected) VALUES (:ip,:pseudo,1,now(),:connected)");
        $resultat = $requete->execute(array("ip" => $connect->getIp(), "pseudo" => $connect->getPseudo(),"connected" => $connect->getConnected()));
        $this->hconnection = null;
        return $resultat;
    }

    /**
     * Méthode findessaisbyIp() de la classe ConnectionDao
     * Prepare et execute une requete select where ip = ?
     * @param string $ip adresse ip de la personne qui essaye de se connecter
     * @return int $try nombre de fois que l'ip a essaye de se connecter sans y arriver
     */
    public function findessaisbyIp($ip)
    {
        $requete = $this->hconnection->prepare("SELECT essais FROM ".self::TABLE." where ip = ? and connected = 0");
        $requete->execute(array($ip));
        $value = $requete->fetch(PDO::FETCH_ASSOC);
        $this->hconnection = null;
        $try = $value['essais'];
        return $try;
    }

    /**
     * Méthode updateessaisbyIp() de la classe ConnectionDao
     * Prepare et execute une requete update where ip = ?
     * Met le nombre d'essais à 0
     * @param string $ip adresse ip de la personne qui essaye de se connecter
     * @return bool $resultat booleen qui indique si la requete s'est executée ou non
     */
    public function updateessaisbyIp($ip)
    {
        $requete = $this->hconnection->prepare("UPDATE ".self::TABLE." SET essais = 0 where ip = ? and connected = 0");
        $resultat = $requete->execute(array($ip));
        $this->hconnection = null;
        return $resultat;
    }

    /**
     * Méthode finddatebyIp() de la classe ConnectionDao
     * Prépare et execute une requete select where ip = ?
     * @param string $ip adresse ip de la personne qui essaye de se connecter
     * @return datetime date de la derniere tentative de connection echoue de l'ip
     */
    public function finddatebyIp($ip)
    {
        $requete = $this->hconnection->prepare("SELECT derniere_co FROM ".self::TABLE." where ip = ? and connected = 0");
        $requete->execute(array($ip));
        $value = $requete->fetch(PDO::FETCH_ASSOC);
        return $value['derniere_co'];
    }
    
}