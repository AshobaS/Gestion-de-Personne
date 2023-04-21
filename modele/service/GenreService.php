<?php

namespace modele\service;

use modele\dao\GenreDao as GenreDao;

use modele\service\exception\ExceptionService as ExceptionService;
use modele\dao\exception\ExceptionDao as ExceptionDao;

/**
 * Classe GenreService: classe des objets GenreService 
 */
class GenreService
{
    private GenreDao $dao;

    /**
     * Méthode constructer de la classe GenreService
     * Cree un objet GenreService
     * Positionne l'attribut $dao
     * Leve une exception si la création se passe mal
     * @param void
     * @return void
     */
    public function __construct()
    {
        try
        {
        $this->dao = new GenreDao();   
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }


    /**
     * Méthode findAll() de la classe GenreService
     * Appelle la méthode findAll() de l'attribut $dao
     * @param void
     * @return array tableau des genres contenus en base
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