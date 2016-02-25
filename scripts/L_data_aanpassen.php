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
//functie om gemeentenaam en/of postcode om te zetten naar key
include("../php_lib/gemeente.inc.php");
// exception handling funtions
include("../php_lib/myExceptionFunctions.inc.php");

// initialisatie van variablelen

$_inhoud ="";


try{


	/*******************************************
*    formulier behandeling
********************************************/

	/************ >>>>>> opgepast <<<<<< ************/
	// 2 soorten formulieren
	// indien geen formulier --> error

	if (! isset($_POST["submit"]) && ! isset($_POST["aanpassen"]))  // geen enkel formulier formulier
	{
		throw new Exception("illegal access");
	}

	if (isset($_POST["submit"])) // bevestigings formulier
	{
		//verwerk inhoud van het formulier
		// copieer de inhoud van $_POST[lidnr'] (super global) naar lokale parameter	$_lidnr
		$_lidnr = $_POST['lidnr'];

		// maak select query
		//d_lidnr = '$_lidnr'
		$_result = $_PDO -> query("Select * FROM v_leden WHERE d_lidnr = '$_lidnr'");
		// verwerk resultaat
		if ($_result -> rowCount() == 0) // geen resultaat is db inconsistency
		{
			throw new Exception("database inconsistency");
		}
		// hier gaan komen we enkel indien er geen 'db inconsistency'  was

		while ($_row = $_result -> fetch(PDO::FETCH_ASSOC))
		{
			//maak voor het geselecteerde lid een formulier en vul de velden inmet de huidige waarden
			// voorzie een 'hidden formfield' met de key
			$_inhoud= "<h1>Aanpassen</h1>
<form  method='post' action='$_srv'>
<input type ='hidden' name ='lidnr' value ='".$_row['d_lidnr']."'>
		<label>Naam</label>
		<input type='text' name='naam' value ='".$_row['d_naam']."'>
		<label >Voornaam</label>
		<input type='text' name='voornaam'value ='".$_row['d_voornaam']."'>
		<label >Straat</label>
		<input type='text' name='straat' size='20' value ='".$_row['d_straat']."'>
		<label >Nr & Extra</label>
		<input type='text' name='nr' size='10' value ='".$_row['d_nr']."'>
		<input type='text' name='xtr' size='10' value ='".$_row['d_Xtr']."'>
		<label >Postcode</label>
		<input type='text' name='postcode' size='10' value ='".$_row['d_Postnummer']."'>
		<label >Gemeente</label>
		<input type='text' name='gemnaam'size='20' value ='".$_row['d_GemeenteNaam']."'>
		<label >Telefoon</label>
		<input type='text' name='tel' size='15' value ='".$_row['d_tel']."'>
		<label >Mobiel</label>
		<input type='text' name='mob' size='15' value ='".$_row['d_mob']."'>
		 <label >E-mail</label>
		<input type='text' name='mail' size='80' value ='".$_row['d_mail']."'>
		<input id = 'submit' name='aanpassen' type='submit' value='verzenden'>
</form>";
		}
	}
	else // formulier met aangepaste data
	{

		// verwerk inhoud van het formulier
		// copieer de inhoud van $_POST (super global) naar lokale parameters
		$_lidnr = $_POST["lidnr"];
		$_naam = $_POST["naam"];
		$_voornaam = $_POST["voornaam"];
		$_straat = $_POST["straat"];
		$_nr = $_POST["nr"];
		$_xtr = $_POST["xtr"];
		$_telefoon = $_POST["tel"];
		$_gemeenteNaam = $_POST["gemnaam"];
		$_postcode = $_POST["postcode"];
		$_gemeente = gemeente_nummer($_postcode, $_gemeenteNaam);
		$_mob = $_POST["mob"];
		$_mail = $_POST["mail"];

		// Maak met de ingevoerde waarden de bijhorende update query.
		// we updaten alle velden
		$_result = $_PDO -> query("UPDATE t_leden
								SET d_naam = '$_naam',
										d_voornaam = '$_voornaam',
										d_straat = '$_straat',
										d_nr = '$_nr',
										d_Xtr = '$_xtr',
										d_gemeente = '$_gemeente',
										d_tel = '$_telefoon',
										d_mob = '$_mob',
										d_mail = '$_mail'
								WHERE d_lidnr = '$_lidnr';");
		//gegevens van het lid zij aangepast

		$_inhoud = "<br><br><br><br><br><br><h2>de gegevens voor&nbsp;&nbsp;$_voornaam&nbsp;&nbsp;$_naam zijn aangepast</h2>";

		/************ >>>>>> opgepast <<<<<< ************/
		//href=../scripts/L_aanpassen.php>
		//hiermee gaan we terug naar ons 1ste script
		$_inhoud .="<br><a href=../scripts/L_aanpassen.php>volgende</a>";

	}


	/*********************************************
*    output
**********************************************/

	// Object instantieren
	$_smarty = new mySmarty();

	// We kennen de variabelen toe
	$_smarty->assign('menu', menu());
	$_smarty->assign('inhoud', $_inhoud);
	// display it
	$_smarty->display('ledenadmin.tpl');

}

catch (Exception $_e) // exception handling
{

	echo exceptionTestMessage($_e);
}





?>
