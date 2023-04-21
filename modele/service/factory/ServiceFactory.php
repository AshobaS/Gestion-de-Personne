<?php
namespace modele\service\factory;
use modele\service\GenreService as GenreService;
use modele\service\PersonneService as PersonneService;
use modele\service\RoleService as RoleService;
use modele\service\ConnectionService as ConnectionService;
use modele\service\Exception\ExceptionService as ExceptionService;

/**
* Classe ServiceFactory : fabrique de services 
*
* @package modele\service\factory
*
*/
class ServiceFactory { 
    // Méthode static
    static public function newService($classwithnamespace) {

        // Enregistrement du message dans le fichier log
        // Logger::write("Service -> ".$classwithnamespace);

        // Récupérer uniquement le nom de la classe sans le namespace
        $class = end (explode('\\', $classwithnamespace));

        switch ($class)
        {
            case "GenreService" :
                return new GenreService(); 
            break;

            case "PersonneService" :       
                return new PersonneService();  
            break;

            case "RoleService" :       
                return new RoleService();  
            break;

            case "ConnectionService":
                return new ConnectionService();
                break;
            default :
                throw new ExceptionService ("Impossible de créer le service demandé."); 
        }
	} 
}