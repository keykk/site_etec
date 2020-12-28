<?php
	if($userDado->pri >= 9){
		if(isset($_GET['action'])){
			if((int)$_GET['action'] > 0){
				include_once("../php/edicao_wowslider.php");
			}else if($_GET['action'] == "ativos" || $_GET['action'] == "inativos"){
				include_once("../php/wow_atividade.php");
			}else
				include_once("../php/errorpag.php");
		}else{
			include_once("../php/errorpag.php");
		}
	}else
		echo "Acesso Negado";
?>