<?php

namespace modele\service\exception;

use \Exception as Exception;

/**
 * Classe ExceptionService: cree des objets ExceptionService
 * Herite de la classe Exception
 */
class ExceptionService extends Exception
{

    /**
     * Méthode constructer de la classe ExceptionService
     * Cree un objet ExceptionService
     * Appelle le constructeur de la classe Exception
     * @param string $message message de l'exception
     * @param int $code code de l'exception
     * @return void
     */
    public function __construct($message = NULL,$code = 0)
    {
        parent::__construct($message,$code);
    }


    /**
     * Méthode affiche de la classe ExceptionService
     * Affiche l'heure et affiche le message de l'exception
     * @param void
     * @return void
     */
    public function affiche()
    {
        $timezone = date_default_timezone_get();
        $chaine = $timezone . PHP_EOL . $this->getMessage() . PHP_EOL . $this;
        return $chaine;
    }
}