<?php /* Smarty version 2.6.26, created on 2014-01-27 20:27:30
         compiled from ledenadmin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'ledenadmin.tpl', 29, false),)), $this); ?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link href="../css/oefeningen.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js_lib/copyright.js"></script>

<title>Templates oefeningen</title>
</head>

<body>
<div id="mainbox">
	<header>
		<img src="../images/webontwikkeling.jpeg"  height="100%" alt="webontwikkeling"/>
		<p>Web-ontwikkeling</p>
	</header>
	<nav>
		<ul>
		     <?php unset($this->_sections['teller']);
$this->_sections['teller']['name'] = 'teller';
$this->_sections['teller']['loop'] = is_array($_loop=$this->_tpl_vars['menu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['teller']['show'] = true;
$this->_sections['teller']['max'] = $this->_sections['teller']['loop'];
$this->_sections['teller']['step'] = 1;
$this->_sections['teller']['start'] = $this->_sections['teller']['step'] > 0 ? 0 : $this->_sections['teller']['loop']-1;
if ($this->_sections['teller']['show']) {
    $this->_sections['teller']['total'] = $this->_sections['teller']['loop'];
    if ($this->_sections['teller']['total'] == 0)
        $this->_sections['teller']['show'] = false;
} else
    $this->_sections['teller']['total'] = 0;
if ($this->_sections['teller']['show']):

            for ($this->_sections['teller']['index'] = $this->_sections['teller']['start'], $this->_sections['teller']['iteration'] = 1;
                 $this->_sections['teller']['iteration'] <= $this->_sections['teller']['total'];
                 $this->_sections['teller']['index'] += $this->_sections['teller']['step'], $this->_sections['teller']['iteration']++):
$this->_sections['teller']['rownum'] = $this->_sections['teller']['iteration'];
$this->_sections['teller']['index_prev'] = $this->_sections['teller']['index'] - $this->_sections['teller']['step'];
$this->_sections['teller']['index_next'] = $this->_sections['teller']['index'] + $this->_sections['teller']['step'];
$this->_sections['teller']['first']      = ($this->_sections['teller']['iteration'] == 1);
$this->_sections['teller']['last']       = ($this->_sections['teller']['iteration'] == $this->_sections['teller']['total']);
?>
          <li><a href="<?php echo $this->_tpl_vars['menu'][$this->_sections['teller']['index']]['d_link']; ?>
"><?php echo $this->_tpl_vars['menu'][$this->_sections['teller']['index']]['d_item']; ?>

            	</a>
          </li>
     <?php endfor; endif; ?>
		</ul> 
	</nav>
  
	<section>
		<article id="artleft">
			<?php echo ((is_array($_tmp=@$this->_tpl_vars['commentaar'])) ? $this->_run_mod_handler('default', true, $_tmp, "<h1>Herhalings-oefening</h1>") : smarty_modifier_default($_tmp, "<h1>Herhalings-oefening</h1>")); ?>

			
		</article>
		<article id="artright">
			<?php echo $this->_tpl_vars['inhoud']; ?>

		</article>
	</section>
  
	<footer>
		<script language="javascript">
			document.write(copyRight("webontwikkeling.info"));
		</script>
	</footer>
  
</div>

</body>
</html>