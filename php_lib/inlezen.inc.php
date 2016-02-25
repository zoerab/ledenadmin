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
 * Deze functie leest een bepaald bestand
 * @param  [string] $_bestand [bestand, inclusief folder relatief t.o.v. de "caller"]
 * @return [string] [inhoud van het bestand]
 */

function Inlezen($_bestand)
{
  $_pointer = fopen("../content/$_bestand", 'rb');
  $_return_waarde = fread($_pointer, 10000);
  fclose($_pointer);

  return ($_return_waarde);
}
?>
