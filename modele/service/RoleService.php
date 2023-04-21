<?php
namespace modele\service;

use modele\dao\RoleDao as RoleDao;

use modele\service\exception\ExceptionService as ExceptionService;
use modele\dao\exception\ExceptionDao as ExceptionDao;


/**
 * Classe RoleService: classe des objets RoleService 
 */
class RoleService
{
    private RoleDao $dao;

    /**
     * Méthode constructer de la classe RoleService
     * Cree un objet RoleService
     * Positionne l'attribut $dao
     * Leve une exception si la création se passe mal
     * @param void
     * @return void
     */
    public function __construct()
    {
        try
        {
        $this->dao = new RoleDao();   
        }
        catch(ExceptionService $e)
        {
            throw new ExceptionDao($e->getMessage());
        }
    }


    /**
     * Méthode findAll() de la classe RoleService
     * Appelle la méthode findAll() de l'attribut $dao
     * @param void
     * @return array tableau des roles contenus en base
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
    
}