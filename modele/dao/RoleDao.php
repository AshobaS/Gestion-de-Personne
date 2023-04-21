<?php

namespace modele\dao;

use modele\entite\Role as Role;

use modele\dao\exception\ExceptionDao as ExceptionDao;
use \PDO as PDO;


/**
 * Classe RoleDao: classe des objets RoleDao
 */
class RoleDao
{
    private const TABLE = "T_ROLE";
    private $connection;

    /**
     * Méthode constructer de la classe RoleDao
     * Cree un objet RoleDao
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
     * Méthode findAll() de la classe RoleDao
     * Prepare et execute une requete select all
     * @param void
     * @return array $tab_role tableau contenant tous les roles stockés en base
     */
    public function findAll()
    {
        $tab_role = array();
        $requete = $this->connection->prepare('SELECT * FROM '.self::TABLE);
        $requete->execute();
        $result = $requete->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $value) 
        {
            $role = new Role();
            $role->setId($value['id_role']);
            $role->setLibelle($value['rlibelle']);
            $tab_role[]=$role;
        }
        $this->connection = null;
        return $tab_role;
    }


    /**
     * Méthode findbyId() de la classe RoleDao
     * Prepare et execute une requete select where id = ?
     * @param int îd indentifiant du role que l'on cherche
     * @return Role $role caracteristiques du role correspondant à l'id
     */
    public function findbyId($id)
    {
        $requete = $this->connection->prepare("SELECT * FROM ".self::TABLE." WHERE id = ?");
        $requete->execute(array($id));
        $value = $requete->fetch(PDO::FETCH_ASSOC);
        $role = new Role;
        $role->setId($value ['id_role']);
        $role->setLibelle($value ['rlibelle']);
        $this->connection = null;
        return $role;
    }


}