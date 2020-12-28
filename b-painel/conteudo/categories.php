<?php
if($userDado->pri >= 9){
	if(isset($_GET['action'])){
		
		if($_GET['action'] == "criar"){
			include_once("../php/criacao_categories.php");
		}else if((int)$_GET['action'] > 0){
			include_once("../php/edicao_categoria.php");
		}
	}
}else{
	echo "Acesso Negado";
}
?>