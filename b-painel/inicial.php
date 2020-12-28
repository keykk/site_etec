<?php
include_once("cnf/config.php");
if(!isset($connnect))
	$connnect = Conexao::getInstance();
date_default_timezone_set('America/Sao_Paulo');
ob_start();
$raiz = "/site_etec/";
if(isset($_SESSION['etec_login']) && isset($_SESSION['etec_pass'])){
include_once("../class/dados_usuario.php");
include_once("../class/grupos_pagi.php");
include_once("../php/tratavalor.php");
include_once("../php/validacpf.php");
include_once("../php/integra_categoria.php");
include_once("../class/all_pagina.php");
include_once("../class/all_categoria.php");
include_once("../class/all_noticias.php");
include_once("../class/wow_slide.php");
include_once("../class/usuarios_malas.php");
$createGrupo = 1;
if($userDado->pri >= 5){
?>

<html>
	<head>
		<title>bPAINEL</title>
		<meta charset="utf-8"/>
		<script type="text/javascript" src="../js/jquery-1.9.1.js" charset="utf-8"></script>
		<script type="text/javascript" src="../js/jquery.maskedinput.min.js" charset="utf-8"></script>
		<link href='../fonts/cinzel.css' rel='stylesheet' type='text/css'>
		<link href="css/style-b.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" href="../images/bauru.ico">
		
		<script>
			$(document).ready(function(){
				$('#menu p').click(function(){
					$(this).next().toggle(500);
				});
			});
			
			jQuery(function($){
			   $("#date").mask("99/99/9999");
			   $(".datetime").mask("99/99/9999 99:99:99");
			   $("#cpf").mask("999.999.999-99");
			});
		</script>
	</head>
	
	<body>
		<div id="superdiv">
		
			<div id="menu">
			<p title="<?php echo ucfirst($userDado->apelido); ?>"><?php Encurtanome($userDado->apelido); ?></p>
			<div style="display:none;">
				<ul>
					<li><a href="?b-pagina=yo&action=mydados">Meus dados</a></li>
					<li><a href="?b-pagina=yo&action=minhapagina">Minha Pagina</a></li>
					<li><a style="color:red;" href="<?php echo $raiz; ?>logout.php">Desconectar</a></li>
				</ul>
			</div>
			<p>Painel</p>
			<div style="display:none;">
				<ul>
					<?php
					if($userDado->pri >=10){
						echo "<li><a href='?b-pagina=users&action=criar' style='color:red;'>Criar Usuario</a></li>";
					}
					?>
					<li><a href="<?php echo $raiz; ?>" target="_blank">Web site</a></li>
					<li><a href="?b-pagina=home">Home - Slider</a></li>
					<li><a href="?b-pagina=sliders&action=ativos">Sliders Ativos</a></li>
					<li><a href="?b-pagina=sliders&action=inativos">Sliders Inativos</a></li>
				</ul>
			</div>
			<?php
			if($userDado->pri >= 10){
			?>
			<p>Grupos</p>
			<div style="display:none;">
				<ul>
					<li><a href="?b-pagina=groups&action=criar" style="color:red;">Criar</a></li>
					<?php
						$gruposandpri = new all_groups;
						$gruposandpri->todosGrupos();
						
					?>
				</ul>
			</div>
			<?php
			}
			if($userDado->pri >= 9){
			?>
			<p>Categorias</p>
			<div style="display:none;">
				<ul>
					<li><a href="?b-pagina=categories&action=criar" style="color:red;">Criar</a></li>
					<?php
						$query_ca = $connnect->query("SELECT * FROM etec_categoria ORDER BY ca_titulo ASC LIMIT 0,5");
						$numrows = $query_ca->rowCount();
						if($numrows > 0){
							while($obj_ca = $query_ca->fetch(PDO::FETCH_OBJ)){
								echo "
									<li><a title='{$obj_ca->ca_titulo}' href='?b-pagina=categories&action={$obj_ca->ca_codigo}'>";
									echo Encurtatitulo_16($obj_ca->ca_titulo);
									echo "</a></li>
								";
							}
							if($numrows == 5){
								echo "
									<li><a href='#' style='color:red;'>Todos</a></li>
								";
							}
						}
					?>
				</ul>
			</div>
			<?php
			}
			?>
			<p>Paginas</p>
			<div style="display:none;">
				<ul>
					<li><a href="?b-pagina=conteudo&paginas=criar" style="color:red;">Criar</a></li>
					<?php
						lista_pagina("painel",$raiz);
					?>
				</ul>
			</div>
			<p>Noticias</p>
			
			<div style="display:none;">
				<ul>
					<li><a href="?b-pagina=integra&noticia=criar" style="color:red;">Criar</a></li>
					<li><a href="?b-pagina=integra&noticia=ativo_inativo&action=on">Ativados</a></li>
					<li><a href="?b-pagina=integra&noticia=ativo_inativo&action=off">Desativados</a></li>
				</ul>
			</div>
			</div>
			
			<div id="content">
			<div style="margin:15px;max-width:100%;">
			<?php
				if(isset($_GET['b-pagina'])){
					$ppag = filter_input(INPUT_GET,'b-pagina', FILTER_SANITIZE_STRING);						
					if(strlen($ppag) > 1 && file_exists("conteudo/{$ppag}.php")){
						include_once("conteudo/{$ppag}.php");
					}
					else
						include_once("conteudo/home.php");
				}else		
					include_once("conteudo/home.php");
			?>
			</div>
			</div>
			
			<div id="trist" style="display:table;width:97%;">
			<div style="float:left;margin:5px;padding:0px;display:table;">
					<img style="margin-top:0px;cursor:pointer;" src="../images/logo.png" height="45"/>
					<img style="margin:6px;cursor:pointer;" onclick="location.href='http://www.saopaulo.sp.gov.br/'" src="../images/splog.gif"/>
					<img style="margin:6px;cursor:pointer;" onclick="location.href='http://www.centropaulasouza.sp.gov.br/'" width="200" src="../images/CPS.png"/>
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
<?php
}
else
	header("location: ".$raiz);
}
else
	header("location: ".$raiz);