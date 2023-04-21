<?php

namespace modele\dao;

use modele\entite\Genre as Genre;

use modele\dao\exception\ExceptionDao as ExceptionDao;
use \PDO as PDO;


/**
 * Classe GenreDao: classe des objets GenreDao
 */
class GenreDao
{
    private const TABLE = "T_GENRE";
    private $connection;

    /**
     * Méthode constructer de la classe GenreDao
     * Cree un objet GenreDao
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
            throw new ExceptionDao($e->getMessage());
        }
    }   


    /**
     * Méthode findAll() de la classe GenreDao
     * Prepare et execute une requete select all
     * @param void
     * @return array $tab_role tableau contenant tous les genres stockés en base
     */
    public function findAll()
    {
        $tab_genre = array();
        $requete = $this->connection->prepare('SELECT * FROM '.self::TABLE);
        $requete->execute();
        $result = $requete->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $value) 
        {
            $genre = new Genre();
            $genre->setId($value['id_genre']);
            $genre->setLibelle($value['glibelle']);
            $tab_genre[]=$genre;
        }
        $this->connection = null;
        return $tab_genre;
    }


    /**
     * Méthode findbyId() de la classe GenreDao
     * Prepare et execute une requete select where id = ?
     * @param int îd indentifiant du genre que l'on cherche
     * @return Genre $genre caracteristiques du genre correspondant à l'id
     */
    public function findbyId($id)
    {
        $requete = $this->connection->prepare("SELECT * FROM ".self::TABLE." WHERE id = ?");
        $requete->execute(array($id));
        $value = $requete->fetch(PDO::FETCH_ASSOC);
        $genre = new Genre();
        $genre->setId($value ['id_genre']);
        $genre->setLibelle($value ['glibelle']);
        $this->connection = null;
        return $genre;
    }


}