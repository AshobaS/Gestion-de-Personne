<?php

namespace modele\service;
use modele\dao\ConnectionDao as ConnectionDao;

use modele\service\exception\ExceptionService as ExceptionService;
use modele\dao\exception\ExceptionDao as ExceptionDao;


/**
 * Classe ConnectionService: classe des objets ConnectionService
 */
class ConnectionService
{
    private ConnectionDao $dao;


    /**
     * Méthode constructer de la classe ConnectionService
     * Cree un objet ConnectionService
     * Positionne l'attribut $dao
     * Leve une exception si la création se passe mal
     * @param void
     * @return void
     */
    public function __construct()
    {
        try
        {
        $this->dao = new ConnectionDao();   
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }


    /**
     * Méthode verif() de la classe ConnectionService
     * Appelle la méthode findessaisbyIp() de l'attribut $dao
     * @param string $ip adresse ip de la personne qui essaye de se connecter
     * @return int nombre d'essais d'identification de la personne qui essaye de se connecter
     */
    public function verif($ip)
    {
        try
        {
        return $this->dao->findessaisbyIp($ip);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

    /**
     * Méthode UpdateTry() de la classe ConnectionService
     * Vérifie si le temps de blocage est écoulé puis modifie le nombre d'essais de connection
     * Appelle la méthode getDate() de la classe
     * Appelle la méthode verifDate() de la classe
     * Appelle la méthode updateEssais()
     * @param string $ip adresse ip de la personne qui essaye de se connecter
     * @return bool booleen qui indique si l'update s'est bien déroulé, si le temps n'étais pas écoulé renvoie NULL
     */
    public function updateTry($ip)
    {
        try
        {
        $time = $this->getDate($ip);
        $result = $this->verifDate($time);
        if($result == 1)
            return $this->updateEssais($ip);
        return null;
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

    /**
     * Méthode updateEssais() de la classe ConnectionService
     * Appelle la méthode updateessaisbyIp() de l'attribut $dao
     * @param string $ip adresse ip de la personne qui essaye de se connecter
     * @return bool booleen qui indique si l'update s'est bien déroulé
     */
    public function updateEssais($ip)
    {
        try
        {
        return $this->dao->updateessaisbyIp($ip);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

    /**
     * Méthode getDate() de la classe ConnectionService
     * Appelle la méthode finddatebyIp() de l'attribut $dao
     * @param string $ip adresse ip de la personne qui essaye de se connecter
     * @return DateTime date de la derniere tentative de connection de la personne
     */
    private function getDate($ip)
    {
        try
        {
        $time = $this->dao->finddatebyIp($ip);
        return new \DateTime($time);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }


    /**
     * Méthode verifDate() de la classe ConnectionService
     * Verifie que 10min se soit ecoulé le temps depuis la derniere tentative
     * @param DateTime $debut date de la derniere tentative de connection de la personne
     * @return bool $result booleen qui indique si plus ou moins de 10min s'est écoulé depuis la derniére tentative de connection
     */
    private function verifDate($debut)
    {
        try
        {
        $fin = new \DateTime('now');
        $interval = $debut->diff($fin);
        $time = (int)$interval->format("%R%I");
        if($time > 0)
            $result = 1;
        else
        {
            $time = (int)$interval->format("%R%H");
            if($time > 0)
                $result = 1;
            else
            {
                $time = (int)$interval->format("%R%D");
                if($time > 0)
                    $result = 1;
                else
                {
                    $time = (int)$interval->format("%R%M");
                    if($time > 1)
                        $result = 1;
                    else
                    {
                        $time = (int)$interval->format("%R%Y");
                        if($time > 1)
                            $result = 1;
                        else
                            $result = 0;
                    }
                }
            }
        }
        return $result;
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }


    /**
     * Méthode try() de la classe ConnectionService
     * Appelle la méthode connected() de la classe si la personne a réussi à se connecter
     * Appelle la méthode unconnected() de la classe si la personne n'a pas réussi à se connecter
     * @param Connection $connect details de la tentative de connection de la personne
     * @return bool booleen renvoyé par les méthodes de la classe qui indique si les updates se sont bien déroulés
     */
    public function try($connect)
    {
        try
        {
        $connected = $connect->getConnected();
        if($connected == 0)
            return $this->unconnected($connect);
        else
            return $this->connected($connect);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }

    /**
     * Méthode connected() de la classe ConnectionService
     * Appelle la méthode exist_connect() de l'attribut $dao pour savoir si la personne existe en base
     * Si elle existe appelle la méthode updatebyId() de l'attribut $dao
     * Si elle n'existe pas appelle la méthode create() de l'attribut $dao
     * @param Connection $connect details de la tentative de connection de la personne
     * @return bool booleen qui indique si les requetes se sont bien passées
     */
    private function connected($connect)
    {
        try
        {
        $id = $this->dao->exist_connect($connect);
        if($id == 0)
            return $this->dao->create($connect);
        else
            return $this->dao->updatebyID($id);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }


    /**
     * Méthode connected() de la classe ConnectionService
     * Appelle la méthode exist_connect() de l'attribut $dao pour savoir si la personne existe en base
     * Si elle existe appelle la méthode updatebyId() de l'attribut $dao
     * Si elle n'existe pas appelle la méthode create() de l'attribut $dao
     * @param Connection $connect details de la tentative de connection de la personne
     * @return bool booleen qui indique si les requetes se sont bien passées
     */
    private function unconnected($connect)
    {
        try
        {
        $id = $this->dao->exist_unconnect($connect);
        if($id == 0)
            return $this->dao->create($connect);
        else
            return $this->dao->updatebyId($id);
        }
        catch(ExceptionDao $e)
        {
            throw new ExceptionService($e->getMessage());
        }
    }


}