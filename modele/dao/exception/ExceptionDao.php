<?php

namespace modele\dao\exception;

use \Exception as Exception;


/**
 * Classe ExceptionDao: classe des objets ExceptionDao
 */
class ExceptionDao extends Exception
{

    /**
     * Méthode constructer de la classe ExceptionDao
     * Cree un objet ExceptionDao
     * Appelle le constructeur de la classe Exception
     * @param string $message message de l'exception
     * @param int $code code de l'exception
     * @return void
     */
    public function __construct($message = NULL,$code = 0)
    {
        parent::__construct($message,$code);
    }
}