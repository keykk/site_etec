<?php
	if(isset($_GET['pg'])){
		
		$pa_id = (int) $_GET['pg'];
		
		if($pa_id > 0){
			$paginas->pagina_dados($pa_id,$raiz);
			if($paginas->retorno == 1){
				echo "<h1 title='{$paginas->titulo}'>".Encurtatitulo($paginas->titulo)."</h1>".$paginas->corpo;
				echo "<hr>";
				echo "<strong>Data de Criação: </strong>{$paginas->data} - <strong>Utima Edição: </strong>{$paginas->edicao}";
				echo "<br /><strong>Utimo editor: </strong> {$paginas->editor}";
			}
		}else
			include_once("php/errorpag.php");
	}else
		include_once("php/mais_paginas.php");
?>