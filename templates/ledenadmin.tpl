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
		     {section name=teller loop=$menu}
          <li><a href="{$menu[teller].d_link}">{$menu[teller].d_item}
            	</a>
          </li>
     {/section}
		</ul> 
	</nav>
  
	<section>
		<article id="artleft">
			{$commentaar|default:"<h1>Herhalings-oefening</h1>"}
			
		</article>
		<article id="artright">
			{$inhoud}
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
