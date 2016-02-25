<?php

function menu()
{
    global $_PDO;
	
	$_query = "SELECT d_item, d_link FROM t_menu order BY d_volgorde;";

   $_result = $_PDO->query($_query);
	 $_x = 0;
	 while($_row = $_result -> fetch(PDO::FETCH_ASSOC)) 
       {
		   $_output[$_x]= $_row;
		   $_x++;
	   }
 
    return($_output);
}

?>