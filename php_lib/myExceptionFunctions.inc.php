<?php
/*
The MIT License (MIT)

Copyright (c) Wed Dec 30 2015 Micky De Pauw

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORTOR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

/**
 * Deze functie behoort tot de "myExceptionFunctions" include en zal wanneer
 * opgeroepen vanuit de "catch" clausule van de exception handling de tijd,
 * de beschrijving van de exception, de script naam en de lijn waarop de throw
 * gebeurde wegschrijven in de aangeleverde log-file (csv)
 * @param [object] $_exception [exception object]
 * @param [string] $_logfile   [exception/error log file (csv) en
 *                              folder (relatief t.o.v de "oproeper)]
 */

function exceptionLog($_exception,$_logfile)
    {
     $_error_log[1] = strftime("%d-%m-%Y %H:%M:%S");
     $_error_log[2] = $_exception->getMessage();
     $_error_log[3] = $_exception->getFile();
     $_error_log[4] = $_exception->getLine();

    $_pointer = fopen("$_logfile","ab");
        fputcsv($_pointer,$_error_log);
        fclose($_pointer);
    }

/**************************************************************************/
/**************************************************************************/



/**
 * Deze functie behoort tot de "myExceptionFunctions" include en zal wanneer
 * opgeroepen vanuit de "catch" clausule van de exception handling;
 * de beschrijving van de exception, de script naam en de lijn waarop de throw gebeurde returnen
 * @param [object] $_exception [exception object]
 * @return [string] [exception informatie]
 *
 *                  <<<<<< OPGELET >>>>>>
 * Deze functie enkel gebruiken gedurende de testfase van een project
 */
function exceptionTestMessage($_exception)
      {
       //error message
       $_testMsg = "<b>Foutmelding</b><br />Foutmelding: ".$_exception->getMessage()."<br />Bestand: ".$_exception->getFile()."<br />Regel: ".$_exception->getLine()."<br />";
       return $_testMsg;
    }

/**************************************************************************/
/**************************************************************************/



/**
 * Deze functie behoort tot de "myExceptionFunctions" include en zal wanneer
 * opgeroepen vanuit de "catch" clausule van de exception handling;
 * de beschrijving van de exception returnen
 * @param [object] $_exception [exception object]
 * @return [string] [exception informatie]
 */

function exceptionUserMessage($_exception)
      {
       //user message
       $_userMsg = "<h2>De volgende fout is opgetreden \"".$_exception->getMessage()."\". </br>Hierdoor hebben we het script moeten onderbreken, gelieve ons hiervoor te verontschuldigen.</br> Indien deze fout zich blijft voordoen, neemt U best contact op met de webmaster.</h2>";
       return $_userMsg;
    }

?>
