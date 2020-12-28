<?php
if($userDado->pri >= 9){
	if(isset($_GET['paginas'])){
		if($_GET['paginas'] == "criar"){
			include_once("../php/criacao_pagina.php");
		}else if((int)$_GET['paginas'] > 0){
			include_once("../php/edicao_pag.php");
		}
	}else
		include_once("../php/mais_paginas.php");
}else
	echo "Acesso negado";
?>