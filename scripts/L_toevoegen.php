<?php
/******************
*Initialisatie
*******************/

//$_srv gebruiken we als "action" in onze formulieren
$_srv = $_SERVER['PHP_SELF'];

/******************
* autoload  --> zorgt er voor dat alle gebruikte klassen ingelezen worden
******************/
function __autoload($className)
{
    require_once "../klassen/$className.class.php";
}

/******************
* includes
******************/
// instantiering van $_PDO (connectie met dbms en selectie van de datbase)
include '../connections/pdo.inc.php';
// functie om text (html) files in te lezen
include '../php_lib/inlezen.inc.php';
//functie om "menu" samen te stellen
include '../php_lib/menu.inc.php';
//functie om selection query samen te stellen
include '../php_lib/createSelect.inc.php';
//functie om gemeentenaam en/of postcode om te zetten naar key
include '../php_lib/gemeente.inc.php';
//functie om gender dropdown lijst te genereren
include("../php_lib/dropDown.inc.php");
// exception handling funtions
include '../php_lib/myExceptionFunctions.inc.php';

// initialisatie van variablelen

$_inhoud = '';

try {

/*******************************************
*    formulier behandeling
********************************************/

    if (!isset($_POST['submit'])) {
        // geen formulier

    // toon formulier
        $_inhoud = "<h1>Toevoegen</h1>
        <form  method='post' action='$_srv'>
        <label>Naam</label>
        <input type='text' name='naam'>
        <label>Voornaam</label>
        <input type='text' name='voornaam'>
        <label >Gender</label>"
        .
        dropDown("gender","t_gender","d_index","d_mnemonic")
        .
        "<label>Soort</label>"
        .
        dropDown("soort","t_soort_lid","d_index","d_mnemonic")
        .
        "<label >Straat</label>
        <input type='text' name='straat' size='20'>
        <label>Nr + Extra</label>
        <input type='text' name='nr' size='10'>
        <input type='text' name='xtr' size='10'>
        <label>Postcode</label>
        <input type='text' name='postcode' size='10'>
        <label>Gemeente</label>
        <input type='text' name='gemnaam'size='50'>
        <label >Telefoon</label>
        <input type='text' name='tel' size='15'>
        <label >Mobiel</label>
        <input type='text' name='mob' size='15'>
        <label for='tel'>E-mail</label>
        <input type='text' name='mail' size='20'>
        <input id ='submit' name='submit' type='submit' value='verzenden'>
</form>";
    } else {
        // verwerk inhoud van het formulier
// copieer de inhoud van $_POST (super global) naar lokale parameters
        $_naam = $_POST['naam'];
        $_voornaam = $_POST['voornaam'];
        $_gender = $_POST["gender"];
        $_soort = $_POST["soort"];
        $_straat = $_POST['straat'];
        $_nr = $_POST['nr'];
        $_xtr = $_POST['xtr'];
        $_telefoon = $_POST['tel'];
        $_gemeenteNaam = $_POST['gemnaam'];
        $_postcode = $_POST['postcode'];

        // postcode en/of gemeentenaam omzetten naar key

        $_gemeente = gemeente_nummer($_postcode, $_gemeenteNaam);
        $_mob = $_POST['mob'];
        $_mail = $_POST['mail'];

/*******************************************
*    consistency checks
********************************************/
// nakijken of "nieuw lid" al bestaat
// hiervoor gebruiken we de functie createSelect
// Parameter 1 --> de bijhorende tabel/view
// Parameter 2 --> de lijst van ingevoerde waarden (array)
// Parameter 3 --> de lijst van bijhorende velden in de tabel/view (array)

        $_query = createSelect('v_leden',
        array($_naam, $_voornaam,$_gender, $_soort, $_straat, $_nr, $_xtr, $_postcode, $_gemeenteNaam, $_telefoon, $_mob, $_mail, ),
        array('d_naam', 'd_voornaam','d_gender','d_soortlid', 'd_straat', 'd_nr', 'd_xtr', 'd_Postnummer', 'd_GemeenteNaam', 'd_tel', 'd_mob', 'd_mail'));

// verstuur de query naar het dbms
        $_result = $_PDO->query("$_query");

// verwerk de resultaten van de query
        if ($_result->rowCount() > 0) {
            // lid bestaat reeds

// meld dat lid reeds bestaat
         $_inhoud = '<br><br><h2> Lid is al ingevoerd!</h2>';
        } else {
            // lid bestaat nog niet

// maak insert query
// tabel --> t_leden
// primary key wordt niet megegeven vermits we voor de tabel "auto increment (ai)" geactiveerd hebben
             $_result = $_PDO->query("INSERT INTO t_leden (d_naam, d_voornaam, d_gender, d_soort, d_straat, d_nr, d_xtr, d_gemeente, d_tel, d_mob,  d_mail) VALUES
                                                          ('$_naam', '$_voornaam','$_gender','$_soort','$_straat', '$_nr', '$_xtr', '$_gemeente', '$_telefoon','$_mob','$_mail');");

//nieuw lid is toegevoegd
         $_inhoud = "<br><br><br><br><br><br><h2>Lid &nbsp;&nbsp;$_voornaam &nbsp;&nbsp;$_naam&nbsp;&nbsp;is toegevoegd</h2>";
        }

        $_inhoud .= "<br><a href='$_srv'>volgende</a>";
    }

/**********************************************
*    output
**********************************************/

     // Object instantieren
    $_smarty = new mySmarty();

// We kennen de variabelen toe
    $_smarty->assign('menu', menu());
    $_smarty->assign('commentaar', inlezen('L_toevoegen.txt'));
    $_smarty->assign('inhoud', $_inhoud);
// display it
    $_smarty->display('ledenadmin.tpl');
} catch (Exception $_e) {// exception handling
     echo exceptionTestMessage($_e);
}
