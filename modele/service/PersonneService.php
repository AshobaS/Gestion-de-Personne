<?php
namespace modele\service;

use modele\dao\PersonneDao as PersonneDao;

use modele\service\exception\ExceptionService as ExceptionService;
use modele\dao\exception\ExceptionDao as ExceptionDao;


/**
 * Classe PersonneService: classe des objets PersonneService
 */
class PersonneService
{
    private PersonneDao $dao;

    /**
     * Méthode constructer de la classe PersonneService
     * Cree un objet PersonneService
     * Positionne l'attribut $dao
     * Leve une exception si la création se passe mal
     * @param void
     * @return void
     */
    public function __construct()
    {
        try
        {
        $this->dao = new PersonneDao();  
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        } 
    }


    /**
     * Méthode findAll() de la classe PersonneService
     * Appelle la méthode findAll() de l'attribut $dao
     * @param void
     * @return array tableau des personnes contenus en base
     */
    public function findAll()
    {
        try
        {
        return $this->dao->findAll();
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }


    /**
     * Méthode create() de la classe PersonneService
     * Appelle la méthode create() de l'attribut $dao
     * @param Personne $personne caractéristiques de la personne à créer
     * @return bool booléen qui indique si la création s'est bien déroulée 
     */
    public function create($personne)
    {
        try
        {
        return $this->dao->create($personne);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

    /**
     * Méthode deletebyId() de la classe PersonneService
     * Appelle la méthode deletebyId() de l'attribut $dao
     * @param int $id identifiant de la personne à supprimer
     * @return bool booléen qui indique si la suppression s'est bien déroulée
     */
    public function deletebyId($id)
    {
        try
        {
        return $this->dao->deletebyId($id);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

    /**
     * Méthode deleteAll() de la classe PersonneService
     * Appelle la méthode deleteAll() de l'attribut $dao
     * @param int $id indentifiant de la personne connectée et qui ne sera pas supprimée
     * @return bool booléen qui indique si la suppression s'est bien déroulée
     */
    public function deleteAll($id)
    {
        try
        {
        return $this->dao->deleteAll($id);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

    /**
     * Méthode findbyId() de la classe PersonneService
     * Appelle la méthode findbyId() de l'attribut $dao
     * @param int $id identifiant de la personne que l'on recherche
     * @return Personne caractéristiques de la personne stockée en base
     */
    public function findbyId($id)
    {
        try
        {
        return $this->dao->findbyId($id);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

    /**
     * Méthode updatebyId() de la classe PersonneService
     * Appelle la méthode updatebyId() de l'attribut $dao
     * @param Personne $personne caractéristiques mises à jour de la personne
     * @return bool booléen qui indique si la mise à jour s'est bien déroulée
     */
    public function updatebyId($personne)
    {
        try
        {
        return $this->dao->updatebyId($personne);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

    /**
     * Méthode verify() de la classe PersonneService
     * Crypte le mot de passe en md5
     * Appelle la méthode verify() de l'attribut $dao
     * @param string $identif identifiant de connection de la personne
     * @param string $pass mot de passe de la personne
     * @return Personne caractéristique de la personne qui s'est connecté
     * Renvoie nulle si aucune personne ne correspondait au couple $identif $pass
     */
    public function verify($identif,$pass)
    {
        try
        {
        $pass = md5($pass);
        return $this->dao->verify($identif,$pass);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

}