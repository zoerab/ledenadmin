<?php

/******************
*Initialisatie
*******************/

//$_srv gebruiken we als "action" in onze formulieren
$_srv = $_SERVER['PHP_SELF'];

/******************
* autoload  --> zorgt er voor dat alle gebruikte klassen ingelezen worden
******************/
function __autoload($className) {
    require_once "../klassen/$className.class.php";
}

/******************
* includes
******************/
// instantiering van $_PDO (connectie met dbms en selectie van de datbase)
include("../connections/pdo.inc.php");
// functie om text (html) files in te lezen
include("../php_lib/inlezen.inc.php");
//functie om "menu" samen te stellen
include("../php_lib/menu.inc.php");
//functie om selection query samen te stellen
include("../php_lib/createSelect.inc.php");
// exception handling funtions
include("../php_lib/myExceptionFunctions.inc.php"); 

// initialisatie van variablelen

$_inhoud ="";



try{

/*******************************************
*    formulier behandeling
********************************************/

	if (! isset($_POST["submit"]))  // geen formulier
	{
	// toon formulier
		$_inhoud= "<h1>Lezen</h1>
  <form  method='post' action='$_srv'>
    <label>Naam</label>
    <input type='text' name='naam'>
    <label >Voornaam</label>
    <input type='text' name='voornaam'>
    <label >Straat</label>
    <input type='text' name='straat' size='20'>
    <label >Nr + Extra</label>
    <input type='text' name='nr' size='10'>
    <input type='text' name='xtr' size='10'>
    <label >Postcode</label>
    <input type='text' name='postcode' size='10'>
    <label >Gemeente</label>
    <input type='text' name='gemnaam'size='20'>
    <label>Telefoon</label>
    <input type='text' name='tel' size='10'>
    <label >Mobiel</label>
    <input type='text' name='mob' size='10'>
 	  <label>E-mail</label>
    <input type='text' name='mail' size='40'>
		<input  name='submit' type='submit' value='verzenden'>
  </form>";

	}

	else
	{
// verwerk inhoud van het formulier
// copieer de inhoud van $_POST (super global) naar lokale parameters
		$_naam =$_POST["naam"];
		$_voornaam = $_POST["voornaam"];
		$_straat = $_POST["straat"];
		$_nr = $_POST["nr"];
		$_xtr = $_POST["xtr"];
		$_telefoon = $_POST["tel"];
		$_gemeenteNaam = $_POST["gemnaam"];
		$_postcode = $_POST["postcode"];
		$_mob = $_POST["mob"];
		$_mail = $_POST["mail"];



// Maak met de ingevoerde waarden de bijhorende query.
// hiervoor gebruiken we de functie createSelect
// Parameter 1 --> de bijhorende tabel/view
// Parameter 2 --> de lijst van ingevoerde waarden (array)
// Parameter 3 --> de lijst van bijhorende velden in de tabel/view (array)

		$_query = createSelect("v_leden",
		array($_naam, $_voornaam, $_straat, $_nr, $_xtr, $_postcode, $_gemeenteNaam, $_telefoon, $_mob,  $_mail),
		array('d_naam', 'd_voornaam', 'd_straat','d_nr','d_xtr','d_Postnummer', 'd_GemeenteNaam', 'd_tel','d_mob', 'd_mail'));

// verstuur de query naar het dbms
		$_result = $_PDO -> query("$_query");

// verwerk de resultaten van de query
		if ($_result -> rowCount() > 0) // er zijn resultaten gevonden
		{

// verwerk elk resultaat afzonderlijk
			while ($_row = $_result -> fetch(PDO::FETCH_ASSOC))
			{
				$_inhoud.= $_row['d_voornaam']." ".$_row['d_naam']."<br><br>";
				$_inhoud.= $_row['d_straat']."&nbsp;&nbsp;".$_row['d_nr']."&nbsp;&nbsp;".$_row['d_Xtr']."<br>";
				$_inhoud.= $_row['d_Postnummer']."&nbsp;&nbsp;".$_row['d_GemeenteNaam']."<br><br>";
				$_inhoud.= "Tel : ".$_row['d_tel']."<br>";
				$_inhoud.= "Mob : ".$_row['d_mob']."<br><br>";
				$_inhoud.= $_row['d_mail']."<br><hr><br>";
     				}
   			}
   			else // er zijn geen resultaten gevonden
   			{
	   			$_inhoud = "<br><br><br><br><br><br><h2>Geen records gevonden voor deze input</h2>";
   			}


				$_inhoud .="<br><a href='$_srv'>volgende</a>";

	}


/*********************************************
*   output
**********************************************/

// Object instantieren
	$_smarty = new mySmarty();

// We kennen de variabelen toe
	$_smarty->assign('menu', menu());
	$_smarty->assign('commentaar',inlezen("L_lezen.txt"));
	$_smarty->assign('inhoud', $_inhoud);
// display it
	$_smarty->display('ledenadmin.tpl');

}

catch (Exception $_e) // exception handling
{
  echo exceptionTestMessage($_e);
}


?>
