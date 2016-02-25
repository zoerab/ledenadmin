<?php
class mySmarty  extends Smarty
 {
    Public function __construct()
    {
       //Call parent constructor
	   parent::__construct();
	   //initialisatie
       $this->template_dir = '../templates/';
       $this->compile_dir = '../templates_c/';
       $this->config_dir = '../configs/';
       $this->cache_dir = '../cache/';
   }
}
?>
