<?php
if($userDado->pri >= 9){
	if(isset($_GET['noticia'])){
		if($_GET['noticia'] == "criar"){
			include_once("../php/criacao_noticia.php");
		}else if((int)$_GET['noticia'] > 0){
			include_once("../php/edicao_noticia.php");
		}else if($_GET['noticia'] == "ativo_inativo"){
			include_once("../php/on_off.php");
		}
	}
}else
	echo "Acesso Negado";
?>