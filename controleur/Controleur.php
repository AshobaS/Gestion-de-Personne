<?php
require_once "../Autoloader.php";
require_once "tab_var.php";

use modele\entite\Genre as Genre;
use modele\entite\Role as Role;
use modele\entite\Personne as Personne;
use modele\entite\Connection as Connection;

use modele\service\factory\ServiceFactory as ServiceFactory;

use modele\service\exception\ExceptionService as ExceptionService;

ini_set('session.gc_maxlifetime', 600);
session_id('myid');
session_start();

$action = $_GET["action"];
unset($_SESSION['message']);

if(isset($_SESSION['lang']))
{
    $langue = $_SESSION['lang'];
    $lang = LANG . $langue . ".php";
    include $lang; 
}

if(($action != null) && ($action != "connecter") && (!isset($_SESSION['user'])))
    $action = "deconnecter";

switch ($action) 
{
    case "afficher_creer_personne":
        try 
        {
            // On récupère la liste des genres dans la base de données
            $service = ServiceFactory::newService(GenreService::class);
            $_SESSION['genres'] = $service->findAll();

            //On recupere la liste des roles dans la base de données
            $service = ServiceFactory::newService(RoleService::class);
            $_SESSION['roles'] = $service->findAll();

            // On redirige sur la page creer_personne.php
            header('location: '.PAGE.$tab_vues['Vue_create']);
        } 
        catch (ExceptionService $e) 
        {
            $_SESSION["message"] = $tab_lang["Err_connex"];
            file_put_contents($tab_vues['logs'],$e->affiche(), FILE_APPEND);
            header('location: '.PAGE.$tab_vues['Vue_acc']);
        }
        break;

    case "afficher_liste_personne":
        try 
        {
            // On recupere toutes les personnes de la base de données
            $service = ServiceFactory::newService(PersonneService::class);
            $tab = $service->findAll();

            // On met le tableau de personnes en variables de session
            $_SESSION['personnes'] = $tab;

            // On rediriger vers la page afficher_personnes.php
            header('location: '.PAGE.$tab_vues['Vue_aff']);
        } 
        catch (ExceptionService $e) 
        {
            $_SESSION["message"] = $tab_lang["Err_connex"];
            file_put_contents($tab_vues['logs'],$e->affiche(), FILE_APPEND);
            header('location: '.PAGE.$tab_vues['Vue_acc']);
        }
        break;

    case "creer_personne":
        // On verifie que tous les champs du formulaires ont bien ete saisis
        $message = verifier_rempli($tab_lang);

        if (!empty($message)) 
        {
            $_SESSION['message'] = $message;
            header('location: '.PAGE.$tab_vues['Vue_modif']);
        } 
        else 
        {
            // On cree une personne a partir des données du formulaire
            $personne = remplir_personne(nettoyer($_POST));
            try 
            {
                //On ajoute la personne à la base de données
                $service = ServiceFactory::newService(PersonneService::class);
                $resultat = $service->create($personne);

                if ($resultat == 1) 
                {
                    $_SESSION['message'] = $tab_lang["Mess_pers_cree"];
                    unset($_SESSION['roles']);
                    unset($_SESSION['genres']);
                    header('location: '.PAGE.$tab_vues['Vue_acc']);
                } 
                else 
                {
                    $_SESSION['message'] = $tab_lang["Mess_err_cree"];
                    header('location: '.PAGE.$tab_vues['Vue_acc']);
                }
            } 
            catch (ExceptionService $e) 
            {
                $_SESSION["message"] = $tab_lang["Err_connex"];
                file_put_contents($tab_vues['logs'],$e->affiche(), FILE_APPEND);
                header('location: '.PAGE.$tab_vues['Vue_acc']);
            }
        }
        break;

    case "supprimer_personne":
        try 
        {
            // On recupere l'id de la personne que l'on souhaite supprimée de la base
            $id = $_GET["id"];

            // On supprimer la personne de la base à partir de son id
            $service = ServiceFactory::newService(PersonneService::class);
            $resultat = $service->deletebyId($id);

            if ($resultat == 1)
                $_SESSION['message'] = $tab_lang["Mess_pers_supp"];
            else
                $_SESSION['message'] = $tab_lang["Mess_err_supp"];

            // On recupere toutes les personnes de la base actualisée
            $service = ServiceFactory::newService(PersonneService::class);
            $tab = $service->findAll();

            // On actualise le tableau de personnes stockés en variable de session
            $_SESSION['personnes'] = $tab;

            // On redirige vers la page afficher_personnes.php
            header('location: '.PAGE.$tab_vues['Vue_aff']);
        } 
        catch (ExceptionService $e) 
        {
            $_SESSION["message"] = $tab_lang["Err_connex"];
            file_put_contents($tab_vues['logs'],$e->affiche(), FILE_APPEND);
            header('location: '.PAGE.$tab_vues['Vue_acc']);
        }
        break;

    case "deleteAll":
        try 
        {
            // On supprime toutes les personnes de la base
            $service = ServiceFactory::newService(PersonneService::class);
            $resultat = $service->deleteAll($_SESSION['user']->getId());

            if ($resultat == 1)
                $_SESSION['message'] = $tab_lang["Mess_pers_supp"];
            else
                $_SESSION['message'] = $tab_lang["Mess_err_supp"];

            $_SESSION['personnes'] = array();

            // On redirige vers la page afficher_personnes
            header('location: '.PAGE.$tab_vues['Vue_aff']);
        } 
        catch (ExceptionService $e) 
        {
            $_SESSION["message"] = $tab_lang["Err_connex"];
            file_put_contents($tab_vues['logs'],$e->affiche(), FILE_APPEND);
            header('location: '.PAGE.$tab_vues['Vue_acc']);
        }
        break;

    case "afficher_modifier_personne":
        try 
        {
            // On recupere l'id de la personne à modifier
            $id = $_GET["id"];

            // On recupere les donnes de la personne à modifier à partir de son id
            $service = ServiceFactory::newService(PersonneService::class);
            $personne = $service->findbyId($id);

            // On stocke les donnes de la personne dans une variable de session
            $_SESSION["modif"] = $personne;

            // On recupere les valeurs des genres et des roles
            $service = ServiceFactory::newService(GenreService::class);
            $tab = $service->findAll();
            $_SESSION['genres'] = $tab;

            $service = ServiceFactory::newService(RoleService::class);
            $tab = $service->findAll();
            $_SESSION['roles'] = $tab;

            // On redirige vers page modifier_personnes.php
            header('location: '.PAGE.$tab_vues['Vue_modif']);
        } 
        catch (ExceptionService $e) 
        {
            $_SESSION["message"] = $tab_lang["Err_connex"];
            file_put_contents($tab_vues['logs'],$e->affiche(), FILE_APPEND);
            header('location: '.PAGE.$tab_vues['Vue_acc']);
        }
        break;

    case "modifier_personne":
        try 
        {
            // On verifie que tous les champs sont biens remplis
            $message = verifier_rempli($tab_lang);

            if (!empty($message)) 
            {
                $_SESSION['message'] = $message;
                header('location: '.PAGE.$tab_vues['Vue_modif']);
            } 
            else 
            {
                // On remplit les donnes de la personne a partir des donnes du formulaire
                $personne = remplir_personne($_SESSION['modif']->getPass());
            }

            // On recupere l'id de la personne a partir du formulaire et on l'integre a ses données
            $id = $_POST["id"];
            $personne->setId($id);

            // On met a jour la personne dans la base de données
            $service = ServiceFactory::newService(PersonneService::class);
            $resultat = $service->updatebyId($personne);

            if ($resultat == 1)
                $_SESSION['message'] = $tab_lang["Mess_perso_modif"];
            else
                $_SESSION['message'] = $tab_lang["Mess_err_modif"];

            // On recupere la liste des personnes en base de données*
            if($personne->getId() == $_SESSION['user']->getId())
            {
                $service = ServiceFactory::newService(PersonneService::class);
                $_SESSION['user'] = $service->findbyId($_SESSION['user']->getId());
            }

            $service = ServiceFactory::newService(PersonneService::class);
            $_SESSION['personnes'] = $service->findAll();

            // On vide les variables de session roles et genres
            unset($_SESSION['roles']);
            unset($_SESSION["genres"]);

            // On redirige vers la page afficher_personnes.php
            header('location: '.PAGE.$tab_vues['Vue_aff']);
        } 
        catch (ExceptionService $e) 
        {
            $_SESSION["message"] = $tab_lang["Err_connex"];
            file_put_contents($tab_vues['logs'],$e->affiche(), FILE_APPEND);
            header('location: '.PAGE.$tab_vues['Vue_acc']);
        }
        break;

    case "changer_langue":
        // On change la variable de session lang quand l'utilisateur change la langue
        $_SESSION['lang'] = $_GET["lang"];
        $page = "../vue/pages/" . $_GET["page"];
        header("location: " . $page);
        break;

    case "connecter":
        try 
        {
            if(empty($_POST['g-recaptcha-response']))
            {
                $_SESSION['MESSAGE'] = "La captcha a merdé";
                header("location: ../index.php");
            }
            else
            {
                // On prépare l'URL
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LfkuIclAAAAAEX_lt-eHAkVzzbOMi9KcZXdcnjV&response={$_POST['g-recaptcha-response']}";
        
                // On vérifie si curl est installé
                if(function_exists('curl_version'))
                {
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($curl);
                }
                else
                {
                    // On utilisera file_get_contents
                    $response = file_get_contents($url);
                }
                // On vérifie qu'on a une réponse
                if(empty($response) || is_null($response))
                {
                    $_SESSION['MESSAGE'] = "La réponse est vide";
                    header("location: ../index.php");
                }
                else
                {
                    $data = json_decode($response);
                    if($data->success)
                    {

                        $service = ServiceFactory::newService(ConnectionService::class);
                        $service->updateTry(getIp());

                        $service = ServiceFactory::newService(ConnectionService::class);
                        $try = $service->verif(getIp());

                        if($try > 2)
                        {
                            $_SESSION['message'] = $tab_lang["Mess_err_try"];
                            header('location: '.PAGE.$tab_vues['Vue_identif']);
                            die();
                        }

                        // On recupere l'identifiant et le mot de passe saisis par l'utilisateur
                        $identif = nettoyer($_POST['identif']);
                        $pass = nettoyer($_POST["pass"]);

                        // On verifie qu'il existe en base un utilisateur pour lequel l'identifiant et le mot de passe correspondent
                        $service = ServiceFactory::newService(PersonneService::class);
                        $existe = $service->verify($identif, $pass);

                        if ($existe != NULL) 
                        {
                            $connect = new Connection(getIp(),$identif,1);
                            
                            $service = ServiceFactory::newService(ConnectionService::class);
                            $service->try($connect);

                            $service = ServiceFactory::newService(ConnectionService::class);
                            $service->updateEssais(getIp());

                            $_SESSION['user'] = $existe;
                            header('location: '.PAGE.$tab_vues['Vue_acc']);
                        } 
                        else 
                        {
                            $connect = new Connection(getIp(),$null,0);
                            $service = ServiceFactory::newService(ConnectionService::class);
                            $service->try($connect);
                            $_SESSION['message'] = $tab_lang['Mess_err_idmdp'];
                            $_SESSION['nb_try'] += 1;
                            header('location: '.PAGE.$tab_vues['Vue_identif']);
                        }
                    }
                    else
                    header("location: ../index.php");
                } 
            }
        }
        catch (ExceptionService $e) 
        {
            $_SESSION["message"] = $tab_lang["Err_connex"];
            file_put_contents($tab_vues['logs'],$e->affiche(), FILE_APPEND);
            header('location: '.PAGE.$tab_vues['']);
        }
        break;

    case "deconnecter":
        // On detruit la session en cours et on renvoit l'utilisateur sur la page de connection
        session_destroy();
        header("location: ../index.php");
        break;

    case "accueil":
        header('location: '.PAGE.$tab_vues['Vue_acc']);
        break;

    default:
        // Par defaut on regle la langue sur francais et on envoir l'utilisateur sur la page d'authentification
        $_SESSION['lang'] = "fr";
        if(!isset($_SESSION['nb_try']))
            $_SESSION['nb_try'] = 0;
        header('location: '.PAGE.$tab_vues['Vue_identif']);
        break;
}


function remplir_personne($pass)
{
    // On recupere les donnes du formulaires, on les nettoies et on les integres à une personne
    $prenom = nettoyer($_POST["prenom"]);
    $nom = nettoyer($_POST["nom"]);
    $mail = nettoyer($_POST["mail"]);
    $age = nettoyer($_POST["age"]);
    $identif = nettoyer($_POST['identif']);
    $genre = new Genre();
    $genre->setId(nettoyer($_POST["genre"]));
    $role = new Role();
    $role->setId(nettoyer($_POST["role"]));
    $personne = new Personne($prenom, $nom, $mail, $age, $identif, $pass);
    $personne->setGenre($genre);
    $personne->setRole($role);
    return $personne;
}


function nettoyer($var)
{
    $var = trim($var);
    $var =  stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

function verifier_rempli($tab_lang)
{
    $message = "";
    if (!isset($_POST["prenom"]) || empty($_POST["prenom"])) {
        $message = $tab_lang["Mess_manq_pre"] . PHP_EOL;
    } elseif (!isset($_POST["nom"]) || empty($_POST["nom"])) {
        $message = $tab_lang["Mess_manq_nom"] . PHP_EOL;
    } elseif (!isset($_POST["mail"]) || empty($_POST["mail"])) {
        $message = $tab_lang["Mess_manq_mail"] . PHP_EOL;
    } elseif (!isset($_POST["age"]) || empty($_POST["age"])) {
        $message = $tab_lang["Mess_manq_age"] . PHP_EOL;
    } elseif (!isset($_POST["genre"]) || empty($_POST["genre"])) {
        $message = $tab_lang["Mess_manq_genre"] . PHP_EOL;
    } elseif (!isset($_POST["role"]) || empty($_POST["role"])) {
        $message = $tab_lang["Mess_manq_role"] . PHP_EOL;
    } elseif (!isset($_POST["identif"]) || empty($_POST['identif'])) {
        $message = $tab_lang["Mess_manq_identif"];
    } elseif (!isset($_POST["pass"]) || empty($_POST['pass'])) {
        $message = $tab_lang["Mess_manq_pass"];
    }
    return $message;
}

function getIp()
{
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
