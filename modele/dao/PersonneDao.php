<?php

namespace modele\dao;

use modele\entite\Personne as Personne;
use modele\entite\Genre as Genre;
use modele\entite\Role as Role;

use modele\dao\exception\ExceptionDao as ExceptionDao;
use \PDO as PDO;


/**
 * Classe PersonneDao: classe des objets PersonneDao
 */
class PersonneDao
{
    private const TABLE = "T_PERSONNE";
    private const VIEW = "personne";
    private $connection;


    /**
     * Méthode constructer de la classe PersonneDao
     * Cree un objet PersonneDao
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
            $this->connection = $hconnection->getConnection();
        }
        catch (\Exception $e) 
        {
            throw new ExceptionDao('Impossible d\'établir la connexion à la BD.');
        }
    }   


    /**
     * Méthode create() de la classe PersonneDao
     * Crypte le mot de passe en md5
     * Prepare et execute une requete insert into
     * @param Personne $personne caracteristiques de la personne à ajouter en base
     * @return bool $result booleen qui indique si la requete s'est execute ou non
     */
    public function create($personne)
    {
        $pass = md5($personne->getPass());
        $requete = $this->connection->prepare("INSERT INTO ".self::TABLE." (nom,prenom,mail,age,idgenre,idrole,identifiant,pass) VALUES (:nom,:prenom,:mail,:age,:idgenre,:idrole,:identifiant,:pass)");
        $result = $requete->execute(array("nom" => $personne->getNom(),"prenom" => $personne->getPrenom(),"mail" => $personne->getMail(),"age" => $personne->getAge(),"idgenre" => $personne->getGenre()->getID(),"idrole" => $personne->getRole()->getId(),"identifiant" => $personne->getIdentif(),"pass" => $pass));
        $this->connection = null;
        return $result;
    }


    /**
     * Méthode deletebyId() de la classe PersonneDao
     * Prepare et execute une requeter delete where id = ?
     * @param int $id identifiant de la personne à modifier
     * @return $bool $retour booleen qui indique si la requete s'est executée ou non
     */
    public function deletebyId($id)
    {
        $requete = $this->connection->prepare("DELETE FROM ".self::TABLE." WHERE id_personne = ?");
        $retour = $requete->execute(array($id));
        $this->connection = null;
        return $retour;
    }

    /**
     * Méthode deleteAll() de la classe PersonneDao
     * Prepare et execute une requete delete where id != ?
     * @param int $id identifiant de la personne qui demande la requete et qui ne sera pas supprimé
     * @return bool $retour booleen qui indique si la requete s'est execute ou non
     */
    public function deleteAll($id)
    {
        $requete = $this->connection->prepare("DELETE FROM ".self::TABLE." WHERE id != ?");
        $retour = $requete->execute(array($id));
        $this->connection = null;
        return $retour;
    }


    /**
     * Méthode findAll() de la classe PersonneDao
     * Prepare et execute une requete select all
     * @param void
     * @return array $tab_personne tableau contenant toutes les personnes stockées en base
     */
    public function findAll()
    {
        $requete = $this->connection->prepare('SELECT * FROM '.self::VIEW);
        $requete->execute();
        $result = $requete->fetchAll(PDO::FETCH_ASSOC);
        $tab_personne = array();

        foreach($result as $value) 
        {
            $genre = new Genre();
            $genre->setId($value['idgenre']);
            $genre->setLibelle($value['glibelle']);
            $role = new Role();
            $role->setId($value['idrole']);
            $role->setLibelle($value['rlibelle']);
            $personne = new Personne($value['prenom'], $value['nom'],$value['mail'],$value['age'],$value['identifiant'],['pass']);
            $personne->setId($value ['id_personne']);
            $personne->setGenre($genre);
            $personne->setRole($role);
            $tab_personne[]=$personne;
        }
        $this->connection = null;
        return $tab_personne;
    }


    /**
     * Méthode findbyId() de la classe PersonneDao
     * Prepare et execute une requete select where id = ?
     * @param int $id identifiant de la personne que l'on recherche
     * @return Personne $personne caractéristiques de la personne correspondant à l'id
     */
    public function findbyId($id)
    {
        $requete = $this->connection->prepare("SELECT * FROM ".self::VIEW." WHERE id_personne = ?");
        $requete->execute(array($id));
        $value = $requete->fetch(PDO::FETCH_ASSOC);
        $genre = new Genre();
        $genre->setId($value['idgenre']);
        $genre->setLibelle($value['glibelle']);
        $role = new Role();
        $role->setId($value['idrole']);
        $role->setLibelle($value['rlibelle']);
        $personne = new Personne($value['prenom'], $value['nom'],$value['mail'],$value['age'],$value['identifiant'],['password']);
        $personne->setId($value ['id_personne']);
        $personne->setGenre($genre);
        $personne->setRole($role);
        return $personne;
    }


    /**
     * Méthode updatebyId() de la classe PersonneDao
     * Prepare et execute une requete update where id = ?
     * @param Personne $personne caractéristiques de la personne à modifier
     * @return bool $resultat booleen qui indique si la requete s'est execute ou non
     */
    public function updatebyId($personne)
    {
        $pass = md5($personne->getPass());
        $requete = $this->connection->prepare("UPDATE ".self::TABLE." SET nom = ? , prenom = ? , mail = ? , age = ? , idgenre = ? , idrole = ? , identifiant = ? , pass = ? WHERE id_personne = ?");
        $resultat = $requete->execute(array($personne->getNom(),$personne->getPrenom(),$personne->getMail(),$personne->getAge(),$personne->getGenre()->getId(),$personne->getRole()->getId(),$personne->getIdentif(),$pass,$personne->getId()));
        $this->connection = null;
        return $resultat;
    }

    public function verify($identifiant,$password)
    {
        $requete = $this->connection->prepare("SELECT id_personne, nom, prenom, age,mail, idgenre, idrole, rlibelle, glibelle FROM ".self::TABLE.", t_genre, t_role WHERE idgenre = id_genre AND idrole = id_role AND identifiant = ? AND pass = ?");
        $requete->execute(array($identifiant,$password));
        $value = $requete->fetch(PDO::FETCH_ASSOC);
        if($value != false)
        {
            $genre = new Genre();
            $genre->setId($value['idgenre']);
            $genre->setLibelle($value['glibelle']);
            $role = new Role();
            $role->setId($value['idrole']);
            $role->setLibelle($value['rlibelle']);
            $personne = new Personne($value['prenom'], $value['nom'],$value['mail'],$value['age'],$identifiant,$password);
            $personne->setId($value ['id_personne']);
            $personne->setGenre($genre);
            $personne->setRole($role);
            $this->connection = null;
            return $personne;
        }
        else
        {
            $this->connection = null;
            return null;
        }
    }

}