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
// exception handling funtions
include("../php_lib/myExceptionFuntions.inc.php"); 


try
{
 // welkom.txt zal in het "inhoud" veld  op het scherm komen
	$_inhoud = inlezen('welkom.txt');

// Object instantieren
	$_smarty = new mySmarty();

// We kennen de variabelen toe

	$_smarty->assign('menu',menu());
	$_smarty->assign('inhoud', $_inhoud);
// display it
	$_smarty->display('ledenadmin.tpl');

}
 
catch (Exception $_e) // exception handling
{
  echo exceptionTestMessage($_e);
}


?>