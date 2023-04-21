<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Accueil</title>
</head>

<!-- Champ caché contenant le nom de la page, utilisé dans le script JavaScript -->
<input hidden id="page" value="accueil">

<body>
    <!-- Inclusion du fichier d'en-tête de la page -->
    <?php include "insert/header.php"; ?>

    <?php $personne = $_SESSION['user']; ?>
    
    <!-- Formulaire principal qui affiche du texte et des liens -->
    <form action="" class="main">
        <!-- Titre principal de la page -->
        <h1><strong><?php echo $tab_lang["Tit_acc"] ?></strong></h1>
        
        <!-- Lien pour afficher la liste des personnes -->
        <p>
            <a href="../../controleur/Controleur.php?action=afficher_liste_personne"><?php echo $tab_lang["Link_aff"] ?></a>
        </p>
        
        <?php if($personne->isAdmin() == 1){ ?>
            <!-- Lien pour ajouter une nouvelle personne -->
            <p>
                <a href="../../controleur/Controleur.php?action=afficher_creer_personne"><?php echo $tab_lang["Link_ajt"] ?></a>
            </p>
        <?php } ?>
        <?php include "insert/message.php" ?>
        <!-- Affichage d'un message de session s'il existe -->
    </form>
    
    <!-- Inclusion du fichier de pied de page de la page -->
    <?php include "insert/footer.php" ?>
</body>
</html>
