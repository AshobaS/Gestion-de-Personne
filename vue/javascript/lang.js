window.addEventListener("load",setupListener)


function setupListener()
{
    var lang = document.getElementById("lang");
    lang.addEventListener("change",changelang);
}


function changelang()
{
    var lang = document.getElementById("lang").value;
    var page = document.getElementById("page").value;
    window.location.href="../../controleur/Controleur.php?action=changer_langue&lang="+lang+"&page="+page;
}
