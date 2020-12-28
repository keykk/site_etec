<?php
	$id = (int)$_GET['news'];
	
	if($id > 0){
		$noticias->noticia_unica($id);
		if($noticias->atividade == 1){
			echo "<h1>".$noticias->titulo."</h1>";
			echo "".$noticias->conteudo."<hr>";
			$categorias->categoria_unica($noticias->categoria);
			echo "<strong>Categoria: </strong>{$categorias->titulo}<br /><strong>De: </strong>{$noticias->data_on} <strong>Até: </strong>{$noticias->data_off} <strong>Enviado por: </strong>{$noticias->autoria}";
		}else
			echo "Noticia desativada";
	}else
		include_once("php/errorpag.php");
?>