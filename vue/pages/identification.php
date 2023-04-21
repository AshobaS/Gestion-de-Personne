<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Connexion</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
    function onSubmit(token) 
    {
     document.getElementById("form").submit();
    }
    </script>
</head>
<input hidden id="page" value="identification">
<body>
    <?php require_once "../../Autoloader.php"; ?>
    <?php session_id('myid');?>
    <?php session_start() ?>
    <?php $langue = $_SESSION['lang']; ?>
    <?php $lang = "../lang/lang-".$langue.".php"; ?>
    <?php require_once $lang; ?>
    <h1 class="header">
        <?php echo $tab_lang["Tit_head"] ?>
        <div>
            <label class="lang" for="lang"><?php echo $tab_lang["Bout_lang"] ?>: </label>
            <select id="lang" name="lang">
                <option disabled><?php echo $tab_lang["Bout_lang"] ?></option>
                <option value="fr" <?php if($langue == "fr") echo "selected"; ?>>French</option>
                <option value="it" <?php if($langue == "it") echo "selected"; ?>>Italian</option>
                <option value="en" <?php if($langue == "en") echo "selected"; ?>>English</option>
                <option value="ru" <?php if($langue == "ru") echo "selected"; ?>>Russian</option>
            </select>
        </div>
    </h1>
    <form method="POST" action="../../controleur/Controleur.php?action=connecter" class="main" id="form">
        <h1><?php echo $tab_lang["Tit_connex"] ?></h1>
        <p>
            <label for="identif"><?php echo $tab_lang["Input_identif"] ?>:</label>
            <input type="text" required id="identif" name="identif">
        </p>
        <p>
            <label for="pass"><?php echo $tab_lang["Input_pass"] ?>:</label>
            <input type="password" required id="pass" name="pass">
        </p>
        <?php include "insert/message.php" ?>
        <p>
            <button type="submit" id="valider" class="g-recaptcha" data-sitekey="6LfkuIclAAAAAFCPupEKdtcvABnbksXjULqJZHfr" data-callback='onSubmit' data-action='submit'><img src="/site_style/img/envoyer.png" width="10" height="10" alt="Envoyer"><?php echo $tab_lang["Bout_env"] ?></button>
            <button type="reset"><img src="/site_style/img/effacer.png" width="10" height="10" alt="Effacer"><?php echo $tab_lang["Bout_eff"] ?></button>
        </p>
    </form>
    <?php include "insert/footer.php" ?>
</body>
<script src="../javascript/lang.js"></script>
</html>