<?php
date_default_timezone_set('America/Sao_Paulo');
$datatime = date("d/m/Y H:i:s");
$raiz = "/site_etec/";
include_once("cnf/config.php");
include_once("desbugae.php");

include_once("php/tratavalor.php");
include_once("class/all_pagina.php");
include_once("class/all_categoria.php");
include_once("php/link_integra.php");
include_once("class/all_noticias.php");
include_once("class/wow_slide.php");
if(isset($_SESSION['etec_login']) && isset($_SESSION['etec_pass'])){
include_once("class/dados_usuario.php");
}
ob_start();

if(!isset($connnect))
	$connnect = Conexao::getInstance();
?>
<html>
	<head>
		<title>ETEC - RODRIGUES DE ABREU</title>
		<meta charset="utf-8">
		<script type="text/javascript" src="<?php echo $past; ?>js/jquery-1.9.1.js"></script>
		<link rel="shortcut icon" href="<?php echo $past; ?>images/bauru.ico">
		<meta name="viewport" content="width=device-width">
		<link href="<?php echo $past; ?>css/folha_estilo.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="<?php echo $past; ?>css/mobile.css" media="(max-width: 320px)">
		<link href='<?php echo $past; ?>fonts/cinzel.css' rel='stylesheet' type='text/css'>
		<script>
			
			function redirect(id){
				location.href='#';
			}
			
		</script>
	</head>
	
	<body>
		<div id="suprema">
		
		<div id="sup">
			<div style="margin:15px;cursor:pointer;float:left;">
				<img src="<?php echo $past; ?>images/logo2.png" onclick="location.href='index.php'" height="80px"/>
			</div>
			
				<form class="search" method="get" action="index.php">
					<fieldset id="fieldSearch">
						<input style="" name="advancedsearch" class="inputsS" placeholder="Pesquisar" type="text"/>
						<input type="submit" class="testimg" value="ok"/>
					</fieldset>
				</form>
			<!--<p class="fonte" style="margin:0px;padding:1px;text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ETEC - RODRIGUES DE ABREU - CENTRO PAULA SOUZA</p>-->
		</div><br />
		
		
			<div id="quaseutil">
				
					<!--<div id="cabecario">
						<nav id="i"></nav>
						<nav id="ii"></nav>
					</div>-->
					
					
					<div id="menu">
						<ul>
							<li><a href="<?php echo $raiz; ?>index.php">Home</a></li>
							<li><a href="<?php echo $raiz; ?>privado">Privado</a></li>
							<?php
								lista_pagina("principal",$raiz);
							?>
		
						</ul>
					</div>
					<?php
						include_once("slide.html");
					?><br />
					<div id="conteudo">
						
						<div id="menu_left">
							<nav><p class="fonte" style="text-align:center;">Autenticação</p></nav>
							<div>
							<?php include_once("php/bpainel.php"); ?>
							
							
							</div>
							<br />
							<?php
								$todas_categoria = $connnect->query("SELECT DISTINCT c.ca_codigo,c.ca_titulo FROM etec_categoria c JOIN etec_integra i ON c.ca_codigo = i.in_categoria WHERE i.in_data_on <= NOW() AND i.in_data_off > NOW() ORDER BY ca_titulo ASC LIMIT 0,5");
								
								while($obj_categorias = $todas_categoria->fetch(PDO::FETCH_OBJ)){
									echo "<nav><p class='fonte' style='text-align:center;' onclick='redirect({$obj_categorias->ca_codigo})'>{$obj_categorias->ca_titulo}</p></nav>";
									echo "<div>
										<ul style='margin:0px;'>";
										link_integra_on($obj_categorias->ca_codigo,$raiz);
									echo "
										</ul>
										</div><br />
									";
								}
							?>
						
						</div>
						
						<div id="conteudo2">
						<div style="margin:15px;">
							<?php
							if(isset($_GET['advancedsearch'])){
								include_once("php/advancedSearch.php");
							}
							
							if(isset($_GET['pagina']) && strlen($_GET['pagina']) > 0){
								$ppag = trataValor($_GET['pagina']);						
								$page = explode("/",$ppag);
								$ppagi = explode(".",$page[0]);
								if(file_exists("conteudo/{$ppagi[0]}.php")){
									include_once("conteudo/{$ppagi[0]}.php");
								}
								else		
									include_once("php/errorpag.php");
							}else		
								include_once("conteudo/home.php");
							?>
						</div>
						</div>
					</div>
					
			</div>
			
			<div id="rodape" style="display:table;width:100%;">
				<div style="float:left;margin:5px;padding:0px;display:table;">
					<p style="text-align:left;font-family: 'Cinzel', serif;color:#FFF;margin:0px;float:left;">
					Rua Virgílio Malta 12-70
					<br />Telefone (14) 3234-4252
					</p>
					<img style="margin:6px;cursor:pointer;" onclick="location.href='http://www.saopaulo.sp.gov.br/'" src="<?php echo $past; ?>images/splog.gif"/>
					<img style="margin:6px;cursor:pointer;" onclick="location.href='http://www.centropaulasouza.sp.gov.br/'" width="200" src="<?php echo $past; ?>images/CPS.png"/>
				</div>
				<div style="float:right;margin:5px;padding:0px;">
					<p style="text-align:right;font-family: 'Cinzel', serif;color:#FFF;margin:0px;">
				www.etecbauru.com<br />
				Desenvolvimento por 3º Info
				</p>
				</div>
			</div>
		</div>
	</body>
	
</html>