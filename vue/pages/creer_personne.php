<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Index</title>
</head>
<input hidden id="page" value="creer_personne">
<body>
    <?php include "insert/header.php"; ?>
    <form method="POST" action="../../controleur/Controleur.php?action=creer_personne" class="main">
        <h1><?php echo $tab_lang["Tit_ajt"] ?></h1>
        <p>
            <label for="prenom"><?php echo $tab_lang["Input_pre"] ?>:</label>
            <input type="text" id="prenom" name="prenom" required>
        </p>
        <p>
            <label for="nom"><?php echo $tab_lang["Input_nom"] ?>:</label>
            <input type="text" id="nom" name="nom" required>
        </p>
        <p>
            <label for="mail"><?php echo $tab_lang["Input_mail"] ?>:</label>
            <input type="mail" id="mail" name="mail" required>
        </p>
        <p>
            <label for="age"><?php echo $tab_lang["Input_age"] ?>:</label>
            <input type="number" id="age" name="age" required>
        </p>
        <p>
            <label for="genre"><?php echo $tab_lang["Input_genre"] ?>:</label>
            <select id="genre" name="genre">
                <option value="" disabled selected><?php echo $tab_lang["Input_genre"] ?></option>
                <?php $tab = $_SESSION['genres']; ?>
                <?php foreach ($tab as $genre) { ?>
                    <option value="<?php echo $genre->getId(); ?>"><?php $genre->afficher($tab_lang); ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="role"><?php echo $tab_lang["Input_role"] ?>:</label>
            <select id="role" name="role">
                <option value="" disabled selected><?php echo $tab_lang["Input_role"] ?></option>
                <?php $tab = $_SESSION['roles']; ?>
                <?php foreach ($tab as $role) { ?>
                    <option value="<?php echo $role->getId(); ?>"><?php $role->afficher($tab_lang); ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="identif"><?php echo $tab_lang["Input_identif"] ?>:</label>
            <input type="text" required id="identif" name="identif">
        </p>
        <p>
            <label for="pass"><?php echo $tab_lang["Input_pass"] ?>:</label>
            <input type="password" required id="pass" name="pass">
        </p>
        <?php include "insert/message.php" ?>
            <button type="submit" id="valider"><img src="../img/envoyer.png" width="10" height="10" alt="Envoyer"><?php echo $tab_lang["Bout_env"] ?></button>
            <button type="reset"><img src="../img/effacer.png" width="10" height="10" alt="Effacer"><?php echo $tab_lang["Bout_eff"] ?></button>
            <a href="../../controleur/Controleur.php?action=accueil"><?php echo $tab_lang["Link_acc"] ?></a>
    </form>
    <?php include "insert/footer.php" ?>
</body>
</html>