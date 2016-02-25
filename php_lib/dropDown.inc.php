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
 * Deze functie maakt een HTML drop-down vanuit een gegeven tabel
 * @param  [string] $_name         ["name" van de html drop-down]
 * @param  [string] $_table        [naam van de tabel]
 * @param  [int]    $_number       [data-veld waar de numerieke waarde instaat
 *                                  gewoonlijk de primary key van de tabel]
 * @param  [string] $_mnemonic     [data-veld waar de textuele waarde instaat ]
 * @param  [int]    [$_start = 0]  [numerieke startwaarde van de drop-down
 *                                  niet verplichte parameter, "0" indien niet opgegeven]
 * @param  [int]    [$_select = 0] [numerieke waarde van de in de drop-down getoonde tekst
 *                                  niet verplichte parameter, "0" indien niet opgegeven]
 * @return [string]                [HTML drop-down]
 */

function dropDown($_name, $_table, $_number, $_mnemonic, $_start = 0, $_select = 0)
{
  global $_PDO;

  $_output = "<select name='$_name' id= '$_name'>\n";

  $_result = $_PDO -> query("SELECT $_number, $_mnemonic  FROM $_table");

	if ($_result -> rowCount() == 0)
  {
		throw new PDOException("$_table --> geen records");
  }

  while ($_row = $_result -> fetch(PDO::FETCH_ASSOC))
  {
  	if($_row[$_number] >= $_start)
		{
			$_output.="<option value='".$_row[$_number]."'";
      if ($_row[$_number] == $_select)
      {
        $_output.=" selected ";
      }
      $_output.=">".$_row[$_mnemonic]."</option>\n";
    }
  }

  $_output.="</select>\n";

  return $_output;

}

?>
