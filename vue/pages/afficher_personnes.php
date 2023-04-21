<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="../styles/style.css">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnes</title>
</head>

<!-- Champ caché contenant le nom de la page, utilisé dans le script JavaScript -->
<input hidden id="page" value="afficher_personnes">

<body>
    <!-- Inclusion du fichier header -->
    <?php include "insert/header.php"; ?>

    <?php $user = $_SESSION['user']; ?>

    <div class="main">
        <form>
            <legend>
                <h3><?php echo $tab_lang["Tit_list"] ?></h3>
            </legend>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th><?php echo $tab_lang["Input_pre"] ?></th>
                        <th><?php echo $tab_lang["Input_nom"] ?></th>
                        <th><?php echo $tab_lang["Input_mail"] ?></th>
                        <th><?php echo $tab_lang["Input_age"] ?></th>
                        <th><?php echo $tab_lang["Input_genre"] ?></th>
                        <th><?php echo $tab_lang["Input_role"] ?></th>
                        <th><?php echo $tab_lang["Input_identif"] ?></th>
                        <?php if($user->isAdmin() == 1) { ?>
                        <th><?php echo $tab_lang["Bout_supp"] ?></th>
                        <th><?php echo $tab_lang["Bout_modif"] ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- Boucle de remplissage du tableau -->
                    <?php $tab = $_SESSION['personnes'] ?>
                    <?php foreach ($tab as $personne) { ?>
                        <tr>
                            <td><?php echo $personne->getId(); ?></td>
                            <td><?php echo $personne->getPrenom(); ?> </td>
                            <td><?php echo $personne->getNom(); ?> </td>
                            <td><?php echo $personne->getMail(); ?> </td>
                            <td><?php echo $personne->getAge(); ?> </td>
                            <td><?php echo $personne->getGenre()->afficher($tab_lang); ?> </td>
                            <td><?php echo $personne->getRole()->afficher($tab_lang); ?> </td>
                            <td><?php echo $personne->getIdentif(); ?> </td>
                            <?php if($user->isAdmin() == 1){ ?>
                            <?php if($user->getId() != $personne->getId()){ ?>
                            <td><a onclick="return confirm('<?php echo $tab_lang['Confirm_supp'] ?>')" href="../../controleur/Controleur.php?action=supprimer_personne&id=<?php echo $personne->getId(); ?>"><?php echo $tab_lang["Bout_supp"] ?></a></td>
                            <?php } else {?>
                            <td></td>
                            <?php } ?>
                            <td><a onclick="return confirm('<?php echo $tab_lang['Confirm_modif'] ?>')" href="../../controleur/Controleur.php?action=afficher_modifier_personne&id=<?php echo $personne->getId(); ?>"><?php echo $tab_lang["Bout_modif"] ?></a></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Affiche un message si quelque chose s'est mal passé -->
            <?php include "insert/message.php" ?>
            <a onclick="return confirm('<?php echo $tab_lang['Confirm_suppall'] ?>')" href="../../controleur/Controleur.php?action=deleteAll"><?php echo $tab_lang["Link_suppall"] ?></a>
            <a href="../../controleur/Controleur.php?action=accueil"><?php echo $tab_lang["Link_acc"] ?></a>
        </form>
    </div>
    <!-- Inclusion du footer -->
    <?php include "insert/footer.php" ?>
</body>
</html>