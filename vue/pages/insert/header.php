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
    <div></div>
    <div class="deco">
        <?php echo $_SESSION['user']->getPrenom() ?>
        <?php echo $_SESSION['user']->getNom() ?>
    <a onclick="return confirm('<?php echo $tab_lang['Confirm_deco'] ?>')" href="../../controleur/Controleur.php?action=deconnecter"><?php echo $tab_lang["Link_deco"] ?></a>
    </div>
</h1>
<script src="../javascript/lang.js"></script>